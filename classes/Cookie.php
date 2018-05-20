<?php

class Cookie {

	public static function exists($name) {
		return (isset($_COOKIE[$name])) ? true : false;
	}

}
