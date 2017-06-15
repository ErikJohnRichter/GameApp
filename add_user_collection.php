<?php 

ignore_user_abort(true);
set_time_limit(900);


    require("common.php"); 
    session_write_close();
     
    if(!empty($_POST)) 
    { 
        $query = " 
            UPDATE users

            SET 
                job=:job
            
            WHERE

            id = :userid
        "; 
         
        $query_params = array( 
            ':job' => 1,
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

        
        
        $timestamp = date('Y-m-d G:i:s', strtotime('-5 hours'));

        $gameCollectionIds = $_POST['ids'];

        $bggList = $_POST['bgg-list'];
        if ($bggList == "Own") {
            $listType=1;
            $status = "Own";
            $knowledge = "Need Rules";
        }
        else {
            $listType=2;
            $status = "Want";
        }

        $idsToAdd = array();

        foreach ($gameCollectionIds as $bggId) {
            $query = " 
            SELECT COUNT(*) 
            FROM game_details
            WHERE user_id = :userid AND bgg_id=:gameid;
            "; 
             
            $query_params = array( 
                ':gameid' => $bggId,
                ':userid' => $_SESSION['userid']
            ); 
             
            try 
            { 
                $result = $db->prepare($query); 
                $result->execute($query_params); 
                $exists = $result->fetchColumn(0);
            } 
            catch(PDOException $ex) 
            { 
                die($ex); 
            } 

            if (!$exists) {
                array_push($idsToAdd, $bggId);
            }
        }

        foreach ($idsToAdd as $bggGameId) {

            $bggUrl = 'https://boardgamegeek.com/boardgame/'.$bggGameId;
            $xmlurl = 'https://www.boardgamegeek.com/xmlapi/boardgame/'.$bggGameId.'?stats=1';
            $sxml = simplexml_load_file($xmlurl);
            foreach ($sxml->boardgame[0]->name as $primary) {
                if ((string) $primary['primary'] == 'true') {
                    $bggGameName = $primary;
                }
            }
            $bggRating = $sxml->boardgame[0]->statistics->ratings->average;
            $bggDescription = $sxml->boardgame[0]->description;
            $bggMinPlayers = $sxml->boardgame[0]->minplayers;
            $bggMaxPlayers = $sxml->boardgame[0]->maxplayers;
            $bggMinPlayTime = $sxml->boardgame[0]->minplaytime;
            $bggMaxPlayTime = $sxml->boardgame[0]->maxplaytime;
            $bggPlayType = $sxml->boardgame[0]->boardgamesubdomain;
            $bggWeight = $sxml->boardgame[0]->statistics->ratings->averageweight;
            $bggYear = $sxml->boardgame[0]->yearpublished;
            $bggImageThumb = $sxml->boardgame[0]->thumbnail;
            $bggImageUrl = 'https:'.$bggImageThumb;
            
        /*// Create a stream
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            'header'=>"Referer: https://boardgamegeek.com/"
          )
        );

        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $bggImageContent = file_get_contents($bggImageUrl, false, $context);*/


        $bggImageContent = file_get_contents($bggImageThumb);

        
            file_put_contents('./images/'.$bggGameId.'.jpg', $bggImageContent);

            if ($bggMaxPlayTime != 0) {
                $bggPlayTime = round((($bggMinPlayTime + $bggMaxPlayTime)/2));
            }
            else {
                $bggPlayTime = $bggMinPlayTime;
            }

            $playerDifference = $bggMinPlayers - $bggMaxPlayers;

            if ($playerDifference == 0) {
                $players = $bggMinPlayers;
            }
            else {
                $players = $bggMinPlayers."-".$bggMaxPlayers;
            }

            $query = " 
                INSERT INTO game_details ( 
                    user_id,
                    list_type,
                    name, 
                    timestamp,
                    gameplay_knowledge, 
                    type, 
                    rating, 
                    players, 
                    cost, 
                    purchase_date,
                    url, 
                    rules,
                    notes,
                    rules_notes,
                    bgg_id,
                    bgg_rating,
                    bgg_description,
                    bgg_playtime,
                    bgg_weight,
                    bgg_type,
                    bgg_year,
                    status,
                    my_playtime,
                    my_players,
                    add_source
                    
                ) VALUES (
                    :userid, 
                    :listtype,
                    :name, 
                    :timestamp,
                    :knowledge, 
                    :type, 
                    :rating, 
                    :players, 
                    :cost, 
                    :date, 
                    :url,
                    :rules,
                    :notes,
                    :rulesnotes,
                    :bggid,
                    :bggrating,
                    :bggdescription,
                    :bggplaytime,
                    :bggweight,
                    :bggtype,
                    :bggyear,
                    :status,
                    :myplaytime,
                    :myplayers,
                    :addsource
                ) 
            "; 
             
            $query_params = array( 
                ':userid' => $_SESSION['userid'],
                ':listtype' => $listType,
                ':name' => $bggGameName,
                ':timestamp' => $timestamp,
                ':knowledge' => "Need Rules",
                ':type' => "",
                ':rating' => "",
                ':players' => $players,
                ':cost' => "",
                ':date' => "",
                ':url' => $bggUrl,
                ':rules' => "",
                ':notes' => "",
                ':rulesnotes' => "",
                ':bggid' => $bggGameId,
                ':bggrating' => $bggRating,
                ':bggdescription' => $bggDescription,
                ':bggplaytime' => $bggPlayTime,
                ':bggweight' => $bggWeight,
                ':bggtype' => $bggPlayType,
                ':bggyear' => $bggYear,
                ':status' => $status,
                ':myplaytime' => $bggPlayTime,
                ':myplayers' => $players,
                ':addsource' => 'Import'
                
            ); 
             
            try 
            { 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex) 
            { 
                //die($ex);
            } 
            sleep(3);
        }

        $query = " 
            UPDATE users

            SET 
                job=:job
            
            WHERE

            id = :userid
        "; 
         
        $query_params = array( 
            ':job' => null,
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
     
?> 