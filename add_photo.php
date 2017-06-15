<?php
    require("common.php"); 
        
        $detectedType = exif_imagetype($_FILES['photo']['tmp_name']);
        if ($detectedType == 2) {
            $type = '.jpg';
        }
        elseif ($detectedType == 3) {
            $type = '.png';
        }
        else {
            die("Please add, either, a JPG or PNG.");
        }
        $uploaddir = './assets/images/';
        $uploadimage = $_SESSION['username'].$type;
        
        move_uploaded_file($_FILES["photo"]["tmp_name"], $uploaddir.$uploadimage);

        $query = " 
            UPDATE users

            SET 
                picture=:picture
            
            WHERE
        
                id=:userid
        "; 
         
        $query_params = array( 
            ':picture' => $uploadimage,
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

        $_SESSION['picture'] = $uploadimage;

            
        header("Location: profile.php"); 
        die("Redirecting to: profile.php"); 

?>