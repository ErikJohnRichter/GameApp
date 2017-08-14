<?php 

    require("common.php"); 

    $gameId = $_GET['id'];
     
        $query = " 
            DELETE FROM search_history

            WHERE

            visited_game_id=:gameid AND user_id=:userid
        "; 
         
        $query_params = array( 

            ':gameid' => $gameId,
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

         
        
       
        header("Location: search_history.php"); 
        die("Redirecting to: search_history.php");

     
?> 