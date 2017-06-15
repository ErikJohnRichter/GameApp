<?php
    
    require("common.php"); 
     
    $username = $_GET['user'];    

    $query = " 
        SELECT * FROM users 
        WHERE 
            username = :username
            
    "; 
     
    $query_params = array( 
        ':username' => $username
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
            $userId = $x["id"];
            $userName = $x["username"];
            $userFirst = $x["first"];
            $public = $x["public"];
        }
    } 

    if ($userFirst) {
      $name = ucfirst($userFirst);
    }
    else {
      $name = ucfirst($userName);
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
    <button type="button" id="menubar-toggle-btn" class="navbar-toggle visible-xs-inline-block navbar-toggle-left hamburger hamburger--collapse js-hamburger">
      <span class="sr-only">Toggle navigation</span>
      <span class="hamburger-box"><span class="hamburger-inner"></span></span>
    </button>

    <a href="index.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      

      <ul class="nav navbar-toolbar navbar-toolbar-right navbar-right">

      </ul>
    </div>
  </div><!-- navbar-container -->
</nav>
<!--========== END app navbar -->

<!-- APP ASIDE ==========-->
<aside id="menubar" class="menubar light">
  <div class="menubar-scroll">
    <div class="menubar-scroll-inner">
      <ul class="app-menu">
        <li>
          <a href="welcome.html">
            <i class="menu-icon zmdi zmdi-help-outline zmdi-hc-lg"></i>
            <span class="menu-text">What is this?</span>
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
      <input class="form-control search-field" id="live-search" type="text" size="30" style="font-size: 16px;" onkeyup="showResult(this.value)" placeholder="Search Games" autofocus>
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
    <div class="row text-center">
      <div class="col-md-4 col-md-offset-4" style="margin-bottom: 30px;">
        <h3 class="profile-info-name" style="font-size: 30px; margin-top: 15px; margin-bottom: 10px;"><?php if ($public == 1) { echo $name."'s"; } else { echo "GameApp"; } ?> Wishlist</h3>
      <?php if ($public == 1) { echo '<small>(To get purchasing info, click on the game)</small>'; } ?><br>
      </div>

    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="widget p-md clearfix">
          <table class="table table-hover">
        
          <?php
          if ($public == 1) { 

              $query = " 
                  SELECT * FROM game_details 
                  WHERE 
                      user_id = :userid AND
                      list_type = :listtype AND
                      status = :status
                      
                      
              "; 
               
              $query_params = array( 
                  ':userid' => $userId,
                  ':listtype' => 2,
                  ':status' => "Want"
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
                echo '<thead>';
                  echo '<tr><td>&nbsp;</td><td><b>Game name</b></td><td><b>Cost</b></td></tr>';
                echo '</thead>';
                  // output data of each row
                  foreach ($rows as $x) {
                    $searchName = $x['name'];
                    $searchName = str_replace(' ','%20',$searchName);
                       echo '<tr class="clickable-row" data-href="http://www.boardgameprices.com/compare-prices-for?q='.$searchName.'">';
                        if ($x['bgg_id']) {
                            echo '<td style="width:15%;"><img src="images/'.$x['bgg_id'].'.jpg" style="max-height:100px;max-width:50px;"/></td>';
                          }
                        echo '<td>'.$x['name'].'</td>';
                        if ($x['cost']) {
                          echo '<td>$'.$x['cost'].'</td>';
                        }
                        else {
                          echo '<td>Not listed</td>';
                        }
                        echo '</tr>';
                  }
              } else {
                  echo "<tr><td style='border-top: 0px solid white;'>".$name." does not want any boardgames right now.</td></tr>";
              }
            }
            else {
              echo "<tr><td style='border-top: 0px solid white;'>Sorry, this user's Wishlist is private.</td></tr>";
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
      window.open($(this).data("href"),$(this).data("_blank"));
    });
});
  </script>
</body>
</html>