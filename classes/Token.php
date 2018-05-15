<?php

class Token {
	public static function generate() {
		// generate a unique ID and use it for session variable
		return Session::put(Config::get('session/token_name'), md5(uniqid()));
	}

	// check if $token passed exists then delete
	// return true if success
	public static function check($token) {
		$token_name = Config::get('session/token_name');

		if (Session::exists($token_name) && $token === Session::get($token_name)) {
			Session::delete($token_name);
			return true;
		}

		return false;
	}
}
