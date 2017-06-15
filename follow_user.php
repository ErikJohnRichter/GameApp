<?php 

    require("common.php"); 

        $followingId = $_POST['following-id'];
        $followingUsername = $_POST['following-username'];
     
        $query = " 
            INSERT INTO following ( 
                follower,
                following,
                following_username
                
            ) VALUES (
                :follower, 
                :following,
                :followingusername
            ) 
        "; 
         
        $query_params = array( 
            ':follower' => $_SESSION['userid'],
            ':following' => $followingId,
            ':followingusername' => $followingUsername
            
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

        $query = " 
            SELECT 
                *
            FROM users 
            WHERE 
                id = :followingid
        "; 
         
        $query_params = array( 
            ':followingid' => $followingId
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
            $first = $x['first'];
            $subscribed = $x['is_subscribed'];
          }

          if ($first != null && $first != "") {
            $greetingName = $first;
          }
          else {
            $greetingName = $followingUsername;
          }


          if ($subscribed == 1) {
              $body = "";

              $emailTo = $email;

              $email = 'gameapp@codingerik.com';
              $replyTo = 'gameapp@codingerik.com';
              $subject = "You have a new GameApp follower!";
              $sendCopy = trim($_POST['sendCopy']);
              $body = '<html>Hey '.ucfirst($greetingName).'!<br><br><b>'.ucfirst($_SESSION['username']).'</b> just started following you on GameApp!';
              $body .= '<br><br>If your Game Library and/or Wishlist is private, this person will not be able to see anything except for your name and picture. However, if your game lists are public, <b>'.ucfirst($_SESSION['username']).'</b> will be able to see limited details on them, including your custom Quick Rules.';
              $body .= '<br><br>To see more information about your account privacy or to make your game lists public, <a href="http://gameapp.codingerik.com/settings.php">visit your Settings page</a> for more details.';
              $body .= '<br><br>Happy playing!';
              $body .='<br><br>-----<br><small>This is an automated email sent by <a href="http://gameapp.codingerik.com">GameApp</a>. Do not reply.<br><br>To unsubscribe from these emails, please <a href="http://gameapp.codingerik.com/unsubscribe.php?email='.$emailTo.'">click here</a> to quickly unsubscribe.</small></html>';
              $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
              $headers .= 'From: ' .' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $replyTo;

              mail($emailTo, $subject, $body, $headers);
          }
        }

        header("Location: user_details.php?username=".$followingUsername.""); 
        die("Redirecting to: user_details.php?username=".$followingUsername."");

     
?> 