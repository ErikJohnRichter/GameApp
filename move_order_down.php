<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

$gameId = $_GET['id'];

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
            id = :gameid
            AND user_id = :userid
            AND list_type = :listtype
    "; 
     
    $query_params = array( 
        ':gameid' => $gameId,
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
        foreach ($rows as $x) {
          $higherId = $x['id'];
          $higherWishlistOrder = $x['wishlist_order'];
        }
        
    }

    $lowerWishlistOrder = $higherWishlistOrder + 1;


$query = " 
        SELECT * FROM game_details 
        WHERE 
            user_id = :userid
            AND list_type = :listtype
            AND wishlist_order = :order
    "; 
     
    $query_params = array( 
        ':userid' => $_SESSION['userid'],
        ':listtype' => 2,
        ':order' => $lowerWishlistOrder
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

    $rowz = $stmt->fetchAll();
    if ($rowz) {
        foreach ($rowz as $y) {
          $lowerId = $y['id'];
          $lowerWishlistOrder = $y['wishlist_order'];
        }
        
    }

    if ($lowerWishlistOrder <= $wishlistGameCount) {
        $query = " 
                   UPDATE game_details 

                    SET 
                        wishlist_order = :order
                    
                    WHERE

                    id=:gameid AND user_id=:userid
                "; 
                 
                $query_params = array( 

                    ':order' => $higherWishlistOrder,
                    ':gameid' => $lowerId,
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
                   UPDATE game_details 

                    SET 
                        wishlist_order = :order
                    
                    WHERE

                    id=:gameid AND user_id=:userid
                "; 
                 
                $query_params = array( 

                    ':order' => $lowerWishlistOrder,
                    ':gameid' => $higherId,
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

    header("Location: wish_list.php"); 
    die("Redirecting to: wish_list.php");
?>