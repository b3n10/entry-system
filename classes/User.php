<?php

class User {
	private $_db,
					$_data,
					$_sessionName,
					$_cookieName,
					$_isLoggedIn;

	public function __construct($user = null) {

		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');

		// if User object instance has passed no $user
		// e.g. $user = new User();
		if (!$user) {

			// check if session exists (if a user is logged in)
			if (Session::exists($this->_sessionName)) {

				// this will be an id of $user
				$user = Session::get($this->_sessionName);

				// if $user is valid in users table
				if ($this->find($user)) {

					$this->_isLoggedIn = true;

				} else {

					// logged out

				}

			}

			// if $user is defined in the constructor
		} else {

			$this->find($user);

		}

	}

	public function create($fields = array()) {
		// if error on insert, throw exception
		if (!$this->_db->insert('users', $fields)) {
			throw new Exception('There was a problem creating user');
		}
	}

	public function find($username = null) {
		if ($username) {
			$field = (is_numeric($username)) ? 'id' : 'username';
			$data = $this->_db->get('users', array($field, '=', $username));

			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function login($username = null, $password = null, $remember = false) {

		// if no username & password were passed but data already retrieved
		if (!$username && !$password && $this->exists()) {

			// create session for user using id
			Session::put($this->_sessionName, $this->data()->id);

		} else {
			// if there is $username
			if ($this->find($username)) {

				// if password matches
				if ($this->data()->password === Hash::make($password, $this->data()->salt)) {

					// use id as value to create session
					Session::put($this->_sessionName, $this->data()->id);

					// if user checks the box for 'Remember Me'
					if ($remember) {

						$hash = Hash::unique();
						$hash_check = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

						// if no hash record for user_id
						if (!$hash_check->count()) {

							// insert hash to record for user_id
							$this->_db->insert('users_session', array(
								'user_id'	=> $this->data()->id,
								'hash'		=> $hash
							));

							// if hash record exist for user_id
						} else {

							// get current hash from record
							$hash = $hash_check->first()->hash;

						}

						// then create cookie
						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

					}

					return true;

				}
			}

			return false;

		}

	}

	// get data if already retrieved
	public function data() {
		return $this->_data;
	}

	// if data is already retrieved
	public function exists() {
		return (!empty($this->_data));
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}

	public function update($fields = array(), $id = null) {

		// if no $id is passed, it will use the id of current logged user
		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if (!$this->_db->update('users', $id, $fields)) {
			throw new Exception('There was a problem updating user!');
		}

		return true;
	}

	public function logout() {
		// delete sesssion and cookie
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);

		// delete hash (cookie) from db (security purposes if hacker gets hash)
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
	}

	public function hasPermission($key) {

		// get the current group of user via user_group
		$group = $this->_db->get('groups', array('id', '=', $this->data()->user_group));
	}
}
