<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

        if (strpos($_POST['bgg-players'], "-")) {

            $myplayersarray = explode("-", $_POST['bgg-players']);
            $minPlayers = $myplayersarray[0];
            $maxPlayers = $myplayersarray[1];
        }
        else {

            $minPlayers = $_POST['bgg-players'];
            $maxPlayers = $_POST['bgg-players'];
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

            ':myplayers' => $_POST['bgg-players'],
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

        header("Location: game_details.php?id=".$_POST['game-id'].""); 
        die("Redirecting to: game_details.php?id=".$_POST['game-id']."");

    } 
     
?> 