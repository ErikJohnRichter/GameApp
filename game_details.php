<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

$gameId = $_GET['id'];

$query = " 
        SELECT * FROM game_details 
        WHERE 
            id = :gameid
            AND user_id = :userid
    "; 
     
    $query_params = array( 
        ':gameid' => $gameId,
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
        foreach ($rows as $x) {
          $id = $x['id'];
          $list = $x['list_type'];
          $wishlistOrder = $x['wishlist_order'];
          $name = $x['name'];
          $knowledge = $x['gameplay_knowledge'];
          $rating = $x['rating'];
          $players = $x['players'];
          $type = $x['type'];
          $type2 = $x['type2'];
          $cost = $x['cost'];
          $publisher = $x['publisher'];
          $purchase = $x['purchase_date'];
          $url = $x['url'];
          $rules = $x['rules'];
          $notes = $x['notes'];
          $lastplayed = strtotime($x['last_played']);
          $numberofplays = $x['number_of_plays'];
          $rulesNotes = $x['rules_notes'];
          $sort = $x['highscore'];
          $bggid = $x['bgg_id'];
          $bggRating = $x['bgg_rating'];
          $bggDescription = $x['bgg_description'];
          $bggPlaytime = $x['bgg_playtime'];
          $bggType = $x['bgg_type'];
          $bggWeight = $x['bgg_weight'];
          $bggYear = $x['bgg_year'];
          $status = $x['status'];
          $myplaytime = $x['my_playtime'];
          $myplayers = $x['my_players'];
          $playwith = $x['play_with'];
          $linkedGame = $x['linked_game'];
          $mydescription = $x['my_description'];
            
        }
        
        if ($rulesNotes == '&lt;ul&gt;&lt;li&gt;&lt;br&gt;&lt;/li&gt;&lt;/ul&gt;') {
          $rulesNotes = null;
        }
    }

   

                    
    $lastplayed = date('m-d-Y', $lastplayed);

    if (!$sort) {
      $sort = 'desc';
    }

    $searchName = $x['name'];
    $searchName = str_replace(' ','%20',$searchName);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Games, Manager, Boardgames" />
  <link rel="shortcut icon" sizes="196x196" href="assets/images/logo.png">
  <link rel="apple-touch-icon" href="assets/images/GameAppLogoIcon.png" />
	<title>GameApp</title>
	
	<link rel="stylesheet" href="libs/bower/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css">
	<!-- build:css assets/css/app.min.css -->
	<link rel="stylesheet" href="libs/bower/animate.css/animate.min.css">
	<link rel="stylesheet" href="libs/bower/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" href="libs/bower/perfect-scrollbar/css/perfect-scrollbar.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/core.css">
	<link rel="stylesheet" href="assets/css/app.css">
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300">
	<script src="libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
  <script src="libs/bower/jquery/dist/jquery.js"></script>
  <script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
	<script>
		Breakpoints();
	</script>
  <script>
  function showResult(str) {
    if (str.length==0) { 
      document.getElementById("livesearch").innerHTML="";
      document.getElementById("livesearch").style.border="0px";
      return;
    }
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("livesearch").innerHTML=this.responseText;
        document.getElementById("livesearch").style.border="1px solid #A5ACB2";
      }
    }
    xmlhttp.open("GET","livesearch.php?q="+str,true);
    xmlhttp.send();
  }
  </script>
</head>
	
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!--============= start main area -->

<!-- APP NAVBAR ==========-->
<nav id="app-navbar" class="navbar navbar-inverse navbar-fixed-top primary">
  
  <!-- navbar header -->
  <div class="navbar-header">
    <button type="button" id="menubar-toggle-btn" class="navbar-toggle visible-xs-inline-block navbar-toggle-left hamburger hamburger--collapse js-hamburger">
      <span class="sr-only">Toggle navigation</span>
      <span class="hamburger-box"><span class="hamburger-inner"></span></span>
    </button>

    <button type="button" class="navbar-toggle navbar-toggle-right collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="zmdi zmdi-hc-lg zmdi-more"></span>
    </button>

    <button type="button" class="navbar-toggle navbar-toggle-right collapsed livesearch" data-toggle="collapse" data-target="#navbar-search" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="zmdi zmdi-hc-lg zmdi-search"></span>
    </button>

    <a href="stats.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float"><?php echo $name; ?> Details</h5>
        </li>
      </ul>

      <ul class="nav navbar-toolbar navbar-toolbar-right navbar-right">

        <li class="nav-item dropdown hidden-float">
          <a href="create_game.php?list=1">
            <i class="zmdi zmdi-hc-lg zmdi-plus"></i>
          </a>
        </li>

        <li class="nav-item dropdown hidden-float">
          <a href="javascript:void(0)" data-toggle="collapse" class="livesearch" data-target="#navbar-search" aria-expanded="false">
            <i class="zmdi zmdi-hc-lg zmdi-search"></i>
          </a>
        </li>

      </ul>
    </div>
  </div><!-- navbar-container -->
</nav>
<!--========== END app navbar -->

<!-- navbar search -->
<div id="navbar-search" class="navbar-search collapse">
  <div class="navbar-search-inner">
    <form style="margin-top: 5px; display: inline-block; width: 100%">
      <input class="form-control search-field" id="live-search" type="text" size="30" style="font-size: 16px;" onkeyup="showResult(this.value)" placeholder="Search my games" autofocus>
      <div id="livesearch" style="font-size: 18px; padding: 5px; padding-top:52px; width: 100%;"></div>
    </form>
    <!--<form action="#">
      <span class="search-icon"><i class="fa fa-search"></i></span>
      <input class="search-field" type="search" placeholder="search..."/>
    </form>-->
    <button type="button" class="search-close" id="searchclose" data-toggle="collapse" data-target="#navbar-search" aria-expanded="false">
      <i class="fa fa-close"></i>
    </button>
  </div>
  <div class="navbar-search-backdrop" data-toggle="collapse" data-target="#navbar-search" aria-expanded="false"></div>
