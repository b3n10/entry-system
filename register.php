<?php
require_once "core/init.php";

if (Input::exists()) {
	// Preventing Cross-Site Request Forgery
	// to make sure user clicks register/submit form and not pass data to URL
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
			$user = new User();
			$salt = Hash::salt(5);

			try {
				$user->create(array(
					'username'		=> Input::get('username'),
					'password'		=> Hash::make(Input::get('password'), $salt),
					'salt'				=> $salt, // without salt, original password cannot (or will have difficult time) be compared
					'name'				=> Input::get('name'),
					'date_joined'	=> date('Y-m-d H:i:s'),
					'user_group'	=> 1
				));
			} catch (Exception $e) {
				// but much better to redirect to page showing error
				die($e->getMessage());
			}
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

