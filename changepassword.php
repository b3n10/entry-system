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
				'current_password'	=> array(
					'required'	=> true,
					'min'				=> 6
				),
				'new_password'	=> array(
					'required'	=> true,
					'min'				=> 6
				),
				'confirm_password'	=> array(
					'required'	=> true,
					'matches'		=> 'new_password'
				)
			));

			if ($validation->passed()) {
				try {

					// check if current_password matches on record
					if (Hash::make(Input::get('current_password'), $user->data()->salt) !== $user->data()->password) {
						echo 'Current password incorrect!';
					} else {

						// update both password and salt
						$salt = Hash::salt(5);

						$user->update(array(
							'password'	=> Hash::make(Input::get('new_password'), $salt),
							'salt'			=> $salt
						));

						Session::flash('home', 'Successfully updated password!');
						Redirect::to('index.php');

					}

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
			<label for="current_password">Current Password:</label>
			<input type="password" name="current_password">
		</div>

		<div class="field">
			<label for="new_password">New Password:</label>
			<input type="password" name="new_password">
		</div>

		<div class="field">
			<label for="confirm_password">Confirm Password:</label>
			<input type="password" name="confirm_password">
		</div>

		<button type="submit">Update</button>
		or go back&nbsp;
		<a href="index.php">Home</a>

		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

	</form>

</body>
</html>
