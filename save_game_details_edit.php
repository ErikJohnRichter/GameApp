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


        $listType = $_POST['list-type'];

        $timestamp = date('Y-m-d G:i:s', strtotime('-6 hours'));


        if ($_POST['status'] == "Want") {
            $query = " 
                SELECT COUNT(*) 
                FROM game_details
                WHERE wishlist_order IS NOT null AND user_id = :userid AND list_type = :listtype;
            "; 
             
            $query_params = array( 
                ':userid' => $_SESSION['userid'],
                ':listtype' => 2
            ); 
             
            try 
            { 
                $result = $db->prepare($query); 
                $result->execute($query_params); 
                $wishlistGameCount = $result->fetchColumn(0);
            } 
            catch(PDOException $ex) 
            { 
                die($ex); 
            } 

            $wishlistOrder = $wishlistGameCount + 1;
        }
        else {
            $wishlistOrder = null;
        }
        

        if ($_POST['knowledge'] != "oldCustom") {
            $query = " 
                UPDATE game_details

                SET 
                    list_type=:listtype,
                    wishlist_order=:wishlistorder,
                    gameplay_knowledge=:knowledge,
                    type=:type,
                    type2=:type2,
                    cost=:cost,
                    purchase_date=:date,
                    highscore=:highscore,
                    status=:status,
                    my_players=:myplayers,
                    min_players=:minplayers,
                    max_players=:maxplayers,
                    play_with=:playwith,
                    my_playtime=:myplaytime
                
                WHERE

                id=:gameid AND user_id = :userid
            "; 
             
            $query_params = array( 
                ':listtype' => $_POST['list-type'],
                ':wishlistorder' => $wishlistOrder,
                ':knowledge' => $_POST['knowledge'],
                ':type' => $_POST['type'],
                ':type2' => $_POST['type2'],
                ':cost' => $_POST['cost'],
                ':date' => $_POST['purchaseDate'],
                ':highscore' => $_POST['highscore'],
                ':status' => $_POST['status'],
                ':myplayers' => $players,
                ':minplayers' => $minPlayers,
                ':maxplayers' => $maxPlayers,
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

        if ($_POST['status'] != "Want" && $_POST['status'] != null) {

            $query = " 
                SELECT COUNT(*) 
                FROM game_details
                WHERE wishlist_order IS NOT null AND user_id = :userid AND list_type=2;
            "; 
             
            $query_params = array( 
                ':userid' => $_SESSION['userid']
            ); 
             
            try 
            { 
                $result = $db->prepare($query); 
                $result->execute($query_params); 
                $wishlistGameCount = $result->fetchColumn(0);
            } 
            catch(PDOException $ex) 
            { 
                die($ex); 
            } 



            $query = " 
                SELECT * FROM game_details 
                WHERE 
                    wishlist_order IS NOT null AND
                    user_id = :userid
                    AND list_type = :listtype
                ORDER BY wishlist_order asc
            "; 
             
            $query_params = array( 
                ':userid' => $_SESSION['userid'],
                ':listtype' => 2
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
                $count = 1;
                foreach ($rows as $x) {

                    if ($count <= $wishlistGameCount) {
                      $query = " 
                           UPDATE game_details 

                            SET 
                                wishlist_order = :order
                            
                            WHERE

                            id=:gameid AND user_id=:userid
                        "; 
                         
                        $query_params = array( 

                            ':order' => $count,
                            ':gameid' => $x['id'],
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
                        
                        $count = $count + 1;
                    }
                }
                
            }
        }

        header("Location: game_details.php?id=".$_POST['game-id'].""); 
        die("Redirecting to: game_details.php?id=".$_POST['game-id']."");

    } 
     
?> 