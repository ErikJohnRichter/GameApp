<?php 

    require("common.php"); 
     
        $gameId = $_POST['id'];
        $gameName = $_POST['name'];

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
                $recentTimestamp = $x['last_played'];
                $sort = $x['highscore'];
            }
        }

        if ($sort == 'desc') {
            $sort == 'desc';
          }
          elseif ($sort == 'asc') {
            $sort == 'asc';
          }
          elseif ($sort == 'money') {
            $sort = 'desc';
          }
          else {
            $sort = null;
          }

        $netPlays = $netPlays + 1;
        if (!$_POST['playDate']) {
            $timestamp = date('Y-m-d G:i:s', strtotime('-5 hours'));
        }
        else {
            $timestamp = date('Y-m-d G:i:s', strtotime($_POST['playDate']));
        }

        if ($recentTimestamp == null){
            $recentTimestamp = $timestamp;
        } 
        elseif ($recentTimestamp < $timestamp) {
            $recentTimestamp = $timestamp;
        }

        

        if($_POST['players'] == null) {
            $players = null;
        }
        else {
            $players = $_POST['players'];
        }

        if($_POST['play-time'] == null) {
            $playTime = null;
        }
        else {
            $playTime = preg_replace('/[^0-9]/','',$_POST['play-time']);
        }

        $query = " 
            UPDATE game_details

            SET 
                last_played=:lastplayed,
                number_of_plays=:numberofplays
            
            WHERE

            id=:gameid AND  user_id=:userid
        "; 
         
        $query_params = array( 

            ':lastplayed' => $recentTimestamp,
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

        if($_POST['player-1-score'] == null) {
            $winningScore = null;
        }
        else {
            $winningScore = $_POST['player-1-score'];
        }

        //if 1 player, player is winner...copy and paste first following insert here
        if ($players == 1 || $players == null) {
            
            $query = " 
                INSERT INTO gameplay ( 
                    associated_gameplay,
                    user_id,
                    game_id, 
                    game_name,
                    location,
                    players,
                    winner,
                    winning_score,
                    losing_score,
                    extra_players,
                    extra_players_score,
                    play_time,
                    notes,
                    timestamp
                    
                ) VALUES (
                    :associatedgameplay,
                    :userid, 
                    :gameid, 
                    :gamename,
                    :location,
                    :players,
                    :winner,
                    :winningscore,
                    :losingscore,
                    :extraplayers,
                    :extraplayersscore,
                    :playtime,
                    :notes,
                    :timestamp
                ) 
            "; 
             
            $query_params = array( 
                ':associatedgameplay' => null,
                ':userid' => $_SESSION['userid'],
                ':gameid' => $gameId,
                ':gamename' => $gameName,
                ':location' => $_POST['location'],
                ':players' => $players,
                ':winner' => $_POST['player-1'],
                ':winningscore' => $winningScore,
                ':losingscore' => null,
                ':extraplayers' => null,
                ':extraplayersscore' => null,
                ':playtime' => $playTime,
                ':notes' => nl2br(htmlspecialchars($_POST['notes'], ENT_QUOTES)),
                ':timestamp' => $timestamp
                
                
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

        elseif ($players > 1 && $winningScore == null) {
            
            $playerArray = array();
            for ($i=2; $i<($players+1); $i++) {
                array_push($playerArray, $_POST['player-'.$i]);
            }

             $query = " 
                INSERT INTO gameplay ( 
                    associated_gameplay,
                    user_id,
                    game_id, 
                    game_name,
                    location,
                    players,
                    winner,
                    winning_score,
                    losing_score,
                    extra_players,
                    extra_players_score,
                    play_time,
                    notes,
                    timestamp
                    
                ) VALUES (
                    :associatedgameplay,
                    :userid, 
                    :gameid, 
                    :gamename,
                    :location,
                    :players,
                    :winner,
                    :winningscore,
                    :losingscore,
                    :extraplayers,
                    :extraplayersscore,
                    :playtime,
                    :notes,
                    :timestamp
                ) 
            "; 
             
            $query_params = array( 
                ':associatedgameplay' => null,
                ':userid' => $_SESSION['userid'],
                ':gameid' => $gameId,
                ':gamename' => $gameName,
                ':location' => $_POST['location'],
                ':players' => $players,
                ':winner' => $_POST['player-1'],
                ':winningscore' => null,
                ':losingscore' => null,
                ':extraplayers' => null,
                ':extraplayersscore' => null,
                ':playtime' => $playTime,
                ':notes' => nl2br(htmlspecialchars($_POST['notes'], ENT_QUOTES)),
                ':timestamp' => $timestamp
                
                
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

            if ($x['highscore'] != "coop") {

                $query = " 
                    SELECT * FROM gameplay 
                    WHERE 
                     user_id = :userid
                     ORDER BY id desc
                     LIMIT 1

                "; 
                 
                $query_params = array( 
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
                        $gameplayId = $x['id'];
                    }
                }

                //Place remaining players into db as extra players

                    
                foreach($playerArray as $k) { 
                    $extraPlayer = $k;

                    $query = " 
                        INSERT INTO gameplay ( 
                            associated_gameplay,
                            user_id,
                            game_id, 
                            game_name,
                            location,
                            players,
                            winner,
                            winning_score,
                            losing_score,
                            extra_players,
                            extra_players_score,
                            play_time,
                            notes,
                            timestamp
                            
                        ) VALUES (
                            :associatedgameplay,
                            :userid, 
                            :gameid, 
                            :gamename,
                            :location,
                            :players,
                            :winner,
                            :winningscore,
                            :losingscore,
                            :extraplayers,
                            :extraplayersscore,
                            :playtime,
                            :notes,
                            :timestamp
                        ) 
                    "; 
                     
                    $query_params = array( 
                        ':associatedgameplay' => $gameplayId, 
                        ':userid' => $_SESSION['userid'],
                        ':gameid' => $gameId,
                        ':gamename' => $gameName,
                        ':location' => null,
                        ':players' => null,
                        ':winner' => null,
                        ':winningscore' => null,
                        ':losingscore' => null,
                        ':extraplayers' => $extraPlayer,
                        ':extraplayersscore' => null,
                        ':playtime' => null,
                        ':notes' => null,
                        ':timestamp' => $timestamp
                        
                        
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
            }

        }

        elseif ($players > 1 && $winningScore != null) {
            //Parse through all scores and insert highest/lowest as winner
            $playerArray = array();
            for ($i=1; $i<($players+1); $i++) {
                $playerArray += array($_POST['player-'.$i] => $_POST['player-'.$i.'-score']);

                /*if($_POST['player-'.$i.'-score'] == null) {
                    $playerScore = null;
                }
                else {*/
                    //$playerScore = $_POST['player-'.$i.'-score'];
                //}

                //$playerArray[$i-1] = $playerScore;
            }

            if ($sort == "desc") {
                arsort($playerArray);
            }
            elseif ($sort == "asc") {
                asort($playerArray);
            }
            else {
                arsort($playerArray);
            }
            
            foreach($playerArray as $k => $v) { break; }
            $winner = $k;
            $winningScore = $v;
            array_shift($playerArray);

            $query = " 
                INSERT INTO gameplay ( 
                    associated_gameplay,
                    user_id,
                    game_id, 
                    game_name,
                    location,
                    players,
                    winner,
                    winning_score,
                    losing_score,
                    extra_players,
                    extra_players_score,
                    play_time,
                    notes,
                    timestamp
                    
                ) VALUES (
                    :associatedgameplay,
                    :userid, 
                    :gameid, 
                    :gamename,
                    :location,
                    :players,
                    :winner,
                    :winningscore,
                    :losingscore,
                    :extraplayers,
                    :extraplayersscore,
                    :playtime,
                    :notes,
                    :timestamp
                ) 
            "; 
             
            $query_params = array( 
                ':associatedgameplay' => null,
                ':userid' => $_SESSION['userid'],
                ':gameid' => $gameId,
                ':gamename' => $gameName,
                ':location' => $_POST['location'],
                ':players' => $players,
                ':winner' => $winner,
                ':winningscore' => $winningScore,
                ':losingscore' => null,
                ':extraplayers' => null,
                ':extraplayersscore' => null,
                ':playtime' => $playTime,
                ':notes' => nl2br(htmlspecialchars($_POST['notes'], ENT_QUOTES)),
                ':timestamp' => $timestamp
                
                
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
                 user_id = :userid
                 ORDER BY id desc
                 LIMIT 1

            "; 
             
            $query_params = array( 
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
                    $gameplayId = $x['id'];
                }
            }

            //Place remaining players into db as extra players

            for ($i=1; $i < ($players); $i++) {
                
                foreach($playerArray as $k => $v) { break; }
                $extraPlayer = $k;
                $extraPlayerScore = $v;
                if ($i == ($players - 1)) {
                    $losingScore = $v;
                }
                array_shift($playerArray);

                $query = " 
                    INSERT INTO gameplay ( 
                        associated_gameplay,
                        user_id,
                        game_id, 
                        game_name,
                        location,
                        players,
                        winner,
                        winning_score,
                        losing_score,
                        extra_players,
                        extra_players_score,
                        play_time,
                        notes,
                        timestamp
                        
                    ) VALUES (
                        :associatedgameplay,
                        :userid, 
                        :gameid, 
                        :gamename,
                        :location,
                        :players,
                        :winner,
                        :winningscore,
                        :losingscore,
                        :extraplayers,
                        :extraplayersscore,
                        :playtime,
                        :notes,
                        :timestamp
                    ) 
                "; 
                 
                $query_params = array( 
                    ':associatedgameplay' => $gameplayId, 
                    ':userid' => $_SESSION['userid'],
                    ':gameid' => $gameId,
                    ':gamename' => $gameName,
                    ':location' => null,
                    ':players' => null,
                    ':winner' => null,
                    ':winningscore' => null,
                    ':losingscore' => null,
                    ':extraplayers' => $extraPlayer,
                    ':extraplayersscore' => $extraPlayerScore,
                    ':playtime' => null,
                    ':notes' => null,
                    ':timestamp' => $timestamp
                    
                    
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

            $query = " 
            UPDATE gameplay

            SET 
                losing_score=:losingscore
            
            WHERE

            id=:gameplayid AND  user_id=:userid
            "; 
             
            $query_params = array( 

                ':losingscore' => $losingScore,
                ':gameplayid' => $gameplayId,
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


        header("Location: game_details.php?id=".$gameId.""); 
        die("Redirecting to: game_details.php?id=".$gameId."");

     
?> 