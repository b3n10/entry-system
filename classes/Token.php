<?php

class Token {
	public static function generate() {
		// generate a unique ID and use it for session variable
		return Session::put(Config::get('session/token_name'), md5(uniqid));
	}
}
