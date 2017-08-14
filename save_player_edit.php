<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

        if ($_POST['minPlayers'] == $_POST['maxPlayers']) {
            $players = $_POST['minPlayers'];
        }
        elseif ($_POST['maxPlayers'] != null) {
            $players = $_POST['minPlayers']."-".$_POST['maxPlayers'];
        }
        else {
            $players = $_POST['minPlayers'];
        }

        $minPlayers = $_POST['minPlayers'];
        $maxPlayers = $_POST['maxPlayers'];

        if (!$_POST['maxPlayers']) {
            $maxPlayers = $_POST['minPlayers'];
        }
        
        $query = " 
            UPDATE game_details

            SET 
                my_players=:myplayers,
                min_players=:minplayers,
                max_players=:maxplayers
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 

            ':myplayers' => $players,
            ':minplayers' => $minPlayers,
            ':maxplayers' => $maxPlayers,
            ':gameid' => $_POST['game-id'],
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

        if ($_POST['bgg-integration'] == 0) {
            $query = " 
                UPDATE game_details

                SET 
                    players=:myplayers
                
                WHERE

                id=:gameid AND user_id = :userid
            "; 
             
            $query_params = array( 

                ':myplayers' => $players,
                ':gameid' => $_POST['game-id'],
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
        }

        header("Location: game_details.php?id=".$_POST['game-id'].""); 
        die("Redirecting to: game_details.php?id=".$_POST['game-id']."");

    } 
     
?> 