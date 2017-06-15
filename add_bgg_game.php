<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        $listType=$_POST['list'];

        if ($listType == 1) {
            $status = "Own";
        }
        elseif ($listType == 2) {
            $status = "Research";
        }
        else {
            $status = "";
        }

        $timestamp = date('Y-m-d G:i:s', strtotime('-5 hours'));

        $bggGameId = $_POST['id'];

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
            ':addsource' => 'BGG'
            
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
        SELECT * FROM game_details 
        WHERE 
            user_id = :userid
            ORDER BY timestamp desc
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
              $id = $x['id'];
          }
        }

        header("Location: game_details.php?id=".$id.""); 

        /*if ($listType == 1) {
            header("Location: library.php"); 
        }
        else {
            header("Location: wish_list.php"); 
        }*/

         die("Redirecting to: stats.php");
    } 
     
?> 