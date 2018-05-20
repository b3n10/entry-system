<?php

class Cookie {

	// Cookie::exists(cookie_name)
	public static function exists($name) {
		return (isset($_COOKIE[$name])) ? true : false;
	}

	// Cookie::get(cookie_name)
	public static function get($name) {
		return $_COOKIE[$name];
	}

	// Cookie::put(cookie_name, value, expiration)
	public static function put($name, $value, $expiry) {
		// create cookie
	}

	// Cookie::delete(cookie_name)
	public static function delete($name) {
		// reset cookie expiration to negative value
	}
}
