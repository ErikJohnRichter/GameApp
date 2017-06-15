<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        $query = " 
            SELECT 
                * 
            FROM users 
            WHERE 
                id = :id 
        "; 
       
        $query_params = array( 
            ':id' => $_SESSION['userid']
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
                $oldEmail = $x['email'];
                $oldUsername = $x['username']; 
            }
        } 

        if(empty($_POST['new-admin-username'])) 
        { 
            die("Please enter a username."); 
        } 
         
        if(empty($_POST['new-admin-password'])) 
        { 
            die("Please enter a password."); 
        }
        elseif ($_POST['new-admin-password'] != $_POST['new-admin-password-confirm'])
        {
            die("Passwords do not match.");
        }

        /*if(!isset($_POST['agree'])) 
        {
            die("Please check that you agree to Familinks's Terms."); 
        }*/
         
        if(!filter_var($_POST['new-admin-email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
         
        $query = " 
            SELECT 
                * 
            FROM users 
            WHERE 
                username = :username 
        "; 
       
        $query_params = array( 
            ':username' => $_POST['new-admin-username'] 
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
                if ($x['username'] != $oldUsername) {
                    die("This username is already in use");
                } 
            }
        } 
         
        $query = " 
            SELECT 
                * 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['new-admin-email'] 
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
                if ($x['email'] != $oldEmail) {
                    die("This email address is already registered");
                } 
            }
        } 

        $query = " 
            UPDATE users

            SET 
                username = :newusername,
                password = :password,
                salt = :salt,
                email = :email
            
            WHERE

            id=:userid 
        "; 

        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
         
        $password = hash('sha256', $_POST['new-admin-password'] . $salt); 
         
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 
         
        $query_params = array( 
            ':newusername' => $_POST['new-admin-username'],
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['new-admin-email'],
            ':userid' => $_SESSION['userid']
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
            ':username' => $_POST['new-admin-username'] 
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
            $check_password = hash('sha256', $_POST['new-admin-password'] . $row['salt']); 
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
        
             
            header("Location: stats.php"); 
            die("Redirecting to: stats.php"); 
        } 
        else 
        { 
            echo'<div class="text-center">
            <h3>bummer! that didn\'t work...try again.<h3>
            </div>'; 
            
            $submitted_username = htmlentities($_POST['new-admin-username'], ENT_QUOTES, 'UTF-8'); 
        } 

    } 
     
?> 