<?php
    require("common.php");

    if ($_SESSION['user'] != NULL){
        header("Location: stats.php"); 
        die("Redirecting to: stats.php"); 
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Games, Manager, Boardgames" />
  <link rel="shortcut icon" sizes="196x196" href="assets/images/logo.png">
  <link rel="apple-touch-icon" href="assets/images/GameAppLogoIcon.png" />
  <title>GameApp</title>
  <link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/core.css">
  <link rel="stylesheet" href="assets/css/misc-pages.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
</head>
<body class="simple-page" style="background-color: #6a6c6f;">
  <div class="simple-page-wrap">
    <div class="simple-page-logo">
      <a href="index.php">
        <span><i class="fa fa-gg"></i></span>
        <span>GameApp</span>
      </a>
    </div><!-- logo -->
    <div class="simple-page-form" id="login-form">
  <!--<h4 class="form-title m-b-xl text-center">Sign In With Your GameApp Account</h4>-->
  <form action="login.php" method="post">
    <div class="form-group">
      <input name="username" type="text" class="form-control" placeholder="Username" value="<?php echo $_COOKIE['game-username']; ?>">
    </div>

    <div class="form-group">
      <input name="password" type="password" class="form-control" placeholder="Password" value="<?php echo $_COOKIE['game-password']; ?>">
    </div>

    <div class="form-group m-b-xl">
      <div class="checkbox checkbox-primary">
        <input type="checkbox" name="remember" id="keep_me_logged_in" value=""<?php if ($_COOKIE['game-remember']) { echo "checked"; } ?>/>
        <label for="keep_me_logged_in">Keep me signed in</label>
      </div>
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="SIGN IN">
  </form>
</div><!-- #login-form -->

<div class="simple-page-footer text-center">
  <p><a href="forgot_login.php">FORGOT YOUR PASSWORD?</a></p>
  <p>
    <br>
    
    <a href="signup.php">CREATE AN ACCOUNT</a> <span style="color: #fff; padding: 10px;">|</span> <a href="welcome.html">WHAT IS THIS?</a> 
  </p>
</div>--><!-- .simple-page-footer -->


  </div><!-- .simple-page-wrap -->
</body>
</html>