<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 
          $query = " 
        SELECT * FROM users
        WHERE 
            id = :id
    "; 
     
    $query_params = array( 
        ':id' => $_SESSION['userid']
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
          $userEmail = $x['email'];
          $public = $x['public'];
          $publicLibrary = $x['library_public'];
          $subscription = $x['is_subscribed'];
          $searchFilterString = $x['custom_filter'];
        }
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
  <script src="libs/bower/jquery/dist/jquery.js"></script>
  <script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
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

    <a href="stats.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float">Settings</h5>
        </li>
      </ul>

      <ul class="nav navbar-toolbar navbar-toolbar-right navbar-right">

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
                  <a class="text-color" href="stats.php">
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

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
	<section class="app-content">
    <!--<h3 class="text-center" style="padding-bottom:20px;">User Settings</h3>-->


    <div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix text-center">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px; color: #10C469; font-size: 30px;">Unsubscribed!</h3>
    <div class="form-group">
    <span class="zmdi zmdi-hc-4x zmdi-check-circle" style="color: #10C469"></span>
  </div>
    <div class="form-group">
    <small>You have successfully unsubscribed from all GameApp email communications. If this is an error, or to resubscribe at any time, go to your <a href="settings.php">Settings</a> page and turn on subscriptions again.</small><br><br>
  </div>
  </div>

  
</div>   

<div class="col-md-12 clearfix"> </div>
	</section><!-- #dash-content -->
</div><!-- .wrap -->

  <!-- APP FOOTER -->
  <div class="col-md-12 p-t-0">
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
  function clear_search() {
    var table = $('#library').DataTable();
    table.search('').draw();
  }
  </script>
  
</body>
</html>