<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
            $gameId = $_POST['game-id'];

            $query = " 
            UPDATE game_details

            SET 
                list_type=:listtype
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 
            ':listtype' => 2,
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

            header("Location: game_details.php?id=".$gameId.""); 
            die("Redirecting to: wish_list.php");
        
             
    } 
     
?> 