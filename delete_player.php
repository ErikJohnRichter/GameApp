<?php 

    require("common.php"); 

    $playerId = $_GET['id'];
     
        $query = " 
            DELETE FROM players

            WHERE

            id=:playerid AND user_id=:userid
        "; 
         
        $query_params = array( 

            ':playerid' => $playerId,
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