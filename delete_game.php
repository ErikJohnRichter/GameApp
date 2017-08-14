<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 
        $gameList = $_POST['game-list'];
        $query = " 
            DELETE FROM game_details

            WHERE

            id=:gameid
        "; 
         
        $query_params = array( 

            ':gameid' => $_POST['game-id']
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

        if ($gameList != 1) {
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
        }


        $query = " 
            SELECT * FROM game_details 
            WHERE 
                linked_game = :gameid AND
                user_id = :userid
        "; 
         
        $query_params = array(
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

        $rowzz = $stmt->fetchAll();
        if ($rowzz) {
            foreach ($rowzz as $y) {
                $query = " 
                   UPDATE game_details 

                    SET 
                        linked_game = :linkedgame
                    
                    WHERE

                    id=:gameid AND user_id=:userid
                "; 
                 
                $query_params = array( 

                    ':linkedgame' => null,
                    ':gameid' => $y['id'],
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
            }
        }
         
        
        if ($gameList == 1) {
            header("Location: library.php"); 
        }
        elseif ($gameList == 3) {
            header("Location: archive.php"); 
        } 
        else {
            header("Location: wish_list.php"); 
        } 


        die("Redirecting to: library.php");

    } 
     
?> 