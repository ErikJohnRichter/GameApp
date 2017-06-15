<?php
    require("common.php"); 
    
    if (isset($_POST['libraryprivacy'])) {

        $privacy = 1;
    }
    else {

       $privacy = null;
    }
    

        $query = " 
            UPDATE users

            SET 
                library_public=:public
            
            WHERE
        
                id=:userid
        "; 
         
        $query_params = array( 
            ':public' => $privacy,
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

        header("Location: settings.php"); 
        die("Redirecting to: settings.php");

?>