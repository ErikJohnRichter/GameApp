<?php 

    require("common.php"); 
     
        $gameId = $_POST['id'];
        
        $query = " 
            UPDATE game_details

            SET 
                linked_game=:linkedgame
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 

            ':linkedgame' => null,
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

        /*$query = " 
            UPDATE game_details

            SET 
                linked_game=:linkedgame
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 

            ':linkedgame' => $_POST['game-id'],
            ':gameid' => $_POST['linked-game'],
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
        } */

        header("Location: game_details.php?id=".$gameId.""); 
        die("Redirecting to: game_details.php?id=".$gameId."");

?> 