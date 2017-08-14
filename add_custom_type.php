<?php
    require("common.php"); 
    
        $query = " 
            INSERT INTO custom_types ( 
                user_id,
                type
                
            ) VALUES (
                :userid, 
                :type
            ) 
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid'],
            ':type' => ucfirst($_POST['type'])
            
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

        header("Location: profile.php"); 
        die("Redirecting to: profile.php");

?>