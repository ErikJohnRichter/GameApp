<?php 

    require("common.php"); 

    $typeId = $_GET['id'];
     
        $query = " 
            DELETE FROM custom_types

            WHERE

            id=:typeid AND user_id=:userid
        "; 
         
        $query_params = array( 

            ':typeid' => $typeId,
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