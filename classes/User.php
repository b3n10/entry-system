<?php

class User {
	private $_db,
					$_data,
					$_sessionName;

	public function __construct($user = null) {
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
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

	public function login($username, $password) {
		// if there is $username
		if ($this->find($username)) {
			// if password matches
			if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
				// use id as value to create session
				Session::put($this->_sessionName, $this->data()->id);
				return true;
			}
		}
		return false;
	}

	private function data() {
		return $this->_data;
	}
}
