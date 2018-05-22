<?php

require_once 'core/init.php';

// check if $_GET['user'] is blank
if (!$username = Input::get('user')) {
	// send back to home if $_GET['user'] is blank
	Redirect::to('index.php');
} else {

	// pass $username to constructo to find user
	$user = new User($username);

	// check if user is on record
	if (!$user->exists()) {
		Redirect::to(404);
	} else {
		$data = $user->data();
	}

	echo '<h3>' . $data->username . '</h3>';
	echo '<p>Full name: ' . $data->name . '</p>';

	echo 'Back to <a href="index.php">Home</a>';
}
