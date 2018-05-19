<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Page</title>
</head>
<body>
	<form action="" method="POST">
		<div class="field">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" autocomplete="off">
		</div>
		<div class="field">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password">
		</div>

		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<button type="submit">Log in</button>
	</form>
</body>
</html>
