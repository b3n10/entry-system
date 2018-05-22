<?php

require_once 'core/init.php';

$user = new User();

// if user is not logged in, redirect to home
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

// if form is submitted
if (Input::exists()) {

	// if token exists
	if (Token::check(Input::get('token'))) {

		// validate input
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			"name" => array(
				"required"	=> true,
				"min"				=> 2,
				"max"				=> 50
			)
		));

		// if input ok
		if ($validation->passed()) {

			try {

				$user->update(array(
					"name" => Input::get('name')
				));

				Session::flash('home', 'User info updated!');
				Redirect::to('index.php');

			} catch (Exception $e) {
				die($e->getMessage());
			}
			// if error, show error
		} else {

			foreach ($validation->errors() as $error) {
				echo $error . '<br>';
			}

		}

	}

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
		<a href="index.php">Home</a>
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</form>
</body>
</html>
