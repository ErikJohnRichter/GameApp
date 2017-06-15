<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        
        $query = " 
            UPDATE game_details

            SET 
                notes=:notes
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 

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

        header("Location: game_details.php?id=".$_POST['game-id'].""); 
        die("Redirecting to: game_details.php?id=".$_POST['game-id']."");

    } 
     
?> 