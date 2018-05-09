<?php
// The singleton pattern is used to restrict the instantiation of a class to a single object, which can be useful when only one object is required across the system.
// _ in $_variable is a notation that it is private

class DB {
	private static $_instance = null;
	private $_pdo, // store PDO
					$_query, // the last SQL executed
					$_error = false, // if $_query failed
					$_results, // store the results of $_query
					$_count = 0;

	private function __construct() {
		try {
			$this->_pdo = new PDO("mysql:host=" . Config::get("mysql/host") . ";dbname=" . Config::get("mysql/db"), Config::get("mysql/username"), Config::get("mysql/password"));
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
	}

	// using singleton method
	public static function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
}
