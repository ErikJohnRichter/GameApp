<?php 

    require("common.php"); 

    $userId = $_POST['user-id'];

    if(ucfirst($_POST['confirm']) == "Delete") {
     
        $query = " 
            DELETE FROM custom_types

            WHERE

            user_id=:userid
        "; 
         
        $query_params = array( 

            ':userid' => $userId
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
            DELETE FROM following

            WHERE

            follower=:userid OR following=:userid
        "; 
         
        $query_params = array( 

            ':userid' => $userId
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
            DELETE FROM game_details

            WHERE

            user_id=:userid
        "; 
         
        $query_params = array( 

            ':userid' => $userId
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
            DELETE FROM gameplay

            WHERE

            user_id=:userid
        "; 
         
        $query_params = array( 

            ':userid' => $userId
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
            DELETE FROM players

            WHERE

            user_id=:userid
        "; 
         
        $query_params = array( 

            ':userid' => $userId
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
            DELETE FROM rating_scale

            WHERE

            user_id=:userid
        "; 
         
        $query_params = array( 

            ':userid' => $userId
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
            DELETE FROM users

            WHERE

            id=:userid
        "; 
         
        $query_params = array( 

            ':userid' => $userId
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

         
        
        setcookie("game-username","", time()-3600);
        setcookie("game-password","", time()-3600);
        setcookie("game-remember",false, time()-3600);
     
        unset($_SESSION['user']); 
       
        header("Location: index.php"); 
        die("Redirecting to: index.php");
    }
    else {
        echo "You need to confirm you want to delete your account by typing 'Delete' on the previous page and then clicking Delete.<br>";
        echo "<a href='delete_user_account.php'>Back</a>";
    }

     
?> 