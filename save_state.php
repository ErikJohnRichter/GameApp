<?php
    require("common.php"); 
    
    if (isset($_POST['save-state'])) {

        $saveState = 1;
    }
    else {

       $saveState = 0;
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

        header("Location: settings.php"); 
        die("Redirecting to: settings.php");

?>