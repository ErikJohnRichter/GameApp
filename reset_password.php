<?php 

    require("common.php"); 
     
        $submitted_username = ''; 
     
        $query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt, 
                email,
                picture,
                custom_filter
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        $query_params = array( 
            ':username' => $_GET['username'] 
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
            $check_password = hash('sha256', $_GET['guid'] . $row['salt']); 
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
            $_SESSION['customfilter'] = $row['custom_filter'];
        } 
        else 
        { 
            echo'<div class="text-center">
            <h3>bummer! that didn\'t work...try again.<h3>
            </div>'; 
            
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    
     
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GameApp - Change Password</title>
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
            <a href="index.html">
                <span><i class="fa fa-gg"></i></span>
                <span>GameApp</span>
            </a>
        </div><!-- logo -->
        
<div class="simple-page-form" id="signup-form">
    <h4 class="form-title m-b-xl text-center">Enter a new password and click "Save New Password"</h4>
    <form action="change-admin-credentials.php" method="post">
        
            <input type="hidden" id="sign-up-name" name="new-admin-username" class="form-control" placeholder="Userame" value="<?php echo $row['username']; ?>">
       
            <input type="hidden" id="sign-up-email" type="email" name="new-admin-email" class="form-control" placeholder="Email" value="<?php echo $row['email']; ?>">

        <div class="form-group">
            <input id="sign-up-password" type="password" name="new-admin-password" class="form-control" placeholder="Enter new password">
        </div>
        <div class="form-group">
            <input id="sign-up-password-confirm" type="password" name="new-admin-password-confirm" class="form-control" placeholder="Confirm password">
        </div>

        <!--<div class="form-group m-b-xl">
            <div class="checkbox checkbox-primary">
                <input type="checkbox" id="keep_me_logged_in"/>
                <label for="keep_me_logged_in">Keep me signed in</label>
            </div>
        </div>-->
        <input type="submit" class="btn btn-primary" value="SAVE NEW PASSWORD">
    </form>
</div><!-- #login-form -->


    </div><!-- .simple-page-wrap -->
</body>
</html>