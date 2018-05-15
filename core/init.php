<?php
// init.php will be included on every page created

session_start();

$GLOBALS["config"] = array(
	"mysql" => array(
		"host"			=> "127.0.0.1", // DNS is needed instead of localhost
		"username"	=> "root",
		"password"	=> "jairah",
		"db"				=> "entry_system"
	),
	"remember" => array(
		"cookie_name"		=> "hash",
		"cookie_expiry"	=> 86400 // 1 day * 24 hr * 60 min * 60 sec
	),
	"session" => array(
		"session_name"	=> "user"
		"token_name"		=> "token"
	)
);

// standard php library = spl
spl_autoload_register(function($class) {
	// only require classes needed
	// usage: $db = new DB();
	// "new DB" is like running this function where $class is "DB"
	require_once "classes/" . $class . ".php";
});

// include functions in functions directory
require_once "functions/sanitize.php";
