<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        if ($_POST['list-type']) {
            $listType = $_POST['list-type'];
        }
        else {
            $listType = 2;
        }

        $timestamp = date('Y-m-d G:i:s', strtotime('-5 hours'));

        if (!$_POST['bggUrl']) {
            if ($_POST['searchBgg']) {
                $urlName = str_replace(" ","%20",$_POST['name']);
                $xmlurl = 'https://www.boardgamegeek.com/xmlapi/search?search='.$urlName.'&exact=1';
                $sxml = simplexml_load_file($xmlurl);
                $bggName = $sxml->boardgame[0]->name;
                $matchingNames = (strtolower($_POST['name']) == strtolower($bggName));

                if ($matchingNames) {
                    $bggGameId = $sxml->boardgame[0]->attributes()->objectid;
                    $bggUrl = 'https://boardgamegeek.com/boardgame/'.$bggGameId;
                }
            }
        }
        
        if ($_POST['bggUrl']) {
            $bggUrl = $_POST['bggUrl'];
            $xmlurl = $_POST['bggUrl'];
            $partOne = explode('/', $xmlurl);
            $bggGameId = $partOne[4];
        }
        
        if ($bggUrl) {
            $xmlurl = 'https://www.boardgamegeek.com/xmlapi/boardgame/'.$bggGameId.'?stats=1';
            $sxml = simplexml_load_file($xmlurl);
            $bggRating = $sxml->boardgame[0]->statistics->ratings->average;
            $bggDescription = $sxml->boardgame[0]->description;
            $bggMinPlayers = $sxml->boardgame[0]->minplayers;
            $bggMaxPlayers = $sxml->boardgame[0]->maxplayers;
            $bggMinPlayTime = $sxml->boardgame[0]->minplaytime;
            $bggMaxPlayTime = $sxml->boardgame[0]->maxplaytime;
            $bggPlayType = $sxml->boardgame[0]->boardgamesubdomain;
            $bggWeight = $sxml->boardgame[0]->statistics->ratings->averageweight;
            $bggYear = $sxml->boardgame[0]->yearpublished;
            $bggPublisher = $sxml->boardgame[0]->boardgamepublisher;
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

        }
        elseif ($_POST['minPlayers'] == $_POST['maxPlayers']) {
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

        
        if ($_POST['publisher']) {
            $publisher = $_POST['publisher'];
        }
        elseif ($bggPublisher) {
            $publisher = $bggPublisher;
        }
        else {
            $publisher = null;
        }

        
        if ($_POST['status'] == 'Want') {
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


        $query = " 
            INSERT INTO game_details ( 
                user_id,
                list_type,
                wishlist_order,
                name, 
                timestamp,
                gameplay_knowledge, 
                type, 
                type2,
                rating, 
                players, 
                cost, 
                publisher,
                purchase_date,
                url, 
                rules,
                notes,
                rules_notes,
                highscore,
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
                min_players,
                max_players,
                add_source
                
            ) VALUES (
                :userid, 
                :listtype,
                :wishlistorder,
                :name, 
                :timestamp,
                :knowledge, 
                :type, 
                :type2,
                :rating, 
                :players, 
                :cost, 
                :publisher,
                :date, 
                :url,
                :rules,
                :notes,
                :rulesnotes,
                :highscore,
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
                :minplayers,
                :maxplayers,
                :addsource

            ) 
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid'],
            ':listtype' => $listType,
            ':wishlistorder' => $wishlistOrder,
            ':name' => $_POST['name'],
            ':timestamp' => $timestamp,
            ':knowledge' => $_POST['knowledge'],
            ':type' => $_POST['type'],
            ':type2' => $_POST['type2'],
            ':rating' => $_POST['rating'],
            ':players' => $players,
            ':cost' => $_POST['cost'],
            ':publisher' => $publisher,
            ':date' => $_POST['purchaseDate'],
            ':url' => $bggUrl,
            ':rules' => $_POST['rules'],
            ':notes' => nl2br(htmlspecialchars($_POST['notes'], ENT_QUOTES)),
            ':rulesnotes' => "",
            ':highscore' => $_POST['highscore'],
            ':bggid' => $bggGameId,
            ':bggrating' => $bggRating,
            ':bggdescription' => $bggDescription,
            ':bggplaytime' => $bggPlayTime,
            ':bggweight' => $bggWeight,
            ':bggtype' => $bggPlayType,
            ':bggyear' => $bggYear,
            ':status' => $_POST['status'],
            ':myplaytime' => $bggPlayTime,
            ':myplayers' => $players,
            ':minplayers' => $minPlayers,
            ':maxplayers' => $maxPlayers,
            ':addsource' => 'Manual'
            
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

        if ($listType == 1) {
            header("Location: library.php"); 
        }
        else {
            header("Location: wish_list.php"); 
        }

         die("Redirecting to: stats.php");
    } 
     
?> 