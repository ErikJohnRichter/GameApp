<?php

 require("common.php");

 if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 


	for ($i = 0; $i < $_POST['count']; $i++) {
        $gameId = $_POST["game-".$i.""];
    

	    $query = "UPDATE game_details SET ";

	    if ($_POST['status']) {
	      $query = $query.'gameplay_knowledge = "'.$_POST['status'].'", ';
	    }

	    if ($_POST['type']) {
	      $query = $query.'type = "'.$_POST['type'].'", ';
	    }

	    if ($_POST['type2']) {
	      $query = $query.'type2 = "'.$_POST['type2'].'", ';
	    }

	    if ($_POST['rating']) {
	      $query = $query.'rating = '.$_POST['rating'].', ';
	    }

	    
        if ($_POST['minPlayers'] || $_POST['maxPlayers']) {
	        if ($_POST['minPlayers'] == $_POST['maxPlayers']) {
	        	$players = $_POST['minPlayers'];
	        }
	        elseif ($_POST['maxPlayers'] != null) {
	            $players = "'".$_POST['minPlayers']."-".$_POST['maxPlayers']."'";
	        }
	        else {
	        	if ($_POST['minPlayers']) {
		            $players = $_POST['minPlayers'];
		        }
		        elseif ($_POST['maxPlayers']) {
		        	$players = $_POST['maxPlayers'];
		        }
	        }

	        $minPlayers = $_POST['minPlayers'];
	        $maxPlayers = $_POST['maxPlayers'];

	        if (!$_POST['maxPlayers']) {
	            $maxPlayers = $_POST['minPlayers'];
	        }
	        if (!$_POST['minPlayers']) {
	            $minPlayers = $_POST['maxPlayers'];
	        }
	    
	        $query = $query.'my_players = '.$players.', min_players = '.$minPlayers.', max_players = '.$maxPlayers.', ';
	    }

	    
	    if ($_POST['weight']) {
	      $query = $query.'bgg_weight = '.$_POST['weight'].', ';
	    }

	    if ($_POST['cost']) {
	      $query = $query.'cost = '.$_POST['cost'].', ';
	    }

	    if ($_POST['time']) {
	      $query = $query.'my_playtime = '.$_POST['time'].', ';
	    }

	    if ($_POST['playWith']) {
	      $query = $query.'play_with = "'.$_POST['playWith'].'", ';
	    }

	    if ($_POST['scoring']) {
	      $query = $query.'highscore = "'.$_POST['scoring'].'", ';
	    }

	    if ($_POST['purchaseDate']) {
	      $query = $query.'purchase_date = "'.$_POST['purchaseDate'].'", ';
	    }

	    $query = $query.'wishlist_order = null WHERE id = '.$gameId.' AND user_id = '.$_SESSION['userid'].'';

	    
	     
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

    }



		header("Location: library.php"); 
        die("Redirecting to: library.php");
     

?>