<?php

class Hash {
	public static function make($string, $salt = '') {
		// adds a random generated string to the password
		// 'password = '12345'
		// adding a random word on the password will change it's hash
		// 'passwordDFDRERERR' = '888'
		// use sha256 then pass the $string concatenated with $salt
		return hash('sha256', $string . $salt);
	}

	public static function salt($length) {
		return mcrypt_create_iv($length);
	}
}
