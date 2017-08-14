<?php 

    require("common.php"); 
     
     $query = " 
        SELECT * FROM game_details 
        WHERE 
            bgg_id IS NOT null
            AND publisher IS null
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

    $rows = $stmt->fetchAll();
    if ($rows) {
        foreach ($rows as $x) {
            
            $gameId = $x['id'];
            $bggGameId = $x['bgg_id'];
            
               
            $xmlurl = 'https://www.boardgamegeek.com/xmlapi/boardgame/'.$bggGameId.'?stats=1';
            $sxml = simplexml_load_file($xmlurl);

         
            $bggPublisher = $sxml->boardgame[0]->boardgamepublisher[0];

            if ($bggPublisher) {
                $publisher = $bggPublisher;
            }
            else {
                $publisher = null;
            }
           

            $query = " 
                UPDATE game_details

                SET 
                    publisher=:publisher
                
                WHERE

                id=:gameid 
            "; 
             
            $query_params = array( 

                ':publisher' => $publisher,
                ':gameid' => $gameId
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

            echo $gameId.", ";

            
        }
    }

       
     
?> 