<?php 

    require("common.php"); 
     
        $gameId = $_POST['game-id'];
        $gameplayId = $_POST['gameplay-id'];

        $query = " 
            DELETE FROM gameplay

            WHERE

            id=:gameplayid
            OR
            associated_gameplay=:gameplayid
        "; 
         
        $query_params = array( 

            ':gameplayid' => $gameplayId
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

        $query = " 
            SELECT * FROM gameplay 
            WHERE 
                game_id = :gameid AND user_id = :userid AND winner IS NOT null
                ORDER BY timestamp desc
                LIMIT 1

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

        $rows = $stmt->fetchAll();
        if ($rows) {
            foreach ($rows as $x) {
                $timestamp = $x['timestamp'];
            }
        }
        else {
            $timestamp = null;
        }

        $query = " 
            SELECT * FROM game_details 
            WHERE 
                id = :gameid AND user_id = :userid

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

        $rows = $stmt->fetchAll();
        if ($rows) {
            foreach ($rows as $x) {
                $netPlays = $x['number_of_plays'];
            }
        }

        $netPlays = $netPlays - 1;

        $query = " 
            UPDATE game_details

            SET 
                last_played=:lastplayed,
                number_of_plays=:numberofplays

            
            WHERE

            id=:gameid AND  user_id=:userid
        "; 
         
        $query_params = array( 
            ':lastplayed' => $timestamp,
            ':numberofplays' => $netPlays,
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

        

        header("Location: game_details.php?id=".$gameId.""); 
        die("Redirecting to: game_details.php?id=".$gameId."");

     
?> 