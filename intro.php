<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

            $query = " 
            SELECT COUNT(*) 
            FROM game_details
            WHERE user_id = :userid AND list_type=1;
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid']
        ); 
         
        try 
        { 
            $result = $db->prepare($query); 
            $result->execute($query_params); 
            $gameCount = $result->fetchColumn(0);
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 

        $query = " 
            SELECT COUNT(*) 
            FROM game_details
            WHERE (user_id = :userid AND list_type=1) AND ! (rating = :null AND rating = :nothing);
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid'],
            ':null' => null,
            ':nothing' => ""
        ); 
         
        try 
        { 
            $result = $db->prepare($query); 
            $result->execute($query_params); 
            $ratedGameCount = $result->fetchColumn(0);
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 

        $query = " 
            SELECT SUM(rating) 
            FROM game_details
            WHERE (user_id = :userid AND list_type=1) AND rating IS NOT null;
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid']
        ); 
         
        try 
        { 
            $result = $db->prepare($query); 
            $result->execute($query_params); 
            $sumOfRatings = $result->fetchColumn(0);
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 

        $averageRating = ($sumOfRatings/$ratedGameCount);

        $query = " 
            SELECT COUNT(*) 
            FROM game_details
            WHERE (user_id = :userid AND list_type=1) AND (gameplay_knowledge = 'Need Rules');
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid']
        ); 
         
        try 
        { 
            $result = $db->prepare($query); 
            $result->execute($query_params); 
            $needRulesGames = $result->fetchColumn(0);
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 

        $query = " 
            SELECT COUNT(*) 
            FROM game_details
            WHERE user_id = :userid AND list_type=1 AND gameplay_knowledge = 'Need to Learn';
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid']
        ); 
         
        try 
        { 
            $result = $db->prepare($query); 
            $result->execute($query_params); 
            $needToLearnGames = $result->fetchColumn(0);
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 

        $query = " 
            SELECT COUNT(*) 
            FROM game_details
            WHERE user_id = :userid AND list_type=1 AND gameplay_knowledge = 'Need Refresher';
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid']
        ); 
         
        try 
        { 
            $result = $db->prepare($query); 
            $result->execute($query_params); 
            $needRefresherGames = $result->fetchColumn(0);
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 

        $query = " 
            SELECT SUM(cost) 
            FROM game_details
            WHERE (user_id = :userid AND list_type=1) AND cost IS NOT null;
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid']
        ); 
         
        try 
        { 
            $result = $db->prepare($query); 
            $result->execute($query_params); 
            $valueOfLibrary = $result->fetchColumn(0);
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 

        $query = " 
            SELECT COUNT(*) 
            FROM game_details
            WHERE user_id = :userid AND list_type=2;
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid']
        ); 
         
        try 
        { 
            $result = $db->prepare($query); 
            $result->execute($query_params); 
            $wishlistGameCount = $result->fetchColumn(0);
        } 
        catch(PDOException $ex) 
        { 
            die($ex); 
        } 

        $query = " 
            SELECT * FROM game_details 
            WHERE (user_id = :userid AND list_type=1) AND (number_of_plays != '0')
            ORDER BY number_of_plays desc
            LIMIT 5;
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
          foreach ($rows as $x) {
            $topPlayedGames = $topPlayedGames."<tr><td><a href='./game_details.php?id=".$x['id']."'>".$x['name']."</a></td><td>".$x['number_of_plays']."</td></tr>";
          }
        }
        else {
          $topPlayedGames = "<tr><td>No games played</td><td> </tr></tr>";
        }

        $query = " 
            SELECT * FROM gameplay
            WHERE user_id = :userid 
            ORDER BY timestamp desc
            LIMIT 5;
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
          foreach ($rows as $x) {
            $recentPlayedGames = $recentPlayedGames."<tr><td><a href='gameplay_details.php?gameplayId=".$x['id']."&id=".$x['game_id']."&name=".$x['game_name']."'>".$x['game_name']."</a></td><td>".date("m-d-Y", strtotime($x['timestamp']))."</td></tr>";
          }
        }
        else {
          $recentPlayedGames = "<tr><td>No games played</td><td> </tr></tr>";
        }
            
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

    <a href="library.php" class="navbar-brand">
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
<aside id="menubar" class="menubar light">
  <div class="app-user">
    <div class="media">
      <div class="media-left">
        <div class="avatar avatar-md avatar-circle">
          <?php echo '<a href="javascript:void(0)"><img class="img-responsive" src="assets/images/'.$_SESSION['picture'].'" alt="avatar"/></a>'; ?>
        </div><!-- .avatar -->
      </div>
      <div class="media-body">
        <div class="foldable">
          <h5><a href="javascript:void(0)" class="username">Hey <?php echo ucfirst($_SESSION['username']); ?>!</a></h5>
          <ul>
            <li class="dropdown">
              <a href="javascript:void(0)" class="dropdown-toggle usertitle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <small>Options</small>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="text-color" href="library.php">
                    <span class="m-r-xs"><i class="fa fa-home"></i></span>
                    <span>Home</span>
                  </a>
                </li>
                <li>
                  <a class="text-color" href="profile.php">
                    <span class="m-r-xs"><i class="fa fa-user"></i></span>
                    <span>Profile</span>
                  </a>
                </li>
                <li>
                  <a class="text-color" href="settings.php">
                    <span class="m-r-xs"><i class="fa fa-gear"></i></span>
                    <span>Settings</span>
                  </a>
                </li>
                <li role="separator" class="divider"></li>
                <li>
                  <a class="text-color" href="logout.php">
                    <span class="m-r-xs"><i class="fa fa-sign-out"></i></span>
                    <span>Logout</span>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div><!-- .media-body -->
    </div><!-- .media -->
  </div><!-- .app-user -->

  <div class="menubar-scroll">
    <div class="menubar-scroll-inner">
      <ul class="app-menu">
        <li class="has-submenu">
          <a href="javascript:void(0)" class="submenu-toggle">
            <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
            <span class="menu-text">Dashboards</span>
            <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
          </a>
          <ul class="submenu">
            <li><a href="library.php"><span class="menu-text">Game Library</span></a></li>
            <!--<li><a href="gallery-view.php"><span class="menu-text">Gallery View</span></a></li>-->
            <li><a href="wish_list.php"><span class="menu-text">Wish List</span></a></li>
            <li><a href="stats.php"><span class="menu-text">Game Stats</span></a></li>
          </ul>
        </li>

        <li class="menu-separator"><hr></li>

        <li>
          <a href="help.php">
            <i class="menu-icon zmdi zmdi-help-outline zmdi-hc-lg"></i>
            <span class="menu-text">Help</span>
          </a>
        </li>
        
      </ul><!-- .app-menu -->
    </div><!-- .menubar-scroll-inner -->
  </div><!-- .menubar-scroll -->
