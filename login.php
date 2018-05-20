<?php
require_once 'core/init.php';

if (Input::exists()) {
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username'	=> array(
				'required'	=> true,
				'min'				=> 2,
				'max'				=> 20
			),
			'password'	=> array(
				'required'	=> true,
				'min'				=> 6
			)
		));

		if ($validation->passed()) {

			$user = new User();
			$login = $user->login(Input::get('username'), Input::get('password'));

			if ($login) {
				Redirect::to('index.php');
			} else {
				echo 'Failed';
			}

		} else {
			foreach ($validation->errors() as $error) {
				echo '<p>' . $error . '</p>';
			}
		}
	}
}
?>

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
		<button type="submit">Log in</button> or <a href="register.php">Register</a>
	</form>
</body>
</html>
