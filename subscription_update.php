<?php
    require("common.php"); 
    
    if (isset($_POST['subscription'])) {

        $subscription = 1;
    }
    else {

       $subscription = null;
    }
    

        $query = " 
            UPDATE users

            SET 
                is_subscribed=:subscription
            
            WHERE
        
                id=:userid
        "; 
         
        $query_params = array( 
            ':subscription' => $subscription,
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

        header("Location: settings.php"); 
        die("Redirecting to: settings.php");

?>