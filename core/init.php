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
		"cookie_expiry"	=> 86400 // 1 day = 1 * 24 hr * 60 min * 60 sec
	),
	"session" => array(
		"session_name"	=> "user",
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

// if cookie is set but session is not
// e.g. if user closed the browser but checked the 'remember me' box
if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {

	// get cookie value for 'hash'
	$hash = Cookie::get(Config::get('remember/cookie_name'));

	// check if hash value is stored in record
	$hash_check = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	// if hash value matches on record
	if ($hash_check->count()) {
		echo 'user should be logged in.';
	}
}
