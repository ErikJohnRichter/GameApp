<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

$gameName = $_GET['name'];
$list = $_GET['list'];
$order = $_GET['order'];

    if ($list == 2) {
        $query = " 

            SELECT * FROM game_details 
            WHERE 
                wishlist_order > :order
                AND list_type = :listtype
                AND user_id = :userid
                ORDER BY wishlist_order asc LIMIT 1
        "; 

        $query_params = array( 
            ':order' => $order,
            ':listtype' => $list,
            ':userid' => $_SESSION['userid']
        ); 
    }
    else {
        $query = " 

            SELECT * FROM game_details 
            WHERE 
                name > :gamename
                AND list_type = :listtype
                AND user_id = :userid
                ORDER BY name asc LIMIT 1
        "; 

        $query_params = array( 
            ':gamename' => $gameName,
            ':listtype' => $list,
            ':userid' => $_SESSION['userid']
        ); 
    }
     
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
          $nextId = $x['id'];
        }
        
    }

    else {
        if ($list == 2) {
        $query = " 

        SELECT * FROM game_details 
        WHERE 
            list_type = :listtype
            AND wishlist_order IS NOT null
            AND user_id = :userid
            ORDER BY wishlist_order asc LIMIT 1
            "; 
             
            $query_params = array( 
                ':listtype' => $list,
                ':userid' => $_SESSION['userid']
            ); 
        }
        else {

        $query = " 

        SELECT * FROM game_details 
        WHERE 
            list_type = :listtype
            AND user_id = :userid
            ORDER BY name asc LIMIT 1
            "; 
             
            $query_params = array( 
                ':listtype' => $list,
                ':userid' => $_SESSION['userid']
            ); 
            
        }
     
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
                $nextId = $x['id'];
            }
        }
    }

    header("Location: game_details.php?id=".$nextId.""); 
    die("Redirecting to: game_details.php?id=".$nextId."");

?>