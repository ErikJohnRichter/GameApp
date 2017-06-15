<?php 

    require("common.php"); 

        $followingId = $_POST['following-id'];
        $followingUsername = $_POST['following-username'];
     
        $query = " 
            DELETE FROM following

            WHERE

            follower=:follower AND following=:following
        "; 
         
        $query_params = array( 
            ':follower' => $_SESSION['userid'],
            ':following' => $followingId
            
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

        header("Location: user_details.php?username=".$followingUsername.""); 
        die("Redirecting to: user_details.php?username=".$followingUsername."");

     
?> 