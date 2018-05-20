<?php

class User {
	private $_db,
					$_data;

	public function __construct($user = null) {
		$this->_db = DB::getInstance();
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
	}

	public function login($username, $password) {

		return false;
	}
}
