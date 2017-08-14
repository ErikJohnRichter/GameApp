<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

   $bggGameId = $_GET['id'];     
   $bggGameName = $_GET['name'];          
    
    $xmlurl1 = 'https://boardgamegeek.com/xmlapi2/forumlist?type=thing&id='.$bggGameId.'';
    $sxml1 = simplexml_load_file($xmlurl1);
    
    foreach($sxml1->forum as $forum)
        {
          if ($forum->attributes()->title == "Reviews") {
            $forumId = $forum->attributes()->id;
          }
        }

    $xmlurl = 'https://boardgamegeek.com/xmlapi2/forum?id='.$forumId.'&page=1';
    $sxml = simplexml_load_file($xmlurl);

            
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
  
	<script>
		Breakpoints();
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
    <?php
    if ($_GET['list'] == "mygames") {
        echo '<a href="game_details.php?id='.$_GET['gameid'].'" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px; padding-top: 20px;"></i></a>';
    }
    else {
      echo '<a href="bgg_game_details.php?id='.$bggGameId.'&list='.$_GET['list'].'&string='.$bggGameName.'" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px; padding-top: 20px;"></i></a>';
    }
    ?>
    <div class="row text-center">
      <div class="col-md-4 col-md-offset-4 col-xs-12">
        <h3 class="profile-info-name" style="font-size: 30px; margin-top: 15px; margin-bottom: 30px;">Reviews for<br><?php echo $bggGameName; ?></h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4 col-xs-12">
        <div class="widget p-md clearfix" >
      <table class="table table-hover">
        <thead>
          <tr><td><b>Reviews</b></td><td><b>Date</b></td></tr>
        </thead>
      <?php
      if ($sxml->threads->thread) {
        $i = 0;
        foreach($sxml->threads->thread as $thread)
        {
          $reviewName = $thread->attributes()->subject;
          $reviewId = $thread->attributes()->id;
          $reviewDate = $thread->attributes()->postdate;
          $date = date_create($reviewDate);
          $date = date_format($date, 'm/Y');
          
          if ($i == 20) {
            break;
          }
          if ($reviewName != "N/A") {
            echo '<tr class="clickable-row" data-href="game_review_details.php?id='.$reviewId.'&bgggameid='.$bggGameId.'&name='.$bggGameName.'&list='.$_GET['list'].'&gameid='.$_GET['gameid'].'">';
            echo '<td>'.$reviewName.'</td>';
            echo '<td style="width:30%">'.$date.'</td>';
            echo '</tr>';
            $i++;
          }
        }
      }
      else {
        echo '<tr>';
            echo '<td>None</td>';
             echo '<td>&nbsp;</td>';
            echo '</tr>';
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
</body>
</html>