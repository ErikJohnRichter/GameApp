<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

        if ($_POST['bggUrl']) {
            $xmlurl = $_POST['bggUrl'];
            $partOne = explode('/', $xmlurl);
            $bggGameId = $partOne[4];
            $xmlurl = 'https://www.boardgamegeek.com/xmlapi/boardgame/'.$bggGameId.'?stats=1';
          $sxml = simplexml_load_file($xmlurl);

          $bggRating = $sxml->boardgame[0]->statistics->ratings->average;
          $bggDescription = $sxml->boardgame[0]->description;
          $bggMinPlayers = $sxml->boardgame[0]->minplayers;
          $bggMaxPlayers = $sxml->boardgame[0]->maxplayers;
          $bggPlayTime = $sxml->boardgame[0]->minplaytime;
          $bggPlayType = $sxml->boardgame[0]->boardgamesubdomain;
          /*$bggGameName = $sxml->boardgame[0]->name;*/
          $bggWeight = $sxml->boardgame[0]->statistics->ratings->averageweight;

          $bggImageThumb = $sxml->boardgame[0]->thumbnail;

          /*$xmlurl = 'https://www.boardgamegeek.com/xmlapi2/thing?id='.$bggGameId;
        $sxml = simplexml_load_file($xmlurl);
        $bggImageThumb = $sxml->item->thumbnail;*/
        $bggImageUrl = 'https:'.$bggImageThumb;
        $bggImageContent = file_get_contents($bggImageUrl);
        file_put_contents('./images/'.$bggGameId.'.jpg', $bggImageContent);
        }
        
        else {
            $bggGameId = null;
        }

        $playerDifference = $bggMinPlayers - $bggMaxPlayers;
        
        if ($_POST['bggUrl']) {
            if ($playerDifference == 0) {
                $players = $bggMinPlayers;
            }
            else {
                $players = $bggMinPlayers."-".$bggMaxPlayers;
            }

        }
        elseif ($_POST['maxPlayers'] != null) {
            $players = $_POST['minPlayers']."-".$_POST['maxPlayers'];
        }
        else {
            $players = $_POST['minPlayers'];
        }

        $query = " 
            INSERT INTO game_details ( 
                user_id,
                name, 
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
                bgg_type
                
            ) VALUES (
                :userid, 
                :name, 
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
                :bggtype
            ) 
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid'],
            ':name' => $_POST['name'],
            ':knowledge' => $_POST['knowledge'],
            ':type' => $_POST['type'],
            ':rating' => $_POST['rating'],
            ':players' => $players,
            ':cost' => $_POST['cost'],
            ':date' => $_POST['purchaseDate'],
            ':url' => $_POST['bggUrl'],
            ':rules' => $_POST['rules'],
            ':notes' => nl2br(htmlspecialchars($_POST['notes'], ENT_QUOTES)),
            ':rulesnotes' => nl2br(htmlspecialchars($_POST['rulesNotes'], ENT_QUOTES)),
            ':bggid' => $bggGameId,
            ':bggrating' => $bggRating,
            ':bggdescription' => $bggDescription,
            ':bggplaytime' => $bggPlayTime,
            ':bggweight' => $bggWeight,
            ':bggtype' => $bggPlayType
            
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

        header("Location: library.php"); 
        die("Redirecting to: library.php");
         
    } 
     
?> 