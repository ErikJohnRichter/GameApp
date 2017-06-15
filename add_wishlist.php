<?php 

    require("common.php"); 
     
    if(!empty($_POST)) 
    { 

        if ($_POST['maxPlayers'] != null) {
            $players = $_POST['minPlayers']."-".$_POST['maxPlayers'];
        }
        else {
            $players = $_POST['minPlayers'];
        }

        $query = " 
            INSERT INTO wish_list ( 
                user_id,
                name, 
                desire,
                type, 
                players, 
                cost, 
                url,
                rules,
                notes
                
            ) VALUES ( 
                :userid,
                :name, 
                :desire,
                :type, 
                :players, 
                :cost, 
                :url,
                :rules,
                :notes
            ) 
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid'],
            ':name' => $_POST['name'],
            ':desire' => $_POST['desire'],
            ':type' => $_POST['type'],
            ':players' => $players,
            ':cost' => $_POST['cost'],
            ':url' => $_POST['bggUrl'],
            ':rules' => $_POST['rules'],
            ':notes' => nl2br(htmlspecialchars($_POST['notes'], ENT_QUOTES))
            
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

        header("Location: wish_list.php"); 
        die("Redirecting to: wish_list.php");
         
    } 
     
?> 