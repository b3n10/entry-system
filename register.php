<?php
require_once "core/init.php";

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			"username"	=> array(
				"required"	=> true,
				"min"				=> 2,
				"max"				=> 20,
				"unique"		=> "users" // unique in 'users' table
			),
			"password1"	=> array(
				"required"	=> true,
				"min"				=> 6,
			),
			"password2"	=> array(
				"required"	=> true,
				"matches"		=> "password1",
			),
			"name"			=> array(
				"required"	=> true,
				"min"				=> 2,
				"max"				=> 50
			)
		));

		if ($validation->passed()) {
			echo "Passed";
		} else {
			foreach ($validation->errors() as $error) {
				echo $error . "<br/>";
			}
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<form action="" method="POST">
		<div class="field">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" autocomplete="off" value="<?php echo escape(Input::get('username')); ?>">
		</div>
		<div class="field">
			<label for="password1">Password:</label>
			<input type="password" name="password1" id="password1">
		</div>
		<div class="field">
			<label for="password2">Repeat Password:</label>
			<input type="password" name="password2" id="password2">
		</div>
		<div class="field">
			<label for="name">Name:</label>
			<input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>">
		</div>

		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<button type="submit">Register</button>
	</form>
</body>
</html>

