<?php
    require("common.php"); 
     
   
   $query = " 
    DELETE FROM bgg_hotlist WHERE id > 0;
    "; 
     
    $query_params = array( 
        
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
             
    
    $xmlurl1 = 'https://www.boardgamegeek.com/xmlapi2/hot?type=boardgame';
    $sxml1 = simplexml_load_file($xmlurl1);
    $number = 1;
    foreach($sxml1->item as $game)
        {
          
          if ($number > 30) {
            break;
          }

          $gameName = $game->name->attributes()->value;
          $gameId = $game->attributes()->id;

            $bggUrl = 'https://boardgamegeek.com/boardgame/'.$gameId;
            $xmlurl = 'https://www.boardgamegeek.com/xmlapi/boardgame/'.$gameId.'?stats=1';
            $sxml = simplexml_load_file($xmlurl);
            
            //$bggRating = $sxml->boardgame[0]->statistics->ratings->average;
            //$bggDescription = $sxml->boardgame[0]->description;
            //$bggMinPlayers = $sxml->boardgame[0]->minplayers;
            //$bggMaxPlayers = $sxml->boardgame[0]->maxplayers;
            //$bggMinPlayTime = $sxml->boardgame[0]->minplaytime;
            //$bggMaxPlayTime = $sxml->boardgame[0]->maxplaytime;
            //$bggPlayType = $sxml->boardgame[0]->boardgamesubdomain;
            //$bggWeight = $sxml->boardgame[0]->statistics->ratings->averageweight;
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


            file_put_contents('./images/'.$gameId.'.jpg', $bggImageContent);

            /*if ($bggMaxPlayTime != 0) {
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
            }*/
            $number++;

             $query = " 
            INSERT INTO bgg_hotlist ( 
                name, 
                url, 
                bgg_id,
                bgg_year
                
            ) VALUES (
                :name, 
                :url,
                :bggid,
                :bggyear
            ) 
	        "; 
	         
	        $query_params = array( 
	            ':name' => $gameName,
	            ':url' => $bggUrl,
	            ':bggid' => $gameId,
	            ':bggyear' => $bggYear
	            
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
            sleep(3);

        }

            
?>
