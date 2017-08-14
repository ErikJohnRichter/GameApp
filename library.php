<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 
$search = $_GET['search'];

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

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
	<section class="app-content">

    <div class="row" id="notification" style="display:none;">
      <div class="col-md-12 col-sm-12">
          <div class="alert alert-success">
            <h3 class="widget-title">Welcome to your Game Library!</h3>
            <p>This is a list of all the games you add in GameApp. To see a game's details, click on it to get to its details page.</p>
            <p style="padding-top:5px;">On a game's details page, you can add/view quick rules, log gameplays, rate it, and see other fun stats!</p>
            <p style="padding-top:5px;">Don't stop here! Keep on adding games to your Library and Wishlist! Remember, to make this easier, you can always search BoardGameGeek on your Stats Dash or import your BGG collection in <a href="settings.php">Settings</a>.</p>
            <p style="padding-top:5px;">Additionally, if you would like, all games on this list can be made public to share with other users. Visit <a href="settings.php">Settings</a> for more details.</p>
            <p style="padding-top:5px;">If you need additional help, feel free to read the FAQs in the Help section.</p>
          </div>
      </div>
    </div><!-- .row -->

    <div class="row" id="gameList">
      <div class="col-md-12">
        <div class="widget row no-gutter lib" id="libraryTable"> 
        <header class="widget-header game-list">
            <h3 class="widget-title text-center">Game Library</h3>
          </header>         
          <!-- Ajax dataTable -->
          <!--Place in image for bad images (this may slow things down) onerror=&quot;this.src=\'./images/noimage.jpg\'&quot;-->
          <!--Saved state code => stateSave: true, stateDuration: 6, -->
          <?php 
          //Hook this up to "Save State" "Remove State" buttons at bottom of library with the ability to add seconds. Save as session variable.
          if ($_SESSION['savestate'] == 1) {
            $saveState = 'stateSave: true, stateDuration: 30,';
          }
          else {
            $saveState = '';
          }

          ?>

          <div class="widget-body" id="libraryBody" style="padding-top: 0px;">
            <table id="library" data-plugin="DataTable" data-options="{
                  ajax: 'get_games.php',
                  responsive: true,
                  <?php echo $saveState; ?>
                  keys: true,
                  bLengthChange: false,
                  iDisplayLength: 10,
                  pagingType: 'numbers',
                  columnDefs: [{ 'orderable': false, 'targets': 0, 'render': function(data, type, row) {return '<img src=&quot;images/'+data+'.jpg&quot; onerror=&quot;this.src=\'./images/noimage.jpg\'&quot; style=&quot;max-height:100px;max-width:50px;&quot;/>';}},
                  { 'width': '16%', 'targets': 10 },
                  { 'visible': false, 'targets': 1 },
                  { 'width': '8%', 'targets': 6 },
                  { 'width': '8%', 'targets': 7 }],
                  order: [[ 2, 'asc' ]],
                  oSearch: {'sSearch': '<?php echo $search; ?>'},
                  
                  initComplete: function( settings, json ) { $('#libraryBody').fadeIn(200);}
                }" class="table" cellspacing="0" width="100%">
              <thead>
                <tr><th class="all">&nbsp;</th><th>&nbsp;</th><th class="all">Name</th><th class="not-mobile">Status</th><th class="not-mobile">Rating</th><th class="not-mobile">Players</th><th class="not-mobile">Type 1</th><th class="desktop">Type 2</th><th class="desktop">Play With</th><th class="desktop">BGG</th><th class="desktop">Notes</th><th class="desktop">Time</th><th class="desktop">Weight</th></tr>
              </thead>
              <tfoot>
                <tr><th>&nbsp;</th><th>&nbsp;</th><th>Name</th><th>Status</th><th>Rating</th><th>Players</th><th>Type</th><th>Type 2</th><th>Play With</th><th>BGG</th><th>Notes</th><th>Time</th><th>Weight</th></tr>
              </tfoot>
            </table>
          </div><!-- .widget-body -->
        </div><!-- .widget -->  
      </div>
    </div><!-- .row -->

    <div class="row">
      <div class="col-md-2">
          <div class="m-b-lg">
            <a href="advanced_search.php" type="button" class="btn action-panel-btn btn-default btn-block">Advanced Search</a>
          </div>
          <div class="m-h-md">
          </div>
      </div><!-- END column -->
      <div class="col-md-2">
          <div class="m-b-lg">
            <?php
            if ($_SESSION['savestate'] == 1) {
              echo '<a href="save_state_library.php" type="button" class="btn action-panel-btn btn-default btn-block">Unsave State</a>';
            }
            else {
              echo '<a href="save_state_library.php" type="button" class="btn action-panel-btn btn-default btn-block">Save State</a>';
            }
            ?>
          </div>
          <div class="m-h-md">
          </div>
      </div><!-- END column -->
      <div class="col-md-2">
          <div class="m-b-lg">
            <a href="bulk_edit_select.php" type="button" class="btn action-panel-btn btn-default btn-block">Bulk Edit</a>
          </div>
          <div class="m-h-md">
          </div>
      </div><!-- END column -->
      <div class="col-md-2">
          <div class="m-b-lg">
            <a href="create_game.php?list=1" type="button" class="btn action-panel-btn btn-default btn-block">Add Game</a>
          </div>
          <div class="m-h-md">
          </div>
      </div><!-- END column -->
    </div><!-- .row -->

	</section><!-- #dash-content -->
</div><!-- .wrap -->

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
  
  
  <script>
  $(document).ready(function() {
    var gameCount = '<?php echo $gameCount ?>';
    if(gameCount < 2) {
        $('#notification').css('display', 'block').hide().fadeIn('slow'); 
    }
    });
  </script>

  <script>
  $('#library').on('click', 'tbody td', function() {
      var table = $('#library').DataTable();
       var id = table.row( this ).data()[1];
       window.location = "game_details.php?id="+id;
  })
  </script>
  <script>
  function clear_search() {
    var table = $('#library').DataTable();
    table.search('').draw();
  }
  </script>

  <script>
$('#libraryBody').hide();
 
  </script>

  <script>
  $(document).ready(function() {
    $('.livesearch').click(function(){
      $('.input-sm').focus();
  });
    });
  </script>
  
</body>
</html>