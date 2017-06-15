<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

        $timestamp = date('Y-m-d G:i:s', strtotime('-6 hours'));

        if ($_POST['maxPlayers'] != null) {
            $players = $_POST['minPlayers']."-".$_POST['maxPlayers'];
        }
        else {
            $players = $_POST['minPlayers'];
        }

        $query = " 
            UPDATE game_details

            SET 
                name=:name,
                desire=:desire,
                players=:players,
                type=:type,
                cost=:cost,
                url=:url,
                rules=:rules,
                notes=:notes
            
            WHERE

            id=:gameid AND user_id=:userid
        "; 
         
        $query_params = array( 

            ':name' => $_POST['name'],
            ':desire' => $_POST['desire'],
            ':players' => $players,
            ':type' => $_POST['type'],
            ':cost' => $_POST['cost'],
            ':url' => $_POST['bggUrl'],
            ':rules' => $_POST['rules'],
            ':notes' => nl2br(htmlspecialchars($_POST['notes'], ENT_QUOTES)),
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

        header("Location: wish_list.php"); 
        die("Redirecting to: wish_list.php");

    } 
     
?> 