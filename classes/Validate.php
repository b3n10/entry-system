<?php

class Validate {
	private $_passed	= false,
					$_errors	= array(),
					$_db			= null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()) {
		foreach ($items as $item => $rules) {
			// $item is the field name
			// $rules is an array of the field name
			foreach ($rules as $rule => $ruleValue) {

				$value = $source[$item];

				if ($rule === "required" && empty($value)) {
					$this->addError("{$item} is required");
				}

			}
		}
	}

	public function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}
}