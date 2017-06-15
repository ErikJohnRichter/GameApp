<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="Admin, Dashboard, Bootstrap" />
	<link rel="shortcut icon" sizes="196x196" href="assets/images/logo.png">
  <link rel="apple-touch-icon" href="assets/images/GameAppLogo2.png" />
  <!--<link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="images/apple-touch-startup-image-640x1096.png">
  <link href="images/apple-touch-startup-image-640x1096.png" media="(device-width: 375px) and (device-height: 667px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">-->
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
  <script src="libs/bower/jquery/dist/jquery.js"></script>
  <script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
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

    <a href="secure.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        <li class="hidden-float hidden-menubar-top">
          <a href="javascript:void(0)" role="button" id="menubar-fold-btn" class="hamburger hamburger--arrowalt is-active js-hamburger">
            <span class="hamburger-box"><span class="hamburger-inner"></span></span>
          </a>
        </li>
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float">Dashboard</h5>
        </li>
      </ul>

      <ul class="nav navbar-toolbar navbar-toolbar-right navbar-right">

        <li class="dropdown">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-hc-lg zmdi-settings"></i></a>
          <ul class="dropdown-menu">
            <li><a href="logout.php"><i class="zmdi m-r-md zmdi-hc-lg zmdi-sign-in"></i>Logout</a></li>
          </ul>
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
          <a href="javascript:void(0)"><img class="img-responsive" src="assets/images/Erik.jpg" alt="avatar"/></a>
        </div><!-- .avatar -->
      </div>
      <div class="media-body">
        <div class="foldable">
          <h5><a href="javascript:void(0)" class="username">Erik Richter</a></h5>
          <ul>
            <li class="dropdown">
              <a href="javascript:void(0)" class="dropdown-toggle usertitle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <small>Options</small>
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="text-color" href="secure.php">
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
            <li><a href="secure.php"><span class="menu-text">Game Library</span></a></li>
            <li><a href="gallery-view.php"><span class="menu-text">Gallery View</span></a></li>
            <li><a href="wish_list.php"><span class="menu-text">Wish List</span></a></li>
          </ul>
        </li>

        <li class="menu-separator"><hr></li>

        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon zmdi zmdi-settings zmdi-hc-lg"></i>
            <span class="menu-text">Settings</span>
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

    <div class="row" id="gameList">
      <div class="col-md-12">
        <div class="widget row no-gutter p-lg"> 
        <header class="widget-header game-list">
            <h3 class="widget-title text-center">Game Library</h3>
          </header>         
          <!-- Ajax dataTable -->
          <div class="widget-body" style="padding-top: 0px;">
            <table id="responsive-datatable" data-plugin="DataTable" data-options="{
                  ajax: 'server_processing.php',
                  responsive: true,
                  keys: true,
                  bLengthChange: false,
                  iDisplayLength: 20,
                  pagingType: 'numbers',
                  columnDefs: [{ 'orderable': false, 'targets': 7 }, { 'width': '20%', 'targets': 6 }]
                }" class="table" cellspacing="0" width="100%">
              <thead>
                <tr><th>Name</th><th>Knowledge</th><th>Rating</th><th>Type</th><th>Players</th><th>Cost</th><th>Notes</th><th>&nbsp;</th></tr>
              </thead>
              <tfoot>
                <tr><th>Name</th><th>Knowledge</th><th>Rating</th><th>Type</th><th>Players</th><th>Cost</th><th>Notes</th><th>&nbsp;</th></tr>
              </tfoot>
            </table>
          </div><!-- .widget-body -->
        </div><!-- .widget -->  
      </div>
    </div><!-- .row -->

    <div class="row">
      <div class="col-md-2">
          <div class="m-b-lg">
            <a href="#" type="button" data-toggle="modal" data-target="#contactModal" class="btn action-panel-btn btn-default btn-block">Add Game</a>
          </div>
          <div class="m-h-md">
          </div>
      </div><!-- END column -->
    </div><!-- .row -->

	</section><!-- #dash-content -->
