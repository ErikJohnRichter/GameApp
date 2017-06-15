<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

    $username = $_GET['username'];        
    
    $query = " 
        select id, username, first, last, picture, (levenshtein_ratio(username, '$username')) as rank
        FROM gameapp_codingerik.users
        WHERE levenshtein_ratio(username, '$username') > 20 and username IS NOT null

        UNION

        select id, username, first, last, picture, (levenshtein_ratio(first, '$username')) as rank
        FROM gameapp_codingerik.users
        WHERE levenshtein_ratio(first, '$username') > 30 and first IS NOT null

        UNION

        select id, username, first, last, picture, (levenshtein_ratio(last, '$username')) as rank
        FROM gameapp_codingerik.users
        WHERE levenshtein_ratio(last, '$username') > 30 and last IS NOT null

        order by rank desc
            
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

    <a href="social.php" class="navbar-brand">
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
    <?php echo '<a href="social.php" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px; padding-top: 20px;"></i></a>'; ?>
    <div class="row text-center">
      <div class="col-md-4 col-md-offset-4">
        <?php
        if ($_GET['username'] == "") {
          echo '<h3 class="profile-info-name" style="font-size: 30px; margin-top: 15px; margin-bottom: 30px;">Please enter a username</h3>';
        }
        else {
          echo '<h3 class="profile-info-name" style="font-size: 30px; margin-top: 15px; margin-bottom: 30px;">Top results for<br>"'.$username.'"</h3>';
        }
        ?>
        
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="widget p-md clearfix">
      <table class="table table-hover">
      <?php
      if ($_GET['username'] != "") {
        $userIds = array();

        if($rows) {
          $i=0;
          foreach($rows as $x)
          { 
            if (!in_array($x['id'], $userIds)) {
              array_push($userIds, $x['id']);
              if ($i == 0) {
                echo '<tr class="clickable-row" data-href="user_details.php?username='.$x['username'].'&list=search">';
                if ($x['first'] != "" && $x['last'] != "") {
                echo '<td style="width:90px; border-top:0px solid white;"><img src="assets/images/'.$x['picture'].'" style="max-height:90px;max-width:50px;"></td><td style="border-top:0px solid white;">'.ucfirst($x['username']).'&nbsp;&nbsp;<small>('.ucfirst($x['first']).' '.ucfirst($x['last']).')</small></td>';
                }
                elseif ($x['first'] != "") {
                echo '<td style="width:90px; border-top:0px solid white;"><img src="assets/images/'.$x['picture'].'" style="max-height:90px;max-width:50px;"></td><td style="border-top:0px solid white;">'.ucfirst($x['username']).'&nbsp;&nbsp;<small>('.ucfirst($x['first']).')</small></td>';
                }
                else {
                echo '<td style="width:90px; border-top:0px solid white;"><img src="assets/images/'.$x['picture'].'" style="max-height:90px;max-width:50px;"></td><td style="border-top:0px solid white;">'.ucfirst($x['username']).'</td>';
                }
                echo '</tr>';
                $i++;
              }
              else {
                echo '<tr class="clickable-row" data-href="user_details.php?username='.$x['username'].'&list=search">';
                if ($x['first'] != "" && $x['last'] != "") {
                echo '<td style="width:90px;"><img src="assets/images/'.$x['picture'].'" style="max-height:90px;max-width:50px;"></td><td>'.ucfirst($x['username']).'&nbsp;&nbsp;<small>('.ucfirst($x['first']).' '.ucfirst($x['last']).')</small></td>';
                }
                elseif ($x['first'] != "") {
                echo '<td style="width:90px;"><img src="assets/images/'.$x['picture'].'" style="max-height:90px;max-width:50px;"></td><td>'.ucfirst($x['username']).'&nbsp;&nbsp;<small>('.ucfirst($x['first']).')</small></td>';
                }
                else {
                echo '<td style="width:90px;"><img src="assets/images/'.$x['picture'].'" style="max-height:90px;max-width:50px;"></td><td>'.ucfirst($x['username']).'</td>';
                }
                echo '</tr>';
                $i++;
              }
            }
          }
        }
        else {
          echo '<tr><td colspan="2"><br><b>No results similar to "'.$username.'"</b></td></tr>';
        }
      }
      else {
        echo '<tr><td colspan="2"><br><b>No results</b></td></tr>';
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