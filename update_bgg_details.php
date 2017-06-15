<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        $bggGameId = $_POST['bgg-game-id'];

        if ($bggGameId != null) {
           
            $xmlurl = 'https://www.boardgamegeek.com/xmlapi/boardgame/'.$bggGameId.'?stats=1';
          $sxml = simplexml_load_file($xmlurl);

          $bggRating = $sxml->boardgame[0]->statistics->ratings->average;
          $bggDescription = $sxml->boardgame[0]->description;
          $bggMinPlayers = $sxml->boardgame[0]->minplayers;
          $bggMaxPlayers = $sxml->boardgame[0]->maxplayers;
          $bggMinPlayTime = $sxml->boardgame[0]->minplaytime;
          $bggMaxPlayTime = $sxml->boardgame[0]->maxplaytime;
          $bggPlayType = $sxml->boardgame[0]->boardgamesubdomain;
          $bggYear = $sxml->boardgame[0]->yearpublished;
          /*$bggGameName = $sxml->boardgame[0]->name;*/
          $bggWeight = $sxml->boardgame[0]->statistics->ratings->averageweight;

          $bggImageThumb = $sxml->boardgame[0]->thumbnail;

          /*$xmlurl = 'https://www.boardgamegeek.com/xmlapi2/thing?id='.$bggGameId;
        $sxml = simplexml_load_file($xmlurl);
        $bggImageThumb = $sxml->item->thumbnail;*/
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
        }
        
        else {
            $bggGameId = null;
        }

        if ($bggMaxPlayTime != 0) {
            $bggPlayTime = round((($bggMinPlayTime + $bggMaxPlayTime)/2));
        }
        else {
            $bggPlayTime = $bggMinPlayTime;
        }

        $timestamp = date('Y-m-d G:i:s', strtotime('-6 hours'));

        $playerDifference = $bggMinPlayers - $bggMaxPlayers;

            if ($playerDifference == 0) {
                $players = $bggMinPlayers;
            }
            else {
                $players = $bggMinPlayers."-".$bggMaxPlayers;
            }

        $query = " 
            UPDATE game_details

            SET 
                bgg_id=:bggid,
                players=:players,
                bgg_rating=:bggrating,
                bgg_playtime=:bggplaytime,
                bgg_description=:bggdescription,
                bgg_weight=:bggweight,
                bgg_type=:bggtype,
                bgg_year=:bggyear
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 

            ':bggid' => $bggGameId,
            ':players' => $players,
            ':bggrating' => $bggRating,
            ':bggplaytime' => $bggPlayTime,
            ':bggdescription' => $bggDescription,
            ':bggweight' => $bggWeight,
            ':bggtype' => $bggPlayType,
            ':bggyear' => $bggYear,
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