</div><!-- .wrap -->

<!-- new contact Modal -->
<div id="contactModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Game</h4>
      </div>
      <form action="#" id="newGameForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" name="name" id="gameName" class="form-control" placeholder="Name">
          </div>
          <div class="form-group">
            <select class="form-control" name="knowledge" id="gameplayKnowledge">
                <option selected disabled>Knowledge</option>
                <option value="Great">Great</option>
                <option value="OK">OK</option>
                <option value="Need Refresher">Need Refresher</option>
                <option value="Need to Learn">Need to Learn</option>
              </select>
          </div>
          <div class="form-group">
            <select class="form-control" name="rating" id="gameRating">
                <option selected disabled>Rating</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="">None</option>
              </select>
          </div>
          <div class="form-group">
            <select class="form-control" name="type" id="gameType">
                <option selected disabled>Type</option>
                <option value="Abstract Strategy">Abstract Strategy</option>
                <option value="Worker Placement">Worker Placement</option>
                <option value="Crossover">Crossover</option>
                <option value="Territory Building">Territory Building</option>
                <option value="Deck Building">Deck Building</option>
                <option value="Tile Laying">Tile Laying</option>
                <option value="Cooperative">Cooperative</option>
                <option value="Card Drafting">Card Drafting</option>
                <option value="Area Control">Area Control</option>
                <option value="Filler">Filler</option>
                <option value="Expansion">Expansion</option>
                <option value="Party">Party</option>
                <option value="Card Game">Card Game</option>
                <option value="Needs a Category">Needs a Category</option>
              </select>
          </div>
          <div class="form-group">
            <select class="form-control" name="minPlayers" id="gameMinPlayers" style="display: inline-block; width: 49%;">
                <option selected disabled>Min Players</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
              <select class="form-control" name="maxPlayers" id="gameMaxPlayers" style="display: inline-block; width: 49%; float: right;">
                <option selected disabled>Max Players</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
          </div>
          <div class="form-group">
            <input type="text" name="cost" id="gameCost" class="form-control" placeholder="Cost">
          </div>
          <!--<div class="form-group">
            <input type="file" class="form-control" name="picture" id="gamePicture" placeholder="Picture">
          </div>
          <div class="form-group">
            <div class='input-group date' id='datetimepicker4' data-plugin="datetimepicker" data-options="{ viewMode: 'years', format: 'MM/YYYY' }">
                    <input type='text' name="purchaseDate" class="form-control" placeholder="Purchase Date"/>
                    <span class="input-group-addon bg-info text-white">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
          </div>-->
          <div class="form-group">
            <textarea type="text" rows="4" name="notes" id="gameNotes" class="form-control" placeholder="Notes"></textarea>
          </div>
        </div><!-- .modal-body -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="submit" id="addGame" class="btn btn-success" data-dismiss="modal">Add</button>
        </div><!-- .modal-footer -->
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  <!-- APP FOOTER -->
  <div class="wrap p-t-0">
    <footer class="app-footer">
      <div class="clearfix">
        <ul class="footer-menu pull-right">
          <li><a href="javascript:void(0)">Privacy Policy</a></li>
          <li><a href="javascript:void(0)">Feedback <i class="fa fa-angle-up m-l-md"></i></a></li>
        </ul>
        <div class="copyright pull-left">&copy; CodingErik 2017</div>
      </div>
    </footer>
  </div>
  <!-- /#app-footer -->
</main>
<!--========== END app main -->
  
  <script>
  $("#addGame").click(function(){
    $.ajax({
      type: "POST",
      url: "add_game.php",
      data: $('#newGameForm').serialize(),
      cache: false,
      
    });
    $('#contactModal').modal('hide');
    return false;
  });

  $("#addGame").click(function(){
  location.reload();
  });
  </script>
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
</body>
</html>