</div><!-- .navbar-search -->

<!-- APP ASIDE ==========-->
<?php include("side_bar.php"); ?>
<!--========== END app aside -->

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="profile-header">
  <div class="profile-cover" style="padding-top: 30px; padding-bottom: 40px;">
    <?php
    if ($list == 1) {
      echo '<a href="library.php" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
    }
    elseif ($list == 3) {
      echo '<a href="archive.php" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
    }
    else {
      echo '<a href="wish_list.php" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
    }
    
    echo '<a href="edit_game.php?id='.$gameId.'" style="color: silver; float: right;"><span class="glyphicon glyphicon-pencil" style="font-size: 22px; padding-right: 12px;"></span></a>';

    ?>
    <div class="text-center">
      <?php 
      
      if ($bggid) {echo '<a href="'.$url.'" target="_blank" style="color: #188ae2"><img src="./images/'.$bggid.'.jpg" onerror="this.src=&#39;./images/noimage.jpg&#39;" style="padding-bottom: 10px;"></a>';}
      else {echo '<img src="./images/noimage.jpg" style="padding-bottom: 10px; max-width: 100px;">';} 
      
      ?>
      <br>
       <table align="center">
        <tr>
          <td>
      <?php

      if ($bggRating)
      {
      echo '<span class="zmdi-hc-stack zmdi-hc-lg" style="margin-top:-33px; margin-right: 16px; display: inline-block;">';
      echo '<a href="bgg_reviews.php?id='.$bggid.'&name='.$name.'&list=mygames&gameid='.$gameId.'">';
      echo' <i class="zmdi zmdi-label-alt zmdi-hc-stack-2x" style="font-size: 52px;color:#188ae2;"></i>';
      echo '<i class="zmdi zmdi-hc-stack-1x zmdi-hc-inverse" style="font-family: Raleway; font-size: 18px; margin-top:7px; margin-left:-1px;">'.number_format((float)$bggRating, 1, '.', '').'</i>';
      echo '</a>';
      echo '</span>'; 
      } 

      echo '</td><td class="text-left">';
      //echo '</td><td class="text-left" style="word-break: break-all;">';
      
      if (strlen($name) > 18) {
        echo '<h3 class="profile-info-name m-b-lg" style="font-size: 25px; margin-top: 5px; margin-right: 4px; display:inline-block;">'.$name.'</h3>';
      }
      else {
        echo '<h3 class="profile-info-name m-b-lg" style="font-size: 30px; margin-top: 5px; margin-right: 4px; display:inline-block;">'.$name.'</h3>';
      }

      ?>
      </td>
  </tr>
</table>
      <?php if ($list == 1) { ?>
      <div>
        <span class="m-r-xl theme-inverse"># of plays: <?php if ($numberofplays) {echo '<a href="gameplay_log.php?id='.$gameId.'&name='.$name.'"><b>'.$numberofplays.'</b></a>';} else {echo '<b>0</b>';} ?></span>
        <span class="theme-inverse">Last play: <b><?php if ($x['last_played']) {echo $lastplayed;} else {echo "Never played";} ?></b></span>
        <span class="theme-inverse"></span>
      </div>
      <?php } 
      else if ($list == 2) { 
        if ($wishlistOrder) {
          echo '<span class="theme-inverse"><a href="wish_list.php" style="display: inline;"><b>#'.$wishlistOrder.' ON MY WISHLIST</b></a><a href="edit_wishlist_rank.php?id='.$gameId.'" style="display: inline; color: lightgrey;"><span class="glyphicon glyphicon-pencil" style="font-size: 14px; padding-left: 8px;"></span></a></span>
          <span class="theme-inverse"></span>';
        }
        else {
          echo '<span class="theme-inverse"><a href="wish_list.php"><b>ON MY WISHLIST - '.strtoupper($status).'</b></a></span>
          <span class="theme-inverse"></span>';
        }
       } 
      else if ($list == 3) { ?>
        <span class="theme-inverse"><form action="unarchive_game.php" method="post">
                <?php echo '<input type="hidden" name="game-id" value="'.$gameId.'">'.
                '.<input type="hidden" name="game-list" value="'.$list.'">'; ?>
                <button id="deleteGame" type="submit" onclick="return confirm(\'Are you sure you want to re-add to your Wishlist?\');" class="btn btn-sm btn-primary" style="margin-bottom: 4px;">Unarchive</button>
                </form></span>
        <span class="theme-inverse"></span>
      <?php } ?>
    
    </div>
  </div><!-- .profile-cover -->
