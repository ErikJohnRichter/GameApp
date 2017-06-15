<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
            $timestamp = date('Y-m-d G:i:s', strtotime('-5 hours'));
            $gameId = $_POST['game-id'];
            $rules = $_POST['hasRulesNotes'];

            if ($rules) {
                $knowledge = "Great";
            }
            else {
                $knowledge = "Need Rules";
            }
        
            $query = " 
            UPDATE game_details

            SET 
                timestamp=:timestamp,
                list_type=:listtype,
                gameplay_knowledge=:knowledge,
                status=:status
                
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 
            ':timestamp' => $timestamp,
            ':listtype' => 1,
            ':knowledge' => $knowledge,
            ':status' => "Own",
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

            header("Location: library.php"); 
            die("Redirecting to: library.php");
        
             
    } 
     
?> 