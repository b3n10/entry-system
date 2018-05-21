<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Update User Info</title>
</head>
<body>
	<form action="" method="POST">
		<div class="field">
			<label>Old Name:</label>
			<span><?php echo escape($user->data()->name); ?></span>
		</div>
		<div class="field">
			<label for="name">New Name:</label>
			<input type="text" id="name" name="name">
		</div>
		<button type="submit">Update</button>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</form>
</body>
</html>