<?php if ($list == 1) { ?>
  <div class="promo-footer">
    <div class="row no-gutter">
      
      <div class="col-sm-2 col-sm-offset-3 col-xs-4 promo-tab">
        <div class="text-center">
          <small>Players</small>
          <?php
          echo '<a href="edit_players.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">';
            if ($myplayers) {
              echo '<h4 class="m-0 m-t-xs">'.$myplayers.' people</h4>';
            }
            
            else {
              echo '<h4 class="m-0 m-t-xs" style="color: #188ae2;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span>Add</h4>';
            }
            echo '</a>';
            ?>
        </div>
      </div>
      
      <div class="col-sm-2 col-xs-4 promo-tab">
        <div class="text-center">
          <small>My Rating</small>
            <div class="m-t-xs">
            <?php
            echo '<a href="edit_rating.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">';
              if ($rating) {
                echo '<h4 class="m-0 m-t-xs">'.$rating.'.0</h4>';
              }
              else {
                echo '<h4 class="m-0 m-t-xs" style="color: #188ae2;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span>Add</h4>';
              }
              echo '</a>';
            ?>
          </div>
        </div>
      </div>
      <div class="col-sm-2 col-xs-4 promo-tab">
        <div class="text-center">
          <small>Playtime</small>
          <div class="m-t-xs">
            <?php
            echo '<a href="edit_playtime.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">';
            if ($myplaytime) {
              echo '<h4 class="m-0 m-t-xs">'.$myplaytime.' min</h4>';
            }
            
            else {
              echo '<h4 class="m-0 m-t-xs" style="color: #188ae2;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span>Add</h4>';
            }
            echo '</a>';
            ?>
          </div>
        </div>
      </div>
    </div>
  </div><!-- .promo-footer -->
  <?php } 
  else { ?>
  <div class="promo-footer">
    <div class="row no-gutter">
      
      <div class="col-sm-2 col-sm-offset-3 col-xs-4 promo-tab">
        <div class="text-center">
          <small>Cost</small>
          <?php
          echo '<a href="edit_cost.php?id='.$gameId.'&search='.$searchName.'" style="color: #6a6c6f; text-decoration: none;">';
            if ($cost) {
              echo '<h4 class="m-0 m-t-xs">$'.$cost.'</h4>';
            }
            else {
              echo '<h4 class="m-0 m-t-xs" style="color: #188ae2;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span>Add</h4>';
            }
            echo '</a>';
            ?>
        </div>
      </div>
      
      <div class="col-sm-2 col-xs-4 promo-tab">
        <div class="text-center">
          <small>My Rating</small>
            <div class="m-t-xs">
            <?php
            echo '<a href="edit_rating.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">';
              if ($rating) {
                echo '<h4 class="m-0 m-t-xs">'.$rating.'.0</h4>';
              }
              else {
                echo '<h4 class="m-0 m-t-xs" style="color: #188ae2;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span>Add</h4>';
              }
              echo '</a>';
            ?>
          </div>
        </div>
      </div>
      <div class="col-sm-2 col-xs-4 promo-tab">
        <div class="text-center">
          <small>Status</small>
            <div class="m-t-xs">
            <?php
            echo '<a href="edit_status.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">';
              if ($status) {
                echo '<h4 class="m-0 m-t-xs">'.$status.'</h4>';
              }
              else {
                echo '<h4 class="m-0 m-t-xs" style="color: #188ae2;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span>Add</h4>';
              }
              echo '</a>';
            ?>
          </div>
        </div>
      </div>
    </div>
  </div><!-- .promo-footer -->
  <?php } ?>
</div><!-- .profile-header -->

