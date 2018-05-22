<?php

require_once 'core/init.php';

$user = new User();

// if user not logged in
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
// if user is logged in
} else {

	// check token
	if (Token::check(Input::get('token'))) {

		// if form submitted
		if (Input::exists()) {

			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				"password1"	=> array(
					"required"	=> true,
					"min"				=> 6,
					"max"				=> 20
				),
				"password2"	=> array(
					"matches"		=> "password1"
				)
			));

			if ($validation->passed()) {
				try {

					$user->update(array(
						'password'	=> Hash::make(Input::get('password1'), $user->data()->salt)
					));

					Session::flash('home', 'Successfully updated password!');
					Redirect::to('index.php');

				} catch (Exception $e) {
					die($e->getMessage());
				}
			} else {
				foreach ($validation->errors() as $error) {
					echo $error . '<br>';
				}
			}

		}

	}

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
