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


        $listType = $_POST['list-type'];

        $timestamp = date('Y-m-d G:i:s', strtotime('-6 hours'));

        if ($_POST['knowledge'] != "oldCustom") {
            $query = " 
                UPDATE game_details

                SET 
                    list_type=:listtype,
                    gameplay_knowledge=:knowledge,
                    type=:type,
                    cost=:cost,
                    purchase_date=:date,
                    highscore=:highscore,
                    status=:status,
                    my_players=:myplayers,
                    play_with=:playwith,
                    my_playtime=:myplaytime
                
                WHERE

                id=:gameid AND user_id = :userid
            "; 
             
            $query_params = array( 
                ':listtype' => $_POST['list-type'],
                ':knowledge' => $_POST['knowledge'],
                ':type' => $_POST['type'],
                ':cost' => $_POST['cost'],
                ':date' => $_POST['purchaseDate'],
                ':highscore' => $_POST['highscore'],
                ':status' => $_POST['status'],
                ':myplayers' => $players,
                ':playwith' => $_POST['playwith'],
                ':myplaytime' => $_POST['playtime'],
                ':gameid' => $_POST['game-id'],
                ':userid' => $_SESSION['userid']
            ); 
        }
        else {
           $query = " 
                UPDATE game_details

                SET 
                    list_type=:listtype,
                    type=:type,
                    cost=:cost,
                    purchase_date=:date,
                    highscore=:highscore,
                    status=:status,
                    my_players=:myplayers,
                    play_with=:playwith,
                    my_playtime=:myplaytime
                
                WHERE

                id=:gameid AND user_id = :userid
            "; 
             
            $query_params = array( 
                ':listtype' => $_POST['list-type'],
                ':type' => $_POST['type'],
                ':cost' => $_POST['cost'],
                ':date' => $_POST['purchaseDate'],
                ':highscore' => $_POST['highscore'],
                ':status' => $_POST['status'],
                ':myplayers' => $players,
                ':playwith' => $_POST['playwith'],
                ':myplaytime' => $_POST['playtime'],
                ':gameid' => $_POST['game-id'],
                ':userid' => $_SESSION['userid']
            );  
        }
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die($ex);
        } 

        if ($_POST['bgg-player-integration'] == 0) {
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

        if ($_POST['bgg-playtime-integration'] == 0) {
            $query = " 
                UPDATE game_details

                SET 
                    bgg_playtime=:myplaytime
                
                WHERE

                id=:gameid AND user_id = :userid
            "; 
             
            $query_params = array( 

                ':myplaytime' => $_POST['playtime'],
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