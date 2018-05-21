<?php
require_once "core/init.php";

if (Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();
$msg = '';

if ($user->isLoggedIn()) {

	// greet user with logout option
	$msg = 'Hi, ' . escape($user->data()->username) . '. <a href="logout.php">Log out</a>.';

} else {

	// show login/register link
	$msg = 'Please <a href="login.php">log in</a> or <a href="register.php">register</a>.';

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home</title>
</head>
<body>
	<p><?php echo $msg; ?></p>
</body>
</html>
