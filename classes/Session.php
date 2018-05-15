<?php

class Session {
	public static function exists($token_name) {
		return isset($_SESSION[$token_name]);
	}

	public static function put($name, $value) {
		// add $name with $value to sessions global variable
		return $_SESSION[$name] = $value;
	}
}
