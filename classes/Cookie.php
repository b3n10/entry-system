<?php

class Cookie {

	// Cookie::exists(cookie_name)
	public static function exists($cookie_name) {
		return (isset($_COOKIE[$cookie_name])) ? true : false;
	}

	// Cookie::get(cookie_name)
	public static function get($cookie_name) {
		return $_COOKIE[$cookie_name];
	}

	// Cookie::put(cookie_name, value, expiration)
	// create cookie
	public static function put($cookie_name, $value, $expiry) {
		if (setcookie($cookie_name, $value, time() + $expiry, '/')) {
			return true;
		}
		return false;
	}

	// Cookie::delete(cookie_name)
	public static function delete($cookie_name) {
		// reset cookie expiration to negative value
		self::put($cookie_name, '', time() - 1);
	}
}
