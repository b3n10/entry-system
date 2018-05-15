<?php

class Session {
	public static function put($name, $value) {
		// add $name with $value to sessions global variable
		return $_SESSION[$name] = $value;
	}
}
