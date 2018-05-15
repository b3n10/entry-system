<?php

class Session {
	public static function exists($token_name) {
		return isset($_SESSION[$token_name]);
	}

	// add $name with $value to sessions global variable
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}

	// check if exists then unset session variable
	public static function delete($token_name) {
		if (self::exists($token_name)) {
			unset($_SESSION[$token_name]);
		}
	}
}
