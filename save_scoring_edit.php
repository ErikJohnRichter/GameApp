<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        
        $query = " 
            UPDATE game_details

            SET 
                highscore=:highscore
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 

            ':highscore' => $_POST['highscore'],
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