<?php
require_once 'core/init.php';
error_reporting(0);
if (Input::exists()) {
	if (isset($_POST['submit-signup-btn'])) {
		$validate = new Validate();
		$validate->check($_POST, array(
			'name' => array(
				'name' => 'Name',
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'username' => array(
				'name' => 'Username',
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'
			),
			'password' => array(
				'name' => 'Password',
				'required' => true,
				'min' => 6
			)
		));
		if ($validate->passed()) {
			$user = new User();
			$salt = Hash::salt(32);
			try {
				$user->create(array(
					'name' => Input::get('name'),
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'joined' => date('Y-m-d H:i:s'),
					'group' => 1
				));
				Session::flash('register', 'You have signed up successfully!');
				Redirect::to('register.php');
			} catch(Exception $e) {
				// echo $e->getTraceAsString(), '<br>';
			}
		} else {
			foreach ($validate->errors() as $error) {
				echo '<script type="text/javascript">alert("'.$error.'");</script>';
			}
		}
	} else if (isset($_POST['submit-signin-btn'])) {
		$validate = new Validate();
		$validate->check($_POST, array(
			'username' => array('required' => true),
			'password' => array('required' => true)
		));
		if($validate->passed()) {
			$user = new User();
			$login = $user->login(Input::get('username'), Input::get('password'));
			if($login) {
				Session::flash('login', 'You have signed in successfully!');
				Redirect::to('login.php');
			} else {
				echo '<script language="javascript">';
				echo 'alert("Incorrect username or password")';
				echo '</script>';
			}
		} else {
			foreach($validate->errors() as $error) {
				echo '<script type="text/javascript">alert("'.$error.'");</script>';
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>TEST TASK</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
</head>
<body>
	<div class="login-reg-panel">
		<div class="login-info-box">
			<h2>Have an account?</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt urna ut commodo venenatis. Aenean sed elit erat. Mauris.</p>
			<label id="label-register" for="log-reg-show">Login</label>
			<input type="radio" name="active-log-panel" id="log-reg-show"  checked="checked">
		</div>
		<div class="register-info-box">
			<h2>Don't have an account?</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus tincidunt urna ut commodo venenatis. Aenean sed elit erat. Mauris.</p>
			<label id="label-login" for="log-login-show">Register</label>
			<input type="radio" name="active-log-panel" id="log-login-show">
		</div>
		<div class="white-panel">
			<div class="login-show">
				<h2 id="sign-in">LOGIN</h2>
				<img id="logo" src="assets/img/logo.png">
				<form action="" method="post">
					<div class="field">
						<label for='username'>Username<font color="red">*</font></label>
						<input type="text" name="username" id="login-username">
						<div class="signin-mail-icon"></div>
					</div>
					<div class="field">
						<label for='password'>Password<font color="red">*</font></label>
						<input type="password" name="password" id="login-password">
						<div class="signin-lock-icon"></div>
					</div>
					<input type="submit" name="submit-signin-btn" id="submit-signin-btn" value="Login">
				</form>
				<a href="">Forgot password?</a>
			</div>
			<div class="register-show">
				<h2 id="sign-up">SIGN UP</h2>
				<img id="logo" src="assets/img/logo.png">
				<form action="" method="post">
					<div class="field">
						<label for="name">Name</label>
						<input type="text" name="name" id="register-name">
						<div class="name-icon"></div>
					</div>
					<div class="field">
						<label for="username">Email</label>
						<input type="text" name="username" id="register-username">
						<div class="register-mail-icon"></div>
					</div>
					<div class="field">
						<label for="password">Password</label>
						<input type="password" name="password" id="register-password">
						<div class="register-lock-icon"></div>
					</div>
					<input type="submit" name="submit-signup-btn" id="submit-signup-btn" value="Register">
				</form>
			</div>
		</div>
	</div>
	<div class="footer">ALL RIGHT RESERVED "MAGEBIT" 2020.</div>
	<script>
		$(document).ready(function(){
			$('.login-info-box').fadeOut("slow");
			$('.login-show').addClass('show-log-panel');
		});
		$('.login-reg-panel input[type="radio"]').on('change', function() {
			if($('#log-login-show').is(':checked')) {
				$('.register-info-box').fadeOut("slow");
				$('.login-info-box').fadeIn("slow");               
				$('.white-panel').addClass('right-log');
				$('.register-show').addClass('show-log-panel');
				$('.login-show').removeClass('show-log-panel');
			}
			else if($('#log-reg-show').is(':checked')) {
				$('.register-info-box').fadeIn("slow");
				$('.login-info-box').fadeOut("slow"); 
				$('.white-panel').removeClass('right-log');
				$('.login-show').addClass('show-log-panel');
				$('.register-show').removeClass('show-log-panel');
			}
		});
	</script>
</body>
</html>