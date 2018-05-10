<?php
// establish db connection using singleton method
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

	public function query($sql, $params = array()) {
		// prepare the sql
		// default empty array for $params
		$this->_error = false; // reset if there is prev error

		if ($this->_query = $this->_pdo->prepare($sql)) {

			$pos = 1; // position of index to bind
			if (count($params)) {
				foreach ($params as $param) {
					$this->_query->bindValue($pos, $param);
					$pos++; // increment position or go to next index to bind
				}
			}

			// if execute is okay
			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ); // fetch the PDO object results
				$this->_count = $this->_query->rowCount();
			} else {
				// error if failed to execute
				$this->_error = true;
			}
		}

		return $this; // return instance/object of the class
	}

	public function error () {
		return $this->_error;
	}
}
