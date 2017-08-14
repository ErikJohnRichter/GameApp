<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

    $request = 'my_players';
    $searchParam = 'Players';
    $order = 'name';

    if ($_POST['minPlayers'] == $_POST['maxPlayers']) {
        $players = $_POST['minPlayers'];
        $playerQuery = 'my_players = "'.$players.'" AND ';
    }
    elseif ($_POST['minPlayers'] != null && $_POST['maxPlayers'] != null) {
        $players = $_POST['minPlayers']."-".$_POST['maxPlayers'];
        $playerQuery = 'my_players = "'.$players.'" AND ';
    }
    elseif ($_POST['minPlayers'] == null && $_POST['maxPlayers'] != null) {
      if ($_POST['maxPlayerOperator'] == "less") {
        $players = $_POST['maxPlayers'];
        $playerQuery = 'max_players <= '.$players.' AND ';
      }
      elseif ($_POST['maxPlayerOperator'] == "greater") {
        $players = $_POST['maxPlayers'];
        $playerQuery = 'max_players >= '.$players.' AND ';
      }
      else {
        $players = $_POST['maxPlayers'];
        $playerQuery = 'my_players LIKE "%'.$players.'" AND ';
      }
    }
    elseif ($_POST['minPlayers'] != null && $_POST['maxPlayers'] == null) {
      if ($_POST['minPlayerOperator'] == "greater") {
        $players = $_POST['minPlayers'];
        $playerQuery = 'min_players >= '.$players.' AND ';
      }
      elseif ($_POST['minPlayerOperator'] == "less") {
        $players = $_POST['minPlayers'];
        $playerQuery = 'min_players <= '.$players.' AND ';
      }
      else {
        $players = $_POST['minPlayers'];
        $playerQuery = 'my_players LIKE "'.$players.'%" AND ';
      }
    }
    else {
        $players = $_POST['minPlayers'];
        $playerQuery = 'my_players = "'.$players.'" AND ';
    }
    

    $query = "SELECT * FROM game_details WHERE ";

    if ($_POST['name']) {
      $query = $query.'name LIKE "%'.$_POST['name'].'%" AND ';
    }

    if ($_POST['status']) {
      $query = $query.'gameplay_knowledge = "'.$_POST['status'].'" AND ';
    }

    if ($_POST['type']) {
      $query = $query.'(type = "'.$_POST['type'].'" OR type2 = "'.$_POST['type'].'")  AND ';
    }

    if ($_POST['rating']) {
      if ($_POST['ratingOperator'] == "greater") {
        $query = $query.'rating >= '.$_POST['rating'].' AND ';
      }
      elseif ($_POST['ratingOperator'] == "less") {
        $query = $query.'rating <= '.$_POST['rating'].' AND rating > 0 AND ';
      }
      else {
        $query = $query.'rating = '.$_POST['rating'].' AND ';
      }
      $request = 'rating';
      $searchParam = 'Rating';
      $order = 'ABS(rating) asc, name';
    }

    if ($_POST['minPlayers'] || $_POST['maxPlayers']) {
      $query = $query.''.$playerQuery;
      $order = 'my_players asc, name';
    }

    if ($_POST['weight']) {
      if ($_POST['weightOperator'] == "less") {
        $query = $query.'bgg_weight <= '.$_POST['weight'].' AND bgg_weight > 0 AND ';
      }
      elseif ($_POST['weightOperator'] == "greater") {
        $query = $query.'bgg_weight >= '.$_POST['weight'].' AND ';
      }
      else {
        $query = $query.'bgg_weight = '.$_POST['weight'].' AND ';
      }
      $request = 'bgg_weight';
      $searchParam = 'Weight';
      $order = 'bgg_weight asc, name';
    }

    if ($_POST['cost']) {
      if ($_POST['costOperator'] == "less") {
        $query = $query.'cost <= '.$_POST['cost'].' AND cost > 0 AND ';
      }
      elseif ($_POST['costOperator'] == "greater") {
        $query = $query.'cost >= '.$_POST['cost'].' AND ';
      }
      else {
        $query = $query.'cost = '.$_POST['cost'].' AND ';
      }
      $request = 'cost';
      $searchParam = 'Cost';
      $order = 'ABS(cost) asc, name';
    }

    if ($_POST['time']) {
      if ($_POST['timeOperator'] == "less") {
        $query = $query.'my_playtime <= '.$_POST['time'].' AND my_playtime > 0 AND ';
      }
      elseif ($_POST['timeOperator'] == "greater") {
        $query = $query.'my_playtime >= '.$_POST['time'].' AND ';
      }
      else {
        $query = $query.'my_playtime = '.$_POST['time'].' AND ';
      }
      $request = 'my_playtime';
      $searchParam = 'Time';
      $order = 'ABS(my_playtime) asc, name';
    }

    if ($_POST['playWith']) {
      $query = $query.'play_with LIKE "%'.$_POST['playWith'].'%" AND ';
    }

    if ($_POST['publisher']) {
      $query = $query.'publisher LIKE "%'.$_POST['publisher'].'%" AND ';
    }

    if ($_POST['scoring']) {
      $query = $query.'highscore = "'.$_POST['scoring'].'" AND ';
    }

    if ($_POST['purchaseDate']) {
      $query = $query.'purchase_date = "'.$_POST['purchaseDate'].'" AND ';
    }

    $query = $query.'user_id = '.$_SESSION['userid'].' AND list_type = 1 ORDER BY '.$order.' asc';

    
     
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
  <link rel="apple-touch-icon" href="assets/images/GameAppLogo2.png" />
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

    <button type="button" class="navbar-toggle navbar-toggle-right collapsed">
      <span class="sr-only">Toggle navigation</span>
      <a href="create_game.php?list=1" style="color: #fff;"><span class="zmdi zmdi-hc-lg zmdi-plus"></span></a>
    </button>

    <a href="stats.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      

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

