<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

        if ($_POST['status'] == "Want") {
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
            UPDATE game_details

            SET 
                wishlist_order=:wishlistorder,
                status=:status
            
            WHERE

            id=:gameid AND user_id = :userid
        "; 
         
        $query_params = array( 

            ':wishlistorder' => $wishlistOrder,
            ':status' => $_POST['status'],
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


        if ($_POST['status'] != "Want" && $_POST['status'] != null) {

            $query = " 
                SELECT COUNT(*) 
                FROM game_details
                WHERE wishlist_order IS NOT null AND user_id = :userid AND list_type=2;
            "; 
             
            $query_params = array( 
                ':userid' => $_SESSION['userid']
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
        }

        header("Location: game_details.php?id=".$_POST['game-id'].""); 
        die("Redirecting to: game_details.php?id=".$_POST['game-id']."");

    } 
     
?> 