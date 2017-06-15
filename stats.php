<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

    date_default_timezone_set('CST');

    $halfhour = 1800;
    $expires = $halfhour + time();

    // check if visit cookie exists and increment it, otherwise, this must be visit 1
    $count = isset($_COOKIE['visitCount1']) ? ++$_COOKIE['visitCount1'] : 1;

    // set cookies at the start, before outputting anything
    // sets the path. / will mean the cookie works for the whole site
    setcookie('visitCount1', $count, $expires, '/');

    if(isset($_COOKIE['visitCount1'])){
        //echo "You have viewed this page $count times.";
    } else {
        $timestamp = date('Y-m-d G:i:s', strtotime('-5 hours'));
        $query = " 
        INSERT INTO login_logging ( 
            user_id,
            username,
            timestamp
            
        ) VALUES (
            :userid, 
            :username,
            :timestamp
        ) 
        "; 
         
        $query_params = array( 
            ':userid' => $_SESSION['userid'],
            ':username' => $_SESSION['username'],
            ':timestamp' => $timestamp
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

    

    $customSearchString = $_SESSION['customfilter'];
    if ($customSearchString == null) {
      $customSearchString = 'None';
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
            WHERE (user_id = :userid AND list_type=1) AND gameplay_knowledge = :customfilter;
        "; 
         
        $query_params = array( 
          ':customfilter' => $customSearchString,
            ':userid' => $_SESSION['userid']
        ); 
         
        try 
        { 
            $result = $db->prepare($query); 
            $result->execute($query_params); 
            $customFilterGames = $result->fetchColumn(0);
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
            ORDER BY number_of_plays desc, name asc
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
            $topPlayedGames = $topPlayedGames."<tr class='clickable-row' data-href='./game_details.php?id=".$x['id']."'><td style='padding-left:10px;'><a href='./game_details.php?id=".$x['id']."'>".$x['name']."</a></td><td>".$x['number_of_plays']."</td></tr>";
          }
        }
        else {
          $topPlayedGames = "<tr><td style='padding-left:10px;'>No games played</td><td> </tr></tr>";
        }

        $query = " 
            SELECT * FROM gameplay
            WHERE winner IS NOT null AND user_id = :userid 
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
            $recentPlayedGames = $recentPlayedGames."<tr class='clickable-row' data-href='gameplay_details.php?gameplayId=".$x['id']."&id=".$x['game_id']."&name=".$x['game_name']."'><td style='padding-left:10px;'><a href='gameplay_details.php?gameplayId=".$x['id']."&id=".$x['game_id']."&name=".$x['game_name']."'>".$x['game_name']."</a></td><td>".date("m-d-Y", strtotime($x['timestamp']))."</td></tr>";
          }
        }
        else {
          $recentPlayedGames = "<tr><td style='padding-left:10px;'>No games played</td><td> </tr></tr>";
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
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-96191447-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
	
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<!--============= start main area -->

<!-- APP NAVBAR ==========-->
<nav id="app-navbar" class="navbar navbar-inverse navbar-fixed-top primary">
  
  <!-- navbar header -->
  <div class="navbar-header">

    <!--
     <button type="button" class="navbar-toggle navbar-toggle-left collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="zmdi zmdi-hc-lg zmdi-more"></span>
    </button>

    <button type="button" id="menubar-toggle-btn" class="navbar-toggle visible-xs-inline-block navbar-toggle-right hamburger hamburger--collapse js-hamburger">
      <span class="sr-only">Toggle navigation</span>
      <span class="hamburger-box"><span class="hamburger-inner"></span></span>
    </button>
  -->

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

        <li>
          <a href="stats.php">
            <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
            <span class="menu-text">Game Stats</span>
          </a>
        </li>

        <li>
          <a href="library.php">
            <i class="menu-icon zmdi zmdi-library zmdi-hc-lg"></i>
            <span class="menu-text">Game Library</span>
          </a>
        </li>

        <li>
          <a href="wish_list.php">
            <i class="menu-icon zmdi zmdi-cake zmdi-hc-lg"></i>
            <span class="menu-text">Wish List</span>
          </a>
        </li>

        <li class="menu-separator"><hr></li>

        <li>
          <a href="profile.php">
            <i class="menu-icon zmdi zmdi-account zmdi-hc-lg"></i>
            <span class="menu-text">Profile</span>
          </a>
        </li>

        <li>
          <a href="social.php">
            <i class="menu-icon zmdi zmdi-accounts zmdi-hc-lg"></i>
            <span class="menu-text">Social</span>
          </a>
        </li>

        <li>
          <a href="settings.php">
            <i class="menu-icon zmdi zmdi-settings zmdi-hc-lg"></i>
            <span class="menu-text">Settings</span>
          </a>
        </li>

        <li class="menu-separator"><hr></li>

        <li>
          <a href="help.php">
            <i class="menu-icon zmdi zmdi-help-outline zmdi-hc-lg"></i>
            <span class="menu-text">Help</span>
          </a>
        </li>

        <li>
          <a href="javascript:void(0)" data-toggle="collapse" class="livesearch" data-target="#navbar-search" aria-expanded="false">
            <i class="menu-icon zmdi zmdi-hc-lg zmdi-search"></i>
            <span class="menu-text">Search</span>
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

    <div class="row" id="notification" style="display: none;">
      <div class="col-md-12 col-sm-12">
          <div class="alert alert-success">
            <h3 class="widget-title">Welcome to GameApp!</h3>
            <p>This is your Stats Dashboard. Here, you will see stats about your Game Library. Let's get started by adding your first game!</p>
            <br>
            <p style="padding-top:5px;">To add games, you may do one of three things:</p>
            <p><b>1)</b> If you have a BoardGameGeek collection, import it in <a href="settings.php">Settings</a> or</p>
            <p><b>2)</b> Search for the game in the BoardGameGeek search bar below, or</p>
            <p><b>3)</b> Click the "+" button in the navbar to manually add a game.</p>
          </div>
      </div>
    </div><!-- .row -->
   
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <a href="library.php" style="color: #6a6c6f;"><div class="widget p-md clearfix feature">
          <div class="pull-left">
            <h3 class="widget-title">Total Number of Games</h3>
            <small class="text-color">In Game Library</small>
          </div>
          <span class="pull-right fz-lg fw-500"><?php echo $gameCount; ?></span>
        </div></a><!-- .widget -->
      </div>

      <!--<div class="col-md-4 col-sm-4">
        <div class="widget p-md clearfix" style="background: #white;">
          <div class="pull-left">
              <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                <div class='input-group'>
                  <input type="text" name="search-string" class="form-control bggSearch livesearch" data-toggle="collapse" data-target="#navbar-search" aria-expanded="false" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Search My Games" style="background: white;">
                  <span class="input-group-addon text-white bggSpan bggSpan1" style="background-color: white;">
                    <a href="library.php"><span class="glyphicon glyphicon-book"></span></a>
                  </span>
                  <span class="input-group-addon text-white bggSpan" style="background-color: white;">
                    <a href="wish_list.php"><span class="glyphicon glyphicon-gift" style="color: #10C469;"></span></a>
                  </span>
                </div>
              </div>
          </div>
        </div>
      </div>-->

      <div class="col-md-6 col-sm-6">
        <div class="widget p-md clearfix" style="background: #white;">
          <div class="pull-left">
            <form action="search_bgg.php" method="post" id="searchBGGForm">
              <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                <div class='input-group'>
                  <input type="text" name="search-string" class="form-control bggSearch" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="BoardGameGeek" style="background: white;">
                  <span class="input-group-addon text-white bggSpan bggSpan1" style="background-color: white;">
                    <a href="#" onclick="document.getElementById('searchBGGForm').submit();"><span class="glyphicon glyphicon-search"></span></a>
                  </span>
                  <span class="input-group-addon text-white bggSpan" style="background-color: white;">
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
        <a href="wish_list.php"><div class="widget stats-widget feature">
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
        <a href="library.php?search=Rules"><div class="widget stats-widget feature">
          <div class="widget-body clearfix">
            <div class="pull-left">
              <h3 class="widget-title text-success"><?php echo $needRulesGames; ?></h3>
              <small class="text-color">Need Rules</small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-list-ul"></i></span>
          </div>
          <footer class="widget-footer bg-success">
          </footer>
        </div></a><!-- .widget -->
      </div>

      

      <div class="col-md-3 col-sm-6">
        <a href="library.php?search=Refresher"><div class="widget stats-widget feature">
          <div class="widget-body clearfix">
            <div class="pull-left">
              <h3 class="widget-title text-warning"><?php echo $needRefresherGames; ?></h3>
              <small class="text-color">Need Refresher</small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-exclamation-circle"></i></span>
          </div>
          <footer class="widget-footer bg-warning">
          </footer>
        </div></a><!-- .widget -->
      </div>

      <div class="col-md-3 col-sm-6">
        <a href="library.php?search=<?php echo $customSearchString; ?>"><div class="widget stats-widget feature">
          <div class="widget-body clearfix">
            <div class="pull-left">
              <h3 class="widget-title text-danger"><?php echo $customFilterGames; ?></h3>
              <small class="text-color">Custom: <?php echo $customSearchString; ?></small>
            </div>
            <span class="pull-right big-icon watermark"><i class="fa fa-bullseye"></i></span>
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
            <h4 class="widget-title">Recently Played</h4>
          </header>
          <hr class="widget-separator"/>
          <div class="widget-body">
            <div class="table-responsive">              
              <table class="table no-cellborder table-hover">
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
        <div class="widget">
          <header class="widget-header">
            <h4 class="widget-title">Most Played</h4>
          </header>
          <hr class="widget-separator"/>
          <div class="widget-body">
            <div class="table-responsive">              
              <table class="table no-cellborder table-hover">
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
        <div class="widget p-md clearfix">
          <div class="pull-left">
            <h3 class="widget-title">Average Rating</h3>
            <small class="text-color">For rated games</small>
          </div>
          <span class="pull-right fz-lg fw-500"><?php echo number_format((float)$averageRating, 1, '.', ''); ?></span>
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

      <div class="col-md-12 col-sm-12">
        <div class="widget p-md clearfix">
          <div class="pull-left">
            <h3 class="widget-title pull-left">Following</h3>
            <span class="pull-right fz-lg fw-500"><a href="social.php"><button class="btn btn-xs btn-info pull-right">Search Users</button></a></span>
            <br><br>
            <hr class="widget-separator"/>
            
            <div class="table-responsive" style="padding-top: 10px;">              
              <table class="table no-cellborder table-hover">
                <?php
              $query = " 
                  SELECT * FROM following 
                  WHERE 
                      follower = :follower
                      
              "; 
               
              $query_params = array( 
                  ':follower' => $_SESSION['userid']
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
                  echo '<tr class="clickable-row" data-href="user_details.php?username='.$x['following_username'].'"><td style="padding-left:10px; color: #188AE2;">'.$x['following_username'].'</td></tr>';
                }
              }
              else {
                  echo '<tr class="clickable-row" data-href="social.php"><td style="padding-left:10px;"">You are not following any GameApp users.<br><br><a href="social.php">Follow users</a> to quickly see their Rules, Wishlists, and Top Rated games!</td></tr>';
              }
              ?>
              </table>
          </div>
          
        </div><!-- .widget -->
      </div>
    </div>


      

    </div>

    

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
  jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
  </script>
  <script>
  $(document).ready(function() {
    var gameCount = '<?php echo $gameCount ?>';
    if(gameCount == 0) {
        $('#notification').css('display', 'block').hide().fadeIn('slow'); 
    }
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
      $("#searchopen").click(function(){
        $("#livesearch").show();
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