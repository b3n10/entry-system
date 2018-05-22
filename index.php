<?php
require_once "core/init.php";

if (Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home</title>
</head>
<body>
<?php if ($user->isLoggedIn()): ?>
<p>
	Hi, <?php echo escape($user->data()->name); ?>
</p>
<ul>
	<li><a href="update.php">Update</a></li>
	<li><a href="changepassword.php">Change Password</a></li>
	<li><a href="logout.php">Log out</a></li>
</ul>
	<?php
		echo '<ul>You permissions are:';

		if ($user->hasPermission('admin')) {
			echo '<li>admin</li>';
		}

		if ($user->hasPermission('moderator')) {
			echo '<li>mod</li>';
		}

		if (!$user->hasPermission('admin') && !$user->hasPermission('moderator')) {
			echo '<li>standard</li>';
		}

		echo '</ul>';
	?>
<?php else: ?>
<p>
	Please <a href="login.php">log in</a> or <a href="register.php">register</a>
</p>
<?php endif ?>
</body>
</html>
