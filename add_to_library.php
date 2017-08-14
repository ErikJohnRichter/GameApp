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
                wishlist_order=:wishlistorder,
                gameplay_knowledge=:knowledge,
                status=:status
                
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 
            ':timestamp' => $timestamp,
            ':listtype' => 1,
            ':wishlistorder' => null,
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



        $query = " 
            SELECT * FROM game_details 
            WHERE 
                wishlist_order IS NOT null AND
                user_id = :userid
                AND list_type = :listtype
            ORDER BY wishlist_order asc
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid'],
            ':listtype' => 2
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
            $count = 1;
            foreach ($rows as $x) {

                if ($count <= $wishlistGameCount) {
                  $query = " 
                       UPDATE game_details 

                        SET 
                            wishlist_order = :order
                        
                        WHERE

                        id=:gameid AND user_id=:userid
                    "; 
                     
                    $query_params = array( 

                        ':order' => $count,
                        ':gameid' => $x['id'],
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
                    
                    $count = $count + 1;
                }
            }
            
        }

            header("Location: library.php"); 
            die("Redirecting to: library.php");
        
             
    } 
     
?> 