<!-- APP ASIDE ==========-->
<?php include("side_bar.php"); ?>
<!--========== END app aside -->

<!-- navbar search -->
<div id="navbar-search" class="navbar-search collapse">
  <div class="navbar-search-inner">
    <form style="margin-top: 5px; display: inline-block; width: 100%">
      <input class="form-control search-field" id="live-search" type="text" size="30" style="font-size: 16px;" onkeyup="showResult(this.value)" placeholder="Search Games" autofocus>
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

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
  <section class="app-content">
    <?php echo '<a href="advanced_search.php" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px; padding-top: 20px;"></i></a>'; ?>
    <div class="row text-center">
      <div class="col-md-4 col-md-offset-4">
        <h3 class="profile-info-name" style="font-size: 30px; margin-top: 15px; margin-bottom: 30px;">Advanced Search Results</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="widget p-md clearfix">
          <!--<form action="bgg_hotlist_cronjob.php" method="post">
            <button type="submit">Submit</button>
          </form>-->
      <table class="table table-hover">
        <thead>
          <tr>
            <td>&nbsp;</td><td>&nbsp;</td><td><b><?php echo $searchParam; ?></b></td>
          </tr>
        </thead>

      <?php


      if ($rows) {
        $i = 0;
        foreach ($rows as $x) {
          $gameName = $x['name'];
          $id = $x['id'];
          $bggid = $x['bgg_id'];
          $searchRequest = $x[$request];
          if ($request == 'bgg_weight') {
            $searchRequest = number_format((float)$searchRequest, 1, '.', '');
          }

          $urlName = str_replace(" ","%20",$gameName);
          $name = (strlen($gameName) > 35) ? substr($gameName,0,32).'...' : $gameName;

          if ($i == 0) {
          echo '<tr class="clickable-row" data-href="game_details.php?id='.$id.'">';
          echo '<td style="border-top: 0px solid white;"><img src="./images/'.$bggid.'.jpg" onerror="this.src=\'./images/noimage.jpg\'" style="max-height:125px;max-width:75px;"></td>';
          echo '<td style="border-top: 0px solid white;">'.$name.'</td>';
          echo '<td style="border-top: 0px solid white; width:18%;">'.$searchRequest.'</td>';
          echo '</tr>';
          }

          else {
          echo '<tr class="clickable-row" data-href="game_details.php?id='.$id.'">';
          echo '<td><img src="./images/'.$bggid.'.jpg" onerror="this.src=\'./images/noimage.jpg\'" style="max-height:125px;max-width:75px;"></td>';
          echo '<td>'.$name.'</td>';
          echo '<td style="width:18%;">'.$searchRequest.'</td>';
          echo '</tr>';
          }
          $i++;
        }
        
        
    }         
    else {
          echo '<tr><td style="border-top: 0px solid white;">No results</td></tr>';
        }
      
      ?>
    </table>
  </div>
  </div>
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
	<script src="libs/bower/jquery/dist/jquery.js"></script>
  <script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
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
  <script>
  jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
  </script>
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
</body>
</html>