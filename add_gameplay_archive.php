<?php 

    require("common.php"); 
     
        $gameId = $_POST['id'];
        $gameName = $_POST['name'];
        $sort = $_POST['scoring'];

          if ($sort == 'desc') {
            $sort == 'desc'
          }
          elseif ($sort == 'asc') {
            $sort == 'asc'
          }
          elseif ($sort == 'money') {
            $sort = 'desc';
          }
          else {
            $sort = null;
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
                $recentTimestamp = $x['last_played'];
            }
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

        if($_POST['winning-score'] == null) {
            $winningScore = null;
        }
        else {
            $winningScore = $_POST['winning-score'];
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
            $playTime = $_POST['play-time'];
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
            ':winner' => $_POST['winner'],
            ':winningscore' => $winningScore,
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

        if ($players > 1 && $winningScore != null) {
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

            for ($i=2; $i<($players+1); $i++) {
                $extraPlayer = $_POST['player-'.$i];
                $extraPlayerScore = $_POST['player-'.$i.'-score'];
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
        }


        header("Location: game_details.php?id=".$gameId.""); 
        die("Redirecting to: game_details.php?id=".$gameId."");

     
?> 