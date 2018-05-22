<?php

require_once 'core/init.php';

// check if $_GET['user'] is blank
if (!$username = Input::get('user')) {
	// send back to home if $_GET['user'] is blank
	Redirect::to('index.php');
}
