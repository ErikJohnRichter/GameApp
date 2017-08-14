<?php
    require("common.php"); 
    
        $query = " 
            UPDATE users

            SET 
                custom_filter=:customfilter
            
            WHERE
        
                id=:userid
        "; 
         
        $query_params = array( 
            ':customfilter' => $_POST['custom-string'],
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

        $_SESSION['customfilter'] = $_POST['custom-string'];

        header("Location: profile.php"); 
        die("Redirecting to: profile.php");

?>