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
			foreach ($rules as $rule_name => $rule_value) {

				// $_POST["username"] is value from textbox "username"
				$value = trim($source[$item]);

				// if it's required rule and value is empty
				if ($rule_name === "required" && empty($value)) {

					$this->addError("{$item} is required");

				} else if (!empty($value)) {

					switch ($rule_name) {

					// min rule
					case "min":
						if (strlen($value) < $rule_value) {
							$this->addError("{$item} must be minimum of {$rule_value} characters long.");
						}
						break;

					// max rule
					case "max":
						if (strlen($value) > $rule_value) {
							$this->addError("{$item} must be maximum of {$rule_value} characters long.");
						}
						break;

					// matches rule
					case 'matches':
						if ($value != $source[$rule_value]) {
							$this->addError("{$rule_value} must match {$item}");
						}
						break;

					// unique rule
					case 'unique':
						$check = $this->_db->get($rule_value, array($item, "=", $value));
						if ($check->count()) {
							$this->addError("{$item} is already taken.");
						}
						break;

					}
				}

			}
		}

		if (empty($this->_errors)) {
			// if _errors array has no value, meaning no field name is added on the array or not blank
			$this->_passed = true;
		}

		return $this;
	}

	public function addError($error) {
		// add $error to $_errors array
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}
}
