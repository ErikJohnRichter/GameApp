<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

            $rank = $_POST['rank'];
            $gameId = $_POST['game-id'];

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
                    id != :id
                    AND user_id = :userid
                    AND list_type = :listtype
                ORDER BY wishlist_order asc
            "; 
             
            $query_params = array( 
                ':id' => $gameId,
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
                    if ($count == $rank) {
                        
                        $count = $count + 1;
                    }

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

            $query = " 
               UPDATE game_details 

                SET 
                    wishlist_order = :order
                
                WHERE

                id=:gameid AND user_id=:userid
            "; 
             
            $query_params = array( 

                ':order' => $rank,
                ':gameid' => $gameId,
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