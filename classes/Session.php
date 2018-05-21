<?php

class Session {
	// Session::exists
	public static function exists($token_name) {
		return isset($_SESSION[$token_name]);
	}

	// Session::put
	// add $name with $value to sessions global variable (or create a session)
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}

	// Session::get
	public static function get($token_name) {
		return $_SESSION[$token_name];
	}

	// Session::delete
	// check if exists then unset session variable
	public static function delete($token_name) {
		if (self::exists($token_name)) {
			unset($_SESSION[$token_name]);
		}
	}

	// Session::flash
	// show success msg after registration
	public static function flash($token_name, $string = '') {
		// if session exists, delete then return it
		if (self::exists($token_name)) {
			$session = self::get($token_name);
			self::delete($token_name);
			return $session;
		} else {
			// otherwise, set it
			self::put($token_name, $string);
		}
	}
}
