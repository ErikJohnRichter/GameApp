<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        $gameList = $_POST['game-list'];
        $query = " 
            DELETE FROM game_details

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

         
        
        if ($gameList == 1) {
            header("Location: library.php"); 
        }
        else {
            header("Location: wish_list.php"); 
        } 


        die("Redirecting to: library.php");

    } 
     
?> 