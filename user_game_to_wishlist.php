<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

        $gameId = $_POST['game-id'];
        
        $query = " 
        SELECT * FROM game_details 
        WHERE 
            id = :gameid
    "; 
     
    $query_params = array( 
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

    $rows = $stmt->fetchAll();
    if ($rows) {
        foreach ($rows as $x) {
          $userId = $x['user_id'];
          $list = $x['list_type'];
          $name = $x['name'];
          $knowledge = $x['gameplay_knowledge'];
          $rating = $x['rating'];
          $players = $x['players'];
          $type = $x['type'];
          $cost = $x['cost'];
          $publisher = $x['publisher'];
          $purchase = $x['purchase_date'];
          $url = $x['url'];
          $rules = $x['rules'];
          $rulesNotes = $x['rules_notes'];
          $sort = $x['highscore'];
          $bggid = $x['bgg_id'];
          $bggRating = $x['bgg_rating'];
          $bggDescription = $x['bgg_description'];
          $bggPlaytime = $x['bgg_playtime'];
          $bggType = $x['bgg_type'];
          $bggWeight = $x['bgg_weight'];
          $bggYear = $x['bgg_year'];
          $status = $x['status'];
          $myplaytime = $x['my_playtime'];
          $myplayers = $x['my_players'];
          $minPlayers = $x['min_players'];
          $maxPlayers = $x['max_players'];
          $mydescription = $x['my_description'];
            
        }
        
        if ($rulesNotes == '&lt;ul&gt;&lt;li&gt;&lt;br&gt;&lt;/li&gt;&lt;/ul&gt;') {
          $rulesNotes = null;
        }
    }



        $timestamp = date('Y-m-d G:i:s', strtotime('-5 hours'));

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
                :name, 
                :timestamp,
                :knowledge, 
                :type, 
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
            ':listtype' => 2,
            ':name' => $name,
            ':timestamp' => $timestamp,
            ':knowledge' => null,
            ':type' => $type,
            ':rating' => null,
            ':players' => $players,
            ':cost' => null,
            ':publisher' => $publisher,
            ':date' => null,
            ':url' => $url,
            ':rules' => $rules,
            ':notes' => null,
            ':rulesnotes' => $rulesNotes,
            ':highscore' => $sort,
            ':bggid' => $bggid,
            ':bggrating' => $bggRating,
            ':bggdescription' => $bggDescription,
            ':bggplaytime' => $bggPlaytime,
            ':bggweight' => $bggWeight,
            ':bggtype' => $bggType,
            ':bggyear' => $bggYear,
            ':status' => 'Research',
            ':myplaytime' => $bggPlaytime,
            ':myplayers' => $players,
            ':minplayers' => $minPlayers,
            ':maxplayers' => $maxPlayers,
            ':addsource' => 'User'
            
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

    
        //header("Location: wish_list.php"); 
        

         die("Redirecting to: stats.php");
    } 
     
?> 