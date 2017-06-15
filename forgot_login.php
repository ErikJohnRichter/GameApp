<?php
    require("common.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>GameApp - Forgot Login</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Games, Manager, Boardgames" />
  <link rel="shortcut icon" sizes="196x196" href="assets/images/logo.png">
  <link rel="apple-touch-icon" href="assets/images/GameAppLogo2.png" />
	<link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/core.css">
	<link rel="stylesheet" href="assets/css/misc-pages.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
</head>
<body class="simple-page">
	<div class="simple-page-wrap">
		<div class="simple-page-logo">
			<a href="index.php">
				<span><i class="fa fa-gg"></i></span>
				<span>GameApp</span>
			</a>
		</div><!-- logo -->
		
<div class="simple-page-form" id="signup-form">
	<h4 class="form-title m-b-xl text-center">Enter your username and email</h4>
	<form action="send_new_password.php" method="post">
		<div class="form-group">
			<input id="sign-up-name" type="text" name="username" class="form-control" placeholder="Userame">
		</div>

		<div class="form-group">
			<input id="sign-up-email" type="email" name="email" class="form-control" placeholder="Email">
		</div>

		<input type="submit" class="btn btn-primary" value="SEND NEW PASSWORD">
	</form>
</div><!-- #login-form -->

<div class="simple-page-footer">
	<p>
    
    <a href="forgot_username.php">FORGOT USERNAME</a> <span style="color: #fff; padding: 10px;">|</span> <a href="index.php">SIGN IN</a>
  </p>
</div><!-- .simple-page-footer -->


	</div><!-- .simple-page-wrap -->
</body>
</html>