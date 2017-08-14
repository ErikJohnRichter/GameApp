<?php 

    require("common.php"); 
     
    $submitted_username = ''; 
     
    if(!empty($_POST)) 
    { 
        if (isset($_POST['remember'])) {
            setcookie("game-username",$_POST['username'], time()+ (365 * 24 * 60 * 60));
            setcookie("game-password",$_POST['password'], time()+ (365 * 24 * 60 * 60));
            setcookie("game-remember",true, time()+ (365 * 24 * 60 * 60));
        }
        else {
            setcookie("game-username","", time()-3600);
            setcookie("game-password","", time()-3600);
            setcookie("game-remember",false, time()-3600);
        }

        $query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt, 
                email,
                picture,
                first,
                custom_filter,
                save_state,
                square_1,
                square_2,
                square_3
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Sorry, there was an error. Please try again.");
            
            /*die("Failed to run query: " . $ex->getMessage()); */
        } 
         
        $login_ok = false; 
         
        $row = $stmt->fetch(); 
        if($row) 
        { 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
            { 
                $login_ok = true; 
            } 
        } 
         
        if($login_ok) 
        { 
            unset($row['salt']); 
            unset($row['password']); 
             
            $_SESSION['user'] = $row;
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['picture'] = $row['picture'];
            $_SESSION['first'] = $row['first'];
            $_SESSION['customfilter'] = $row['custom_filter'];
            $_SESSION['savestate'] = $row['save_state'];
            $_SESSION['square1'] = $row['square_1'];
            $_SESSION['square2'] = $row['square_2'];
            $_SESSION['square3'] = $row['square_3'];

            header("Location: stats.php"); 
            die("Redirecting to: stats.php"); 
        } 
        else 
        { 
            echo'<div class="text-center">
            <h3>bummer! that didn\'t work...try again.<h3>
            </div>'; 
            
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
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
  <h4 class="form-title m-b-xl text-center">Whoops! Something went wrong. Please try again.</h4>
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
  <!--<p><a href="password-forget.html">FORGOT YOUR PASSWORD ?</a></p>
  <p>-->
    <br>
    
    <a href="signup.php">CREATE AN ACCOUNT</a> <span style="color: #fff; padding: 10px;">|</span> <a href="index_help.php">WHAT IS THIS?</a> 
  </p>
</div>--><!-- .simple-page-footer -->


  </div><!-- .simple-page-wrap -->
</body>
</html>