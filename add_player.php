<?php
    require("common.php"); 
    
        $query = " 
            INSERT INTO players ( 
                user_id,
                player
                
            ) VALUES (
                :userid, 
                :player
            ) 
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid'],
            ':player' => $_POST['player']
            
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