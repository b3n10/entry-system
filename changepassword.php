<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
} else {
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Change Password</title>
</head>
<body>

	<form action="" method="POST">

		<div class="field">
			<label for="password1">Password:</label>
			<input type="password" name="password1">
		</div>

		<div class="field">
			<label for="password2">Confirm Password:</label>
			<input type="password" name="password2">
		</div>

		<button type="submit">Update</button>
		or go back&nbsp;
		<a href="index.php">Home</a>

		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

	</form>

</body>
</html>
