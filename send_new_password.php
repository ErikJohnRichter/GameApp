<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

        $query = " 
            SELECT 
                *
            FROM users 
            WHERE 
                username = :username AND email = :email
        "; 
         
        $query_params = array( 
            ':username' => $_POST['username'],
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
            $id = $x['id'];
            $email = $x['email'];
            $username = $x['username'];

            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $guid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"

            $guid = substr($guid, 1, -1);


            $query = " 
              UPDATE users

              SET 
                  password = :password,
                  salt = :salt
              
              WHERE

              id=:userid 
            "; 

            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
             
            $password = hash('sha256', $guid . $salt); 
             
            for($round = 0; $round < 65536; $round++) 
            { 
                $password = hash('sha256', $password . $salt); 
            } 
             
            $query_params = array( 
                ':password' => $password, 
                ':salt' => $salt, 
                ':userid' => $id
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
          }

          $body = "";

          $emailTo = $email;

          $email = 'gameapp@codingerik.com';
          $replyTo = 'gameapp@codingerik.com';
          $subject = "GameApp Password Reset Instructions";
          $sendCopy = trim($_POST['sendCopy']);
          $body = '<html>Let\'s get you back into GameApp!';
          $body .= '<br><br>Click on the following link and follow the instructions to reset your password. Remember, this link contains a temporary password with access to your GameApp account. Do not share it with anyone.';
          $body .= '<br><a href="http://gameapp.codingerik.com/reset_password.php?username='.$username.'&guid='.$guid.'">Reset GameApp Password</a>';
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