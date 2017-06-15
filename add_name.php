<?php
    require("common.php"); 
    
        $query = " 
            UPDATE users

            SET 
                first=:first,
                last=:last
            
            WHERE
        
                id=:userid
        "; 
         
        $query_params = array( 
            ':first' => ucfirst($_POST['first']),
            ':last' => ucfirst($_POST['last']),
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

        header("Location: profile.php"); 
        die("Redirecting to: profile.php");

?>