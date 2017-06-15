<?php
    require("common.php"); 
    
    $email = $_GET['email'];

        $query = " 
            UPDATE users

            SET 
                is_subscribed=:subscription
            
            WHERE
        
                email=:email
        "; 
         
        $query_params = array( 
            ':subscription' => null,
            ':email' => $email
            
            
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

        header("Location: unsubscribed_confirmation.php"); 
        die("Redirecting to: settings.php");

?>