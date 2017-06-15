<?php
    require("common.php"); 
    
    $query = " 
        SELECT * FROM rating_scale 
        WHERE 
            user_id = :userid
    "; 
     
    $query_params = array( 
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

    $rows = $stmt->fetchAll();
    if ($rows) {
        
        $query = " 
            UPDATE rating_scale

            SET 
                ten=:ten,
                nine=:nine,
                eight=:eight,
                seven=:seven,
                six=:six,
                five=:five,
                four=:four,
                three=:three,
                two=:two,
                one=:one
            
            WHERE
        
                user_id=:userid
        "; 
         
        $query_params = array( 
            ':ten' => $_POST['ten'],
            ':nine' => $_POST['nine'],
            ':eight' => $_POST['eight'],
            ':seven' => $_POST['seven'],
            ':six' => $_POST['six'],
            ':five' => $_POST['five'],
            ':four' => $_POST['four'],
            ':three' => $_POST['three'],
            ':two' => $_POST['two'],
            ':one' => $_POST['one'],
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

    else {

        $query = " 
            INSERT INTO rating_scale ( 
                user_id,
                one,
                two,
                three,
                four,
                five,
                six,
                seven,
                eight,
                nine,
                ten
                
            ) VALUES (
                :userid, 
                :one,
                :two,
                :three,
                :four,
                :five,
                :six,
                :seven,
                :eight,
                :nine,
                :ten

            ) 
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid'],
            ':one' => $_POST['one'],
            ':two' => $_POST['two'],
            ':three' => $_POST['three'],
            ':four' => $_POST['four'],
            ':five' => $_POST['five'],
            ':six' => $_POST['six'],
            ':seven' => $_POST['seven'],
            ':eight' => $_POST['eight'],
            ':nine' => $_POST['nine'],
            ':ten' => $_POST['ten']
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


    header("Location: profile.php"); 
    die("Redirecting to: profile.php");

?>