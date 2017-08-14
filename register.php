<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        if(empty($_POST['username'])) 
        { 
            die("Please enter a username."); 
        } 
         
        if(empty($_POST['password'])) 
        { 
            die("Please enter a password."); 
        }
        elseif ($_POST['password'] != $_POST['password-confirm'])
        {
            die("Passwords do not match.");
        }

        /*if(!isset($_POST['agree'])) 
        {
            die("Please check that you agree to Familinks's Terms."); 
        }*/
         
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
         
        $query = " 
            SELECT 
                1 
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
            die($ex); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This username is already in use"); 
        } 
         
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This email address is already registered"); 
        } 
         
        $query = " 
            INSERT INTO users ( 
                username, 
                password, 
                salt, 
                email,
                picture,
                is_subscribed,
                save_state,
                square_1,
                square_2,
                square_3,
                register_date
                
                
            ) VALUES ( 
                :username, 
                :password, 
                :salt, 
                :email,
                :picture,
                :issubscribed,
                :savestate,
                :square1,
                :square2,
                :square3,
                :registerdate
               
                
            ) 
        "; 
         
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
         
        $password = hash('sha256', $_POST['password'] . $salt); 

        $timestamp = date('Y-m-d G:i:s', strtotime('-5 hours'));
         
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 
        
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email'],
            ':picture' => "user.png",
            ':issubscribed' => 1,
            ':savestate' => 0,
            ':square1' => "Players",
            ':square2' => "My Rating",
            ':square3' => "Playtime",
            ':registerdate' => $timestamp
            
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die($ex);
        } 

        $xml = new DOMDocument();

        $documentPath = "./livesearch/".$_POST['username'].".xml";

        $xml->save($documentPath);

        /*$userName = $_POST['username'];

        $query = " 
            CREATE TABLE `data_generator`.`configurations-".$userName."` (
                id INT NOT NULL AUTO_INCREMENT,
                config LONGTEXT NOT NULL,
                name VARCHAR(45) NOT NULL,
                PRIMARY KEY (id)
        )"; 

        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Sorry, there was an error. Please try again.");
        } */
         
        /*header("Location: index.php"); 
         
        die("Redirecting to index.php"); */

        $query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt, 
                email,
                picture,
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
            $_SESSION['customfilter'] = $row['custom_filter'];
            $_SESSION['savestate'] = $row['save_state'];
            $_SESSION['square1'] = $row['square_1'];
            $_SESSION['square2'] = $row['square_2'];
            $_SESSION['square3'] = $row['square_3'];

            $body = "";

              $emailTo = "erik.j.richter@gmail.com";

              $email = 'erik@erikrichter.com';
              $replyTo = 'erik@erikrichter.com';
              $subject = "New GameApp Registration";
              $body = '<html>'.$_SESSION['username'].' just signed up for GameApp as User #'.$_SESSION['userid'].'.';
              $body .='<br><br><br>-----<br>This is an automated email sent by <a href="http://admin.erikrichter.com">ErikRichter Admin</a>. Do not reply.<br></html>';
              $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
              $headers .= 'From: ' .' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $replyTo;

              mail($emailTo, $subject, $body, $headers);

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
    <title>GameApp - Register</title>
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
    <h4 class="form-title m-b-xl text-center">Whoops! Something went wrong. Please try again.</h4>
    <form action="register.php" method="post">
       <!-- <div class="form-group">
            <input id="sign-up-first" style="width: 49%; display: inline-block;" type="text" name="first" class="form-control" placeholder="First Name">
        
            <input id="sign-up-last" style="width: 49%; display: inline-block;" type="text" name="last" class="form-control" placeholder="Last Name">
        </div>-->

        <div class="form-group">
            <input id="sign-up-name" type="text" name="username" class="form-control" placeholder="Userame">
        </div>

        <div class="form-group">
            <input id="sign-up-email" type="email" name="email" class="form-control" placeholder="Email">
        </div>

        <div class="form-group">
            <input id="sign-up-password" type="password" name="password" class="form-control" placeholder="Password">
        </div>

        <div class="form-group">
            <input id="sign-up-password-confirm" type="password" name="password-confirm" class="form-control" placeholder="Confirm Password">
        </div>

        <!--<div class="form-group m-b-xl">
            <div class="checkbox checkbox-primary">
                <input type="checkbox" id="keep_me_logged_in"/>
                <label for="keep_me_logged_in">Keep me signed in</label>
            </div>
        </div>-->
        <input type="submit" class="btn btn-primary" value="REGISTER">
    </form>
</div><!-- #login-form -->

<div class="simple-page-footer">
    <p>
        <small>Do you have an account ?</small>
        <a href="index.php">SIGN IN</a>
    </p>
</div><!-- .simple-page-footer -->


    </div><!-- .simple-page-wrap -->
</body>
</html>