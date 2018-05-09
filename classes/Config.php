<?php

class Config {
	// default value is null if nothing is passed
	public static function get($path = null) {
		$config = $GLOBALS["config"];
		$path = explode("/", $path); // explode will make an array from $path using delimeter "/"

		foreach ($path as $p) {
			if (isset($config[$p])) { // if $p exists on the $config array
				$config = $config[$p]; // set $config to 1st dimenssional value ($p) of the array (config["mysql]")
			}
		}

		return $config;
	}
}