</aside>
<!--========== END app aside -->

<!-- navbar search -->
<div id="navbar-search" class="navbar-search collapse">
  <div class="navbar-search-inner">
    <form style="margin-top: 5px; display: inline-block; width: 100%">
      <input class="form-control search-field" id="live-search" type="text" size="30" style="font-size: 16px;" onkeyup="showResult(this.value)" placeholder="Search your games" autofocus>
      <div id="livesearch" style="font-size: 18px; padding: 5px; padding-top:65px; width: 100%;"></div>
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
   
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <a href="library.php" style="color: #6a6c6f;"><div class="widget p-md clearfix">
          <div class="pull-left">
            <h3 class="widget-title">Total Number of Games</h3>
            <small class="text-color">In game library</small>
          </div>
          <span class="pull-right fz-lg fw-500"><?php echo $gameCount; ?></span>
        </div></a><!-- .widget -->
      </div>

      

      <div class="col-md-6 col-sm-6">
        <div class="widget p-md clearfix">
          <div class="pull-left">
            <form action="search_bgg.php" method="post" id="searchBGGForm">
              <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                <div class='input-group'>
                  <input type="text" name="search-string" class="form-control" placeholder="BoardGameGeek">
                  <span class="input-group-addon text-white" style="background-color: white;">
                    <a href="#" onclick="document.getElementById('searchBGGForm').submit();"><span class="glyphicon glyphicon-search"></span></a>
                  </span>
                  <span class="input-group-addon text-white" style="background-color: white;">
                    <a href="bgg_hotlist.php"><span class="glyphicon glyphicon-fire" style="color: #FF5B5B;"></span></a>
                  </span>
                </div>
              </div>
            </form>
          </div>
        </div><!-- .widget -->
      </div>

    </div><!-- .row -->

    <div class="row">
      <div class="col-md-3 col-sm-6">
        <a href="wish_list.php"><div class="widget stats-widget">
          <div class="widget-body clearfix">
            <div class="pull-left">
              <h3 class="widget-title text-primary"><?php echo $wishlistGameCount; ?></h3>
              <small class="text-color">Wishlist</small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-heart"></i></span>
          </div>
          <footer class="widget-footer bg-primary">
          </footer>
        </div></a><!-- .widget -->
      </div>

      <div class="col-md-3 col-sm-6">
        <a href="library.php?search=Rules"><div class="widget stats-widget">
          <div class="widget-body clearfix">
            <div class="pull-left">
              <h3 class="widget-title text-success"><?php echo $needRulesGames; ?></h3>
              <small class="text-color">Need Rules</small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-flag"></i></span>
          </div>
          <footer class="widget-footer bg-success">
          </footer>
        </div></a><!-- .widget -->
      </div>

      

      <div class="col-md-3 col-sm-6">
        <a href="library.php?search=Refresher"><div class="widget stats-widget">
          <div class="widget-body clearfix">
            <div class="pull-left">
              <h3 class="widget-title text-warning"><?php echo $needRefresherGames; ?></h3>
              <small class="text-color">Need Refresher</small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-bullseye"></i></span>
          </div>
          <footer class="widget-footer bg-warning">
          </footer>
        </div></a><!-- .widget -->
      </div>

      <div class="col-md-3 col-sm-6">
        <a href="library.php?search=Learn"><div class="widget stats-widget">
          <div class="widget-body clearfix">
            <div class="pull-left">
              <h3 class="widget-title text-danger"><?php echo $needToLearnGames; ?></h3>
              <small class="text-color">Need To Learn</small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-exclamation-circle"></i></span>
          </div>
          <footer class="widget-footer bg-danger">
          </footer>
        </div></a><!-- .widget -->
      </div>

      

    </div><!-- .row -->

    

    <div class="row">

      

      <div class="col-md-4 col-sm-4">
        <div class="widget">
          <header class="widget-header">
            <h4 class="widget-title">Most Played</h4>
          </header>
          <hr class="widget-separator"/>
          <div class="widget-body">
            <div class="table-responsive">              
              <table class="table no-cellborder">
                <thead>
                  <tr><th>Name</th><th>Play Count</th></tr>
                </thead>
                <tbody>
                  <?php echo $topPlayedGames; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- .widget -->
      </div><!-- END column -->

      <div class="col-md-4 col-sm-4">
        <div class="widget">
          <header class="widget-header">
            <h4 class="widget-title">Recently Played</h4>
          </header>
          <hr class="widget-separator"/>
          <div class="widget-body">
            <div class="table-responsive">              
              <table class="table no-cellborder">
                <thead>
                  <tr><th>Name</th><th>Date</th></tr>
                </thead>
                <tbody>
                  <?php echo $recentPlayedGames; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- .widget -->
      </div><!-- END column -->

      <div class="col-md-4 col-sm-4">
        <div class="widget p-md clearfix">
          <div class="pull-left">
            <h3 class="widget-title">Average Rating</h3>
            <small class="text-color">For rated games</small>
          </div>
          <span class="pull-right fz-lg fw-500"><?php echo round($averageRating, 1); ?></span>
        </div><!-- .widget -->
      </div>

      <div class="col-md-4 col-sm-4">
        <div class="widget p-md clearfix">
          <div class="pull-left">
            <h3 class="widget-title">Value of Library</h3>
            <small class="text-color">Total puchases</small>
          </div>
          <span class="pull-right fz-lg fw-500"><?php echo $valueOfLibrary; ?></span><span class="pull-right fz-lg fw-500">$</span>
        </div><!-- .widget -->
      </div>

    </div><!-- .row -->

    

  <!-- APP FOOTER -->
  <div class="wrap p-t-0">
    <footer class="app-footer">
      <div class="clearfix">
        <div class="copyright pull-right">&copy; CodingErik 2017</div>
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