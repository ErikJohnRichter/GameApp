<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

        $query = " 
            SELECT 
                *
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
         
       $rows = $stmt->fetchAll();
        if ($rows) {
          foreach ($rows as $x) {
            $email = $x['email'];
            $username = $x['username'];
          }

          $body = "";

          $emailTo = $email;

          $email = 'gameapp@codingerik.com';
          $replyTo = 'gameapp@codingerik.com';
          $subject = "GameApp Username";
          $sendCopy = trim($_POST['sendCopy']);
          $body = '<html>Let\'s get you back into GameApp!';
          $body .= '<br><br>Your GameApp username is: <b>'.$username.'</b>';
          $body .= '<br><br>Return to <a href="http://gameapp.codingerik.com">GameApp</a> to sign in.';
          $body .='<br><br><br>-----<br>This is an automated email sent by <a href="http://gameapp.codingerik.com">GameApp</a>. Do not reply.<br></html>';
          $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          $headers .= 'From: ' .' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $replyTo;

          mail($emailTo, $subject, $body, $headers);

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
  <link rel="apple-touch-icon" href="assets/images/GameAppLogo2.png" />
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
    <div class="simple-page-form text-center" id="login-form">
  <h4 class="form-title text-center">Great! Check your email for further instructions...</h4><br>
  <small class="text-center">If you don't see something in your Inbox, it may have been delivered to your Junk Folder</small>
  
</div><!-- #login-form -->



  </div><!-- .simple-page-wrap -->
</body>
</html>