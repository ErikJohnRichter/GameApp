<?php
    require("common.php"); 
    
    if ($_SESSION['savestate'] == 1) {

        $saveState = 0;
    }
    else {

       $saveState = 1;
    }
    

        $query = " 
            UPDATE users

            SET 
                save_state=:savestate
            
            WHERE
        
                id=:userid
        "; 
         
        $query_params = array( 
            ':savestate' => $saveState,
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

        $_SESSION['savestate'] = $saveState;

        header("Location: library.php"); 
        die("Redirecting to: library.php");

?>