<?php

class User {
	private $_db,
					$_data,
					$_sessionName,
					$_isLoggedIn;

	public function __construct($user = null) {

		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');

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

	public function login($username, $password, $remember) {

		// if there is $username
		if ($this->find($username)) {

			// if password matches
			if ($this->data()->password === Hash::make($password, $this->data()->salt)) {

				// use id as value to create session
				Session::put($this->_sessionName, $this->data()->id);

				if ($remember) {

					$hash = Hash::unique();
					$hash_check = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

					// if there is no hash record for the user_id
					if (!$hash_check->count()) {

						// insert hash record for user_id
						$this->_db->insert('users_session', array(
							'user_id'	=> $this->data()->id,
							'hash'		=> $hash
						));

						// if hash record exist for user_id
					} else {

						// get the current hash from record
						$hash = $hash_check->first()->hash;

					}

				}

				return true;

			}
		}
		return false;
	}

	public function data() {
		return $this->_data;
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}

	public function logout() {
		Session::delete($this->_sessionName);
	}

}
