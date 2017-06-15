<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        
        $query = " 
            DELETE FROM wish_list

            WHERE

            id=:gameid
        "; 
         
        $query_params = array( 

            ':gameid' => $_POST['game-id']
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

         
        
        header("Location: wish_list.php"); 
        die("Redirecting to: wish_list.php");

    } 
     
?> 