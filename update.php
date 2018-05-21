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
			<label for="name">New Name:</label>
			<input type="text" name="name" value="<?php echo escape($user->data()->name); ?>">
			<button type="submit">Update</button>
		</div>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</form>
</body>
</html>