<div class="wrap" style="padding-top: 0px;">
  <section class="app-content">
    
    <div class="row" style="padding-top: 20px;padding-bottom: 20px;">
     
        <?php 
        if ($knowledge == "Need Refresher" || $knowledge == "Need Rules") {
          $width = "140";
        }
        else {
          $width = "200";
        }
      if ($list == 1) {
      echo '<div class="col-md-12 promo-tab text-center">';
        echo '<div class="text-center" style="display:inline-block;">';
         echo '<form action="create_gameplay_live.php" method="post">';
              echo '<div style="border-top: 0px solid white;">';
                 echo '<input type="hidden" name="id" value="'.$gameId.'">';
                 echo '<input type="hidden" name="name" value="'.$name.'">';
                 echo '<input type="hidden" name="scoring" value="'.$sort.'">';
                echo '<button id="deleteGame" type="submit" class="btn btn-default" style="width: '.$width.'px;height: 50px;">Log a Gameplay</button>';
              echo '</div>';
            echo '</form>';
        echo '</div>';
        if ($width == "140") {
        echo '<div class="text-center" style="display:inline-block; margin-left: 20px;">';
              echo '<div style="border-top: 0px solid white;">';
              echo '<a href="edit_knowledge.php?id='.$gameId.'" style="color: #188AE2; text-decoration: none;"><button class="btn btn-default" style="width: 140px;height: 50px;"><span style="color: #FF5B5B;">'.$knowledge.'</span></button></a>';
              echo '</div>';
        echo '</div>';
      }
     echo '</div>';
    }
    else {
        echo '<div class="col-md-12 promo-tab text-center">';
        echo '<div class="text-center" style="display:inline-block;">';
         echo '<form action="add_to_library.php" method="post">';
              echo '<div style="border-top: 0px solid white;">';
                 echo '<input type="hidden" name="game-id" value="'.$gameId.'">';
                 echo '<input type="hidden" name="game-list" value="'.$list.'">';
                 echo '<input type="hidden" name="hasRulesNotes" value="'.$rulesNotes.'">';
                echo '<button id="deleteGame" type="submit" onclick="return confirm(&#39Are you sure you want to add this game to your library?&#39);" class="btn btn-default" style="width: 140px;height: 50px;">Add to Library</button>';
              echo '</div>';
            echo '</form>';
        echo '</div>';
        if ($bggid) {
        echo '<div class="text-center" style="display:inline-block; margin-left: 20px;">';
              echo '<div style="border-top: 0px solid white;">';
                 echo '<input type="hidden" name="game-id" value="'.$gameId.'">';
                 echo '<input type="hidden" name="game-list" value="'.$list.'">';
                 echo '<input type="hidden" name="hasRulesNotes" value="'.$rulesNotes.'">';
                echo '<a href="get_game_reviews.php?id='.$bggid.'&name='.$name.'&list=mygames&gameid='.$gameId.'" style="color: #188ae2"><button class="btn btn-default" style="width: 140px;height: 50px;">Game Reviews</button></a>';
              echo '</div>';
        echo '</div>';
      }


      echo '</div>';
    }
    ?>
    
    </div>

    <div class="row">
      <div class="col-md-12">
        <div id="profile-tabs" class="nav-tabs-horizontal white m-b-lg">
          <!-- tabs list -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active" style="font-size: 18px;"><a href="#rules" aria-controls="photos" role="tab" data-toggle="tab">Rules</a></li>
            <li role="presentation" style="font-size: 18px;"><a href="#notes" aria-controls="stream" role="tab" data-toggle="tab">Notes</a></li>
            <li role="presentation" style="font-size: 18px;"><a href="#details" aria-controls="stream" role="tab" data-toggle="tab">Info</a></li>
            <?php
              if ($list == 1) {
                echo '<li role="presentation" style="font-size: 18px;"><a href="#stats" aria-controls="stream" role="tab" data-toggle="tab">Stats</a></li>';
              }
              else {
                
                echo '<li role="presentation" style="font-size: 18px;"><a href="http://www.boardgameprices.com/compare-prices-for?q='.$searchName.'" target="_blank">Prices</a></li>';
              }
            ?>
            <?php //echo '<li role="presentation"><a href="add_gameplay.php?id='.$gameId.'&name='.$name.'" onclick="return confirm_alert(this);"><span class="glyphicon glyphicon-play"></span>&nbsp;&nbsp;Add Play</a></li>'; ?>
          </ul><!-- .nav-tabs -->

          <!-- Tab panes -->
          <div class="tab-content">

            <div role="tabpanel" id="rules" class="tab-pane in active fade p-md">

              <div class="media stream-post" style="padding-top: 5px;">
                <div class="media-body">
                  
                  <h4 class="media-heading" style="float: right; margin-top:0px;">
                    <?php echo '<a href="edit_rules.php?id='.$gameId.'" style="color: lightgrey; font-size: 16px; margin-left: 8px;"><span class="glyphicon glyphicon-pencil"></span></a>'; ?>
                  </h4>
                  <div class="stream-body m-t-l" style="margin-top: 10px;">
                    <?php echo '<a href="edit_rules.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">';
                    if ($rulesNotes) { echo '<p>'.htmlspecialchars_decode($rulesNotes, ENT_QUOTES).'</p>';} else {echo '<h4 class="m-0 m-t-xs" style="color: #188ae2;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span>Add</h4>';} 
                    echo '</a>';
                    ?>
                  </div>
                  <?php
                  if ($rules) {
                    echo '<hr><h4 class="media-heading m-t-xs" style="padding-top: 5px;">';
                      echo '<a href="'.$rules.'" target="_blank" style="color: #188ae2">Rules Link</a>';
                    echo '</h4>';
                  
                  }
                  if ($rulesNotes) { ?>
                  <hr>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#shareWishlist" aria-expanded="false" type="button" class="btn btn-default share-wishlist">Share Rules</a>
                  <?php } ?>

                </div>

              </div><!-- .stream-post -->

              <div class="m-t-l" style="margin-top: 10px;">
                  <?php
                  if ($linkedGame) {
                    $query = " 
                              SELECT * FROM game_details 
                              WHERE 
                                  id = :linkedgameid
                                  AND user_id = :userid
                          "; 
                           
                          $query_params = array( 
                              ':linkedgameid' => $linkedGame,
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

                          $rowzz = $stmt->fetchAll();
                          if ($rowzz) {
                              foreach ($rowzz as $zz) {
                                $linkedId = $zz['id'];
                                $linkedName = $zz['name'];
                              }
                          }
                      echo '<a href="link_game.php?id='.$gameId.'" style="color: #6A6C6F; text-decoration: none;"><h4 class="m-0 m-t-xs text-right" style="padding-top: 5px;"><span class="zmdi zmdi-hc-lg zmdi-link"></span>&nbsp;&nbsp;<a href="game_details.php?id='.$linkedId.'" style="color: #188ae2; text-decoration: none;">'.$linkedName.'</a></h4></a>';
                  }
                  else {
                    echo '<h4 class="m-0 m-t-xs text-right" style="padding-top: 5px;"><a href="link_game.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="zmdi zmdi-hc-lg zmdi-link"></span>&nbsp;&nbsp;Link games</a></h4>';
                  }
                  ?>
                </div>

              <div id="shareWishlist" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Sharing your Game Rules</h4>
                    </div>
                    <div class="modal-body">
                      <p>If you would like to share this game's rules with someone, simply press the following button to copy your Public Game Details URL and send it to whomever you would like!</p>
                      <small><b>Note: </b>If you have chosen to make your Game Library public in your <a href="settings.php">Account Settings</a>, your game rules and basic Game Info can be shared (all other notes and cost details are private). Otherwise, no game details will appear.</small>
                      
                      <hr>
                      <div class="text-center">
                      <p style="display: inline-block;"></p>
                      
                      <div id="btn" style="display: inline-block;" data-clipboard-text="gameapp.codingerik.com/user_game_details.php?id=<?php echo $gameId;?>">
                      <button class="btn btn-info btn-default" data-dismiss="modal" style="display: inline-block; margin-bottom:2px; margin-left:5px;">Copy Share Url</button>
                      </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>

                </div>
              </div>
              
            </div><!-- .tab-pane -->
            
            <div role="tabpanel" id="notes" class="tab-pane fade p-md">

              <div class="media stream-post" style="padding-top: 5px; ">
                <div class="media-body">
                  <h4 class="media-heading" style="float: right; margin-top:0px;">
                    <?php echo '<a href="edit_notes.php?id='.$gameId.'" style="color: lightgrey; font-size: 16px; margin-left: 8px;"><span class="glyphicon glyphicon-pencil"></span></a>'; ?>
                  </h4>
                  <div class="stream-body m-t-l" style="margin-top: 10px; word-break: break-word;">
                    <?php echo '<a href="edit_notes.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">';
                    if ($notes) { echo '<p>'.htmlspecialchars_decode($notes, ENT_QUOTES).'</p>';} else {echo '<h4 class="m-0 m-t-xs" style="color: #188ae2;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span>Add</h4>';}
                    echo '</a>';
                    ?>
                  </div>
                </div>
              </div><!-- .stream-post -->
              
            </div><!-- .tab-pane -->

            <div role="tabpanel" id="details" class="tab-pane fade" style="padding-top: 25px;">

              <div class="media stream-post" style="padding-top: 5px;">
                <div class="media-body">
                  <div class="col-md-6 col-md-offset-3">
                  <table class="table table-sm" style="font-size:18px; margin-bottom: 20px;">
                      <thead style="background-color: #188AE2; color: white;">
                      <tr><td style="width: 60%;"><b>Details:</b></td><td><?php echo '<a href="edit_game_details.php?id='.$gameId.'" style="color: lightgrey; float: right;"><span class="glyphicon glyphicon-pencil" style="font-size: 14px; padding-right: 12px;"></span></a>'; ?></td></tr>
                      
                    </thead>
                  <?php
                  if ($list == 1) {
                    if ($knowledge) {
                     echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Status: </td><td><a href="edit_knowledge.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$knowledge.'</a></td>';
                      echo '</tr>';
                    }
                    else {
                      echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Status: </td><td><a href="edit_knowledge.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                      echo '</tr>';
                    }
                  }
                  else {
                    if ($status) {
                     echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Status: </td><td><a href="edit_status.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$status.'</a></td>';
                      echo '</tr>';
                    }
                    else {
                      echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Status: </td><td><a href="edit_status.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                      echo '</tr>';
                    }
                  }
                  ?>
                  <?php
                  if ($myplayers) {
                  echo '<tr>';
                    echo '<td style="padding-right: 10px; word-break: break-word;">Players: </td><td><a href="edit_players.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$myplayers.' people</a></td>';
                    echo '</tr>';
                  }
                  else {
                    echo '<tr>';
                    echo '<td style="padding-right: 10px; word-break: break-word;">Players: </td><td><a href="edit_players.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                    echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($playwith) {
                  echo '<tr>';
                    echo '<td style="padding-right: 10px; word-break: break-word;">Play With: </td><td><a href="edit_play_with.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$playwith.'</a></td>';
                    echo '</tr>';
                  }
                  else {
                    echo '<tr>';
                    echo '<td style="padding-right: 10px; word-break: break-word;">Play With: </td><td><a href="edit_play_with.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                    echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($sort) {
                    if ($sort == 'desc') {
                      $scoring = "Highscore wins";
                    }
                    elseif ($sort == 'asc') {
                      $scoring = "Lowscore wins";
                    }
                    elseif ($sort == 'coop') {
                      $scoring = "Cooperative";
                    }
                    elseif ($sort == 'set') {
                      $scoring = "Flat-point win";
                    }
                    elseif ($sort == 'money') {
                      $scoring = "Currency";
                    }
                    elseif ($sort == 'other') {
                      $scoring = "No points awarded";
                    }
                    elseif ($sort == 'lose') {
                      $scoring = "Loser loses game";
                    }
                    else {
                      $scoring = "Highscore wins";
                    }
                  
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Scoring: </td><td><a href="edit_scoring.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$scoring.'</a></td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($myplaytime) {
                  echo '<tr>';
                    echo '<td style="padding-right: 10px; word-break: break-word;">Playtime: </td><td><a href="edit_playtime.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$myplaytime.' mins</a></td>';
                    echo '</tr>';
                  }
                  else {
                  echo '<tr>';
                    echo '<td style="padding-right: 10px; word-break: break-word;">Playtime: </td><td><a href="edit_playtime.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                    echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($bggWeight) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Weight: </td><td><a href="edit_weight.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.number_format((float)$bggWeight, 1, '.', '').'/5.0</a></td>';
                      echo '</tr>';
                  }
                  else {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Weight: </td><td><a href="edit_weight.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($type) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Type 1: </td><td><a href="edit_type.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$type.'</a></td>';
                      echo '</tr>';
                  }
                  else {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Type 1: </td><td><a href="edit_type.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($type2) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Type 2: </td><td><a href="edit_type.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$type2.'</a></td>';
                      echo '</tr>';
                  }
                  else {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Type 2: </td><td><a href="edit_type.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($bggYear) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Published: </td><td><a href="edit_published_year.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$bggYear.'</a></td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($publisher) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Publisher: </td><td><a href="edit_publisher.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$publisher.'</a></td>';
                      echo '</tr>';
                  }
                  else {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Publisher: </td><td><a href="edit_publisher.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($purchase) {
                   echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Purchased: </td><td><a href="edit_purchase_date.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.$purchase.'</a></td>';
                      echo '</tr>';
                  }
                  else {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Purchased: </td><td><a href="edit_purchase_date.php?id='.$gameId.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($cost) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Cost: </td><td><a href="edit_cost.php?id='.$gameId.'&search='.$searchName.'" style="color: #6a6c6f; text-decoration: none;">$'.$cost.'</a></td>';
                      echo '</tr>';
                  }
                  else {
                    echo '<tr>';
                    echo '<td style="padding-right: 10px; word-break: break-word;">Cost: </td><td><a href="edit_cost.php?id='.$gameId.'&search='.$searchName.'" style="color: #188ae2; text-decoration: none;"><span class="glyphicon glyphicon-plus" style="font-size:12px;top:-1px;"></span> Add</a></td>';
                    echo '</tr>';
                  }
                  ?>

                  
                  
                  <?php
                  /*if ($bggType) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">BGG type: </td><td>'.$bggType.'</td>';
                      echo '</tr>';
                  }*/
                  ?>
                  
                  
                  <?php
                  if ($url) {
                    echo '<tr>';
                      echo '<td style="padding: 18px 0px 18px 14px;" colspan="2"><a href="get_game_reviews.php?id='.$bggid.'&name='.$name.'&list=mygames&gameid='.$gameId.'" style="color: #188ae2"><b>Game Reviews</b></a></td>';
                     echo '</tr>';
                   }
                   echo '<tr>';
                      echo '<td style="padding: 0px;" colspan="2">&nbsp;</td>';
                      echo '</tr>';
                     ?>
                   </table>
                  <table class="table table-sm" style="font-size:18px; margin-bottom: 20px;">
                      <thead style="background-color: #188AE2; color: white;">
                      <tr><td style="width: 60%;"><b>Description:</b></td><td>&nbsp;</td></tr>
                    </thead>
                  <?php
                  if ($bggDescription) {
                    
                    echo '<tr >';
                    echo '<td colspan="2" style="word-break: break-word;">'.$bggDescription.'</td>';
                  echo '</tr>';
                  }
                  elseif ($mydescription) {
                    
                    echo '<tr >';
                    echo '<td colspan="2"><p><a href="add_description.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">'.htmlspecialchars_decode($mydescription, ENT_QUOTES).'</p></a></td>';
                  echo '</tr>';
                  }
                  else {
                    echo '<tr >';
                    echo '<td colspan="2"><a href="add_description.php?id='.$gameId.'" style="color: #6a6c6f; text-decoration: none;">Click here to add your own description or add BGG Url in Edit Game.</a></td>';
                  echo '</tr>';
                  }
                  ?>
                  </table>
                </div>
                </div>
              </div><!-- .stream-post -->

            </div><!-- .tab-pane -->

            <div role="tabpanel" id="stats" class="tab-pane fade" style="padding-top: 25px;">

              <div class="media stream-post" style="padding-top: 5px;">
                <div class="media-body">
                  
                  <?php if ($list == 1) { ?>
                <div class="col-md-4 col-md-offset-4" style="padding-bottom: 20px;">
                  <?php if ($sort != 'other' && $sort != 'coop' && $sort != 'set' && $sort != 'lose') { 
                    if ($sort == 'desc') {
                      $highscore = "(highest)";
                    }
                    elseif ($sort == 'asc') {
                      $highscore = "(lowest)";
                    }
                    elseif ($sort == 'money') {
                      $sort = 'desc';
                      $highscore = "(currency)";
                    }
                    ?>
                  <table class="table table-sm" style="font-size:18px; margin-bottom: 20px;">
                    <thead style="background-color: #188AE2; color: white;">
                      <tr><td colspan="2"><b>Best score <?php echo $highscore; ?>:</b></td></tr>
                    </thead>
                  <?php
                    $query = " 

                        SELECT *
                        FROM gameplay WHERE (user_id=:userid AND game_id=:gameid) AND (winning_score IS NOT null)
                        ORDER BY winning_score $sort, timestamp asc
                        
                    "; 
                     
                    $query_params = array( 
                      ':userid' => $_SESSION['userid'],
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
                    $rows = $stmt->fetchAll();
                      if ($rows) {
                        if ($highscore == '(currency)') {
                          if ($rows[0]['winner']) {
                            echo '<tr>';
                            echo '<td style="padding-right: 10px; width: 78%;">'.$rows[0]['winner'].'</td><td>$'.$rows[0]['winning_score'].'</td>';
                            echo '</tr>';
                          }
                          else {
                              echo '<tr>';
                              echo '<td style="padding-right: 10px;">Unknown</td><td>$'.$rows[0]['winning_score'].'</td>';
                              echo '</tr>';
                          }
                        }
                        else {
                          if ($rows[0]['winner']) {
                            echo '<tr>';
                            echo '<td style="padding-right: 10px; width: 78%;">'.$rows[0]['winner'].'</td><td>'.($rows[0]['winning_score'] + 0).'</td>';
                            echo '</tr>';
                          }
                          else {
                              echo '<tr>';
                              echo '<td style="padding-right: 10px;">Unknown</td><td>'.($rows[0]['winning_score'] + 0).'</td>';
                              echo '</tr>';
                          }
                        }
                      }
                     else {
                        echo '<tr>';
                          echo '<td style="padding-right: 10px;">No stats</td>';
                          echo '</tr>';
                      }
                  ?>
                  </table>
                <div class="clearfix"></div>

                <table class="table table-sm" style="font-size:18px; margin-bottom: 20px;">
                    <thead style="background-color: #10C469; color: white;">
                      <tr><td colspan="2"><b>Average winning score:</b></td></tr>
                    </thead>
                  <?php
                   $query = " 
                        SELECT COUNT(*) 
                        FROM gameplay WHERE (user_id=:userid AND game_id=:gameid) AND (winning_score IS NOT null)
                    "; 
                     
                    $query_params = array( 
                        ':userid' => $_SESSION['userid'],
                        ':gameid' => $id
                    ); 
                     
                    try 
                    { 
                        $result = $db->prepare($query); 
                        $result->execute($query_params); 
                        $totalWinningScoreCount = $result->fetchColumn(0);
                    } 
                    catch(PDOException $ex) 
                    { 
                        die($ex); 
                    } 

                    $query = " 
                        SELECT SUM(winning_score) 
                        FROM gameplay WHERE (user_id=:userid AND game_id=:gameid) AND (winning_score IS NOT null)
                    "; 
                     
                    $query_params = array( 
                        ':userid' => $_SESSION['userid'],
                        ':gameid' => $id
                    ); 
                     
                    try 
                    { 
                        $result = $db->prepare($query); 
                        $result->execute($query_params); 
                        $totalWinningScores = $result->fetchColumn(0);
                    } 
                    catch(PDOException $ex) 
                    { 
                        die($ex); 
                    } 
                    
                    $averageWinningScore = ($totalWinningScores/$totalWinningScoreCount);

                      if ($averageWinningScore) {
                        if (is_nan($averageWinningScore)) {
                          echo '<tr>';
                            echo '<td style="padding-right: 10px;">No stats</td>';
                            echo '</tr>';
                        }
                        else {
                          if ($highscore == '(currency)') {
                              echo '<tr>';
                              echo '<td style="padding-right: 10px;">$'.round($averageWinningScore, 0).'</td>';
                              echo '</tr>';
                          }
                          else {
                              echo '<tr>';
                              echo '<td style="padding-right: 10px;">'.round($averageWinningScore, 0).'</td>';
                              echo '</tr>';
                          }
                        }
                      }
                     else {
                        echo '<tr>';
                          echo '<td style="padding-right: 10px;">No stats</td>';
                          echo '</tr>';
                      }
                  ?>
                  </table>
                <div class="clearfix"></div>
                <table class="table table-sm" style="font-size:18px; margin-bottom: 20px;">
                    <thead style="background-color: #FF5B5B; color: white;">
                      <tr><td colspan="2"><b>Average losing score:</b></td></tr>
                    </thead>
                  <?php
                   $query = " 
                        SELECT COUNT(*) 
                        FROM gameplay WHERE (user_id=:userid AND game_id=:gameid) AND (losing_score IS NOT null)
                    "; 
                     
                    $query_params = array( 
                        ':userid' => $_SESSION['userid'],
                        ':gameid' => $id
                    ); 
                     
                    try 
                    { 
                        $result = $db->prepare($query); 
                        $result->execute($query_params); 
                        $totalLosingScoreCount = $result->fetchColumn(0);
                    } 
                    catch(PDOException $ex) 
                    { 
                        die($ex); 
                    } 

                    $query = " 
                        SELECT SUM(losing_score) 
                        FROM gameplay WHERE (user_id=:userid AND game_id=:gameid) AND (losing_score IS NOT null)
                    "; 
                     
                    $query_params = array( 
                        ':userid' => $_SESSION['userid'],
                        ':gameid' => $id
                    ); 
                     
                    try 
                    { 
                        $result = $db->prepare($query); 
                        $result->execute($query_params); 
                        $totalLosingScores = $result->fetchColumn(0);
                    } 
                    catch(PDOException $ex) 
                    { 
                        die($ex); 
                    } 
                    
                    $averageLosingScore = ($totalLosingScores/$totalLosingScoreCount);

                      if ($averageLosingScore) {
                        if (is_nan($averageLosingScore)) {
                          echo '<tr>';
                            echo '<td style="padding-right: 10px;">No stats</td>';
                            echo '</tr>';
                        }
                        else {
                          if ($highscore == '(currency)') {
                              echo '<tr>';
                              echo '<td style="padding-right: 10px;">$'.round($averageLosingScore, 0).'</td>';
                              echo '</tr>';
                          }
                          else {
                              echo '<tr>';
                              echo '<td style="padding-right: 10px;">'.round($averageLosingScore, 0).'</td>';
                              echo '</tr>';
                          }
                        }
                      }
                     else {
                        echo '<tr>';
                          echo '<td style="padding-right: 10px;">No stats</td>';
                          echo '</tr>';
                      }
                  ?>
                  </table>
                  <div class="clearfix"></div>
                <table class="table table-sm" style="font-size:18px; margin-bottom: 20px;">
                    <thead style="background-color: #F9C851; color: white;">
                      <tr><td colspan="2"><b>Average overall score:</b></td></tr>
                    </thead>
                  <?php
                   $query = " 
                        SELECT COUNT(*) 
                        FROM gameplay WHERE (user_id=:userid AND game_id=:gameid) AND (extra_players_score IS NOT null || winning_score IS NOT null)
                    "; 
                     
                    $query_params = array( 
                        ':userid' => $_SESSION['userid'],
                        ':gameid' => $id
                    ); 
                     
                    try 
                    { 
                        $result = $db->prepare($query); 
                        $result->execute($query_params); 
                        $totalScoreCount = $result->fetchColumn(0);
                    } 
                    catch(PDOException $ex) 
                    { 
                        die($ex); 
                    } 

                    $query = " 
                        SELECT SUM(extra_players_score) 
                        FROM gameplay WHERE (user_id=:userid AND game_id=:gameid) AND (extra_players_score IS NOT null)
                    "; 
                     
                    $query_params = array( 
                        ':userid' => $_SESSION['userid'],
                        ':gameid' => $id
                    ); 
                     
                    try 
                    { 
                        $result = $db->prepare($query); 
                        $result->execute($query_params); 
                        $totalExtraScores = $result->fetchColumn(0);
                    } 
                    catch(PDOException $ex) 
                    { 
                        die($ex); 
                    } 
                    
                    $averageScore = (($totalExtraScores+$totalWinningScores)/$totalScoreCount);

                      if ($averageLosingScore) {
                        if (is_nan($averageScore)) {
                          echo '<tr>';
                            echo '<td style="padding-right: 10px;">No stats</td>';
                            echo '</tr>';
                        }
                        else {
                          if ($highscore == '(currency)') {
                              echo '<tr>';
                              echo '<td style="padding-right: 10px;">$'.round($averageScore, 0).'</td>';
                              echo '</tr>';
                          }
                          else {
                              echo '<tr>';
                              echo '<td style="padding-right: 10px;">'.round($averageScore, 0).'</td>';
                              echo '</tr>';
                          }
                        }
                      }
                     else {
                        echo '<tr>';
                          echo '<td style="padding-right: 10px;">No stats</td>';
                          echo '</tr>';
                      }
                  ?>
                  </table>
                <div class="clearfix"></div>
                <?php } ?>
                  <table class="table table-sm" style="font-size:18px; margin-bottom: 20px;">
                    <thead style="background-color: #FF8ACC; color: white;">
                      <tr><td ><b>Average playtime:</b></td><td>&nbsp;</td></tr>
                    </thead>
                  <?php
                    $query = " 
                          SELECT COUNT(*) 
                          FROM gameplay
                          WHERE (user_id = :userid AND game_id=:gameid) AND ! (play_time = :null AND play_time = :nothing);
                      "; 
                       
                      $query_params = array( 
                          ':userid' => $_SESSION['userid'],
                          ':gameid' => $id,
                          ':null' => null,
                          ':nothing' => ""
                      ); 
                       
                      try 
                      { 
                          $result = $db->prepare($query); 
                          $result->execute($query_params); 
                          $timedGameCount = $result->fetchColumn(0);
                      } 
                      catch(PDOException $ex) 
                      { 
                          die($ex); 
                      } 

                      $query = " 
                          SELECT SUM(play_time) 
                          FROM gameplay
                          WHERE (user_id = :userid AND game_id=:gameid) AND play_time IS NOT null;
                      "; 
                       
                      $query_params = array( 
                          ':userid' => $_SESSION['userid'],
                          ':gameid' => $id
                      ); 
                       
                      try 
                      { 
                          $result = $db->prepare($query); 
                          $result->execute($query_params); 
                          $sumOfPlaytime = $result->fetchColumn(0);
                      } 
                      catch(PDOException $ex) 
                      { 
                          die($ex); 
                      } 

                      $averagePlaytime = ($sumOfPlaytime/$timedGameCount);
                      if ($sumOfPlaytime) {
                            echo '<tr>';
                            echo '<td style="padding-right: 10px; word-break: break-word;">'.round($averagePlaytime, 0).' mins</td>';
                            echo '</tr>';
                      }
                      else {
                        echo '<tr>';
                          echo '<td style="padding-right: 10px; word-break: break-word;">No stats</td>';
                          echo '</tr>';
                      }
                     
                  ?>
                  </table>
                <div class="clearfix"></div>
                  <table class="table table-sm" style="font-size:18px;">
                    <thead style="background-color: #5B69BC; color: white;">
                      <?php
                      if ($sort == 'lose') {
                        echo '<tr><td ><b>Number of losses:</b></td><td>&nbsp;</td></tr>';
                      }
                      else {
                        echo '<tr><td ><b>Number of wins:</b></td><td>&nbsp;</td></tr>';
                      }
                      ?>
                    </thead>
                  <?php
                    $query = " 

                        SELECT *, COUNT(case when winner is null then game_id else winner end)
                        FROM gameplay WHERE winner IS NOT null AND user_id=:userid AND game_id=:gameid
                        GROUP BY winner ORDER BY COUNT(winner) desc, winner asc 
                        
                    "; 
                     
                    $query_params = array( 
                      ':userid' => $_SESSION['userid'],
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
                    $rows = $stmt->fetchAll();
                      if ($rows) {
                        foreach ($rows as $x) {
                          if ($x['winner']) {
                            echo '<tr>';
                            echo '<td style="padding-right: 10px;">'.ucfirst($x['winner']).'</td><td>'.$x['COUNT(case when winner is null then game_id else winner end)'].'</td>';
                            echo '</tr>';
                          }
                          else {
                            echo '<tr>';
                            echo '<td style="padding-right: 10px;">Unknown</td><td>'.$x['COUNT(case when winner is null then game_id else winner end)'].'</td>';
                            echo '</tr>';
                          }
                        }
                      }
                      else {
                        echo '<tr>';
                          echo '<td style="padding-right: 10px;">No stats</td>';
                          echo '</tr>';
                      }
                     
                  ?>
                  </table>
                  
                  
                </div>
                  <?php if ($numberofplays) {echo '<div class="col-md-4 col-md-offset-4" style="padding-bottom: 20px;"><a href="gameplay_log.php?id='.$gameId.'&name='.$name.'"><button class="btn btn-primary" style="width: 140px;">Gameplay Log</button></a></div>';} ?>

                <?php } 
                else { ?>
                <div class="col-md-12">
                  <div class="stream-body m-t-l">
                  <p style="font-size: 16px; padding-left:5px; padding-bottom:18px;">Stats appear in Library.</p>
                    </div>
                </div>
                <?php } ?>


            </div><!-- .tab-pane -->

          
      </div><!-- END column -->

      
    </div><!-- .row -->
    <?php 
      if ($list == 1 || ($list == 2 && $wishlistOrder != null) || $list == 3) {
        echo '<a href="previous_game.php?name='.$name.'&list='.$list.'&order='.$wishlistOrder.'" style="float:left; margin: 20px 0px;"><button id="previousGame" class="btn btn-default" style="width: 105px;"><i class="zmdi zmdi-long-arrow-left"></i> Previous</button></a>
        <a href="next_game.php?name='.$name.'&list='.$list.'&order='.$wishlistOrder.'" style="float:right; margin: 20px 0px;"><button id="nextGame" class="btn btn-default" style="width: 105px;">Next <i class="zmdi zmdi-long-arrow-right"></i></button></a>';
      }
    ?>
    
  </section><!-- #dash-content -->

</div><!-- .row -->


  <!-- APP FOOTER -->
  <div class="wrap p-t-0">
    <footer class="app-footer">
      <div class="clearfix">
        <?php include("copywrite.php"); ?>
      </div>
    </footer>
  </div>
  <!-- /#app-footer -->
</main>
<!--========== END app main -->

	<!-- build:js assets/js/core.min.js -->
	<script src="libs/bower/jQuery-Storage-API/jquery.storageapi.min.js"></script>
	<script src="libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js"></script>
	<script src="libs/bower/jquery-slimscroll/jquery.slimscroll.js"></script>
	<script src="libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
	<script src="libs/bower/PACE/pace.min.js"></script>
	<!-- endbuild -->

	<!-- build:js assets/js/app.min.js -->
	<script src="assets/js/library.js"></script>
	<script src="assets/js/plugins.js"></script>
	<script src="assets/js/app.js"></script>
  <script src="assets/js/main.js"></script>
	<!-- endbuild -->
	<script src="libs/bower/moment/moment.js"></script>
	<script src="libs/bower/fullcalendar/dist/fullcalendar.min.js"></script>
	<script src="assets/js/fullcalendar.js"></script>
  <script src="assets/js/clipboard.min.js"></script>
  <script>
    $(document).ready(function(){
      $( ".livesearch" ).click(function() {
      $( "#live-search" ).focus();
      });
    });
  </script>
  <script>
    $(document).ready(function(){
      $("#searchclose").click(function(){
        $("#livesearch").hide();
    });
    });
  </script>
  <script>
    $(document).ready(function(){
      $(".livesearch").click(function(){
        $("#livesearch").show();
    });
    });
  </script>
  <script type="text/javascript">
    function confirm_alert(node) {
       return confirm("Add gameplay?");
    }
  </script>

  <script>
    var btn = document.getElementById('btn');
    var clipboard = new Clipboard(btn);
    clipboard.on('success', function(e) {
        console.log(e);
        alert('URL copied to clipboard')
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });
    </script>
</body>
</html>