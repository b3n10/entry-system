<?php
require_once "core/init.php";

if (Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();

if ($user->isLoggedIn()) {

	echo 'Hi, ' . escape($user->data()->username);
	echo '<br><a href="logout.php">Log out</a>.';

} else {

	echo 'Please <a href="login.php">log in</a> or <a href="register.php">register</a>.';

}
