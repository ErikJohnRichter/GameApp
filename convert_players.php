<?php

    require("common.php");

    $query = " 
            SELECT * FROM game_details 
        
    "; 
     
    $query_params = array( 
        
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
             $id = $x['id'];
             $myplayers = $x['my_players'];
        
            if (strpos($myplayers, "-")) {

                $myplayersarray = explode("-", $myplayers);
                $minPlayers = $myplayersarray[0];
                $maxPlayers = $myplayersarray[1];

                echo "--With Hyphen--<br>";
                echo "Game ID: ".$id."<br>";
                echo "Min Players: ".$minPlayers."<br>";
                echo "Max Players: ".$maxPlayers."<br>";
            }
            else {

                $minPlayers = $myplayers;
                $maxPlayers = $myplayers;

                echo "--Without Hyphen--<br>";
                echo "Game ID: ".$id."<br>";
                echo "Min Players: ".$minPlayers."<br>";
                echo "Max Players: ".$maxPlayers."<br>";
            }

            $query = " 
                UPDATE game_details

                SET 
                    min_players=:minPlayers,
                    max_players=:maxPlayers
                
                WHERE

                id=:gameid
            "; 
             
            $query_params = array( 

                ':minPlayers' => $minPlayers,
                ':maxPlayers' => $maxPlayers,
                ':gameid' => $id

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

    else {
        echo "Whoops.";
    }

    ?>