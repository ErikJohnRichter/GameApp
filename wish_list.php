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
            WHERE user_id = :userid AND list_type=2;
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
      <a href="create_game.php?list=2" style="color: #fff;"><span class="zmdi zmdi-hc-lg zmdi-plus"></span></a>
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
          <a href="create_game.php?list=2">
            <i class="zmdi zmdi-hc-lg zmdi-plus"></i>
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

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
	<section class="app-content">

    <div class="row" id="notification" style="display:none;">
      <div class="col-md-12 col-sm-12">
          <div class="alert alert-success">
            <h3 class="widget-title">Welcome to your Wishlist!</h3>
            <p>Here you can keep track of all the games you want or want to research. You may add games the same ways you add to your Game Library.</p>
            <p style="padding-top:5px;">After purchasing a game on your Wishlist, go to its details page and click "Add to library" to quickly transfer all of its data.</p>
            <p style="padding-top:5px;">Additionally, if you would like, all games on this list with a status of "Want" can be made public to share with your family and friends. Click "Share Wishlist" at the bottom for more details.</p>
          </div>
      </div>
    </div><!-- .row -->

    <div class="row" id="gameList">
      <div class="col-md-12">
        <div class="widget row no-gutter p-lg"> 
        <header class="widget-header game-list">
            <h3 class="widget-title text-center">Wishlist</h3>
          </header>         
          <!-- Ajax dataTable -->
          <!--Place in image for bad images (this may slow things down) onerror=&quot;this.src=\'./images/noimage.jpg\'&quot;-->
          <div class="widget-body" id="wishlistBody" style="padding-top: 0px;">
            <table id="wishlist" data-plugin="DataTable" data-options="{
                  
                  responsive: true,
                  keys: true,
                  bLengthChange: false,
                  iDisplayLength: 10,
                  pagingType: 'numbers',
                  columnDefs: [{ 'orderable': false, responsivePriority: 1, 'targets': 0, 'render': function(data, type, row) {return '<img src=&quot;images/'+data+'.jpg&quot; onerror=&quot;this.src=\'./images/noimage.jpg\'&quot; style=&quot;max-height:100px;max-width:50px;padding-right:0px;margin-right:0px;&quot;/>';}}, { responsivePriority: 2, 'targets': 2 }, { responsivePriority: 3, 'targets': 3 }, { 'width': '20%', 'targets': 8 }, { 'visible': false, 'targets': 1 }],
                  order: [[ 3, 'desc' ]],
                  ajax: 'get_wish_list.php',
                  initComplete: function( settings, json ) { $('#wishlistBody').fadeIn(200);}
                }" class="table" cellspacing="0" width="100%">
              <thead>
                <tr><th class="all">&nbsp;</th><th>&nbsp;</th><th class="all">Name</th><th class="all">Status</th><th>Rating</th><th>Players</th><th>Cost</th><th>Rules</th><th>Notes</th><th>Type</th></tr>
              </thead>
              <tfoot>
                <tr><th>&nbsp;</th><th>&nbsp;</th><th>Name</th><th>Status</th><th>Rating</th><th>Players</th><th>Cost</th><th>Rules</th><th>Notes</th><th>Type</th></tr>
              </tfoot>
            </table>
          </div><!-- .widget-body -->
        </div><!-- .widget -->  
      </div>
    </div><!-- .row -->

    <div class="row">
      <div class="col-md-2">
          <div class="m-b-lg">
            <a href="create_game.php?list=2" type="button" class="btn action-panel-btn btn-default btn-block">Add Game</a>
          </div>
          <div class="m-h-md">
          </div>
      </div><!-- END column -->
      
      <div class="col-md-2">
          <div class="m-b-lg">
             <a href="archive.php" type="button" class="btn action-panel-btn btn-default btn-block">Archive</a>
          </div>
          <div class="m-h-md">
          </div>
      </div><!-- END column -->

      <div class="col-md-2">
          <div class="m-b-lg">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#shareWishlist" aria-expanded="false" type="button" class="btn action-panel-btn btn-default btn-block share-wishlist">Share Wishlist</a>
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
        <div class="copyright pull-right">&copy; CodingErik 2017</div>
      </div>
    </footer>
  </div>
  <!-- /#app-footer -->

  <div id="shareWishlist" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sharing your Wishlist</h4>
        </div>
        <div class="modal-body">
          <p>If you have chosen to make your Wishlist public by turning on the switch in your Account Settings, titles and prices of your Wishlist games with the status of "Want" will be public (all other details and games are private).</p>
          <p>If you would like to share your Wishlist, simply press the following button to copy your Public Wishlist URL and send it to whomever you would like!</p>
          <hr>
          <div class="text-center">
          <p style="display: inline-block;"></p>
          
          <div id="btn" style="display: inline-block;" data-clipboard-text="gameapp.codingerik.com/wishlist.php?user=<?php echo $_SESSION['username'];?>">
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
  <script src="assets/js/clipboard.min.js"></script>

  <script>
  $(document).ready(function() {
    var gameCount = '<?php echo $gameCount ?>';
    if(gameCount == 0) {
        $('#notification').css('display', 'block').hide().fadeIn('slow'); 
    }
    });
  </script>

  <script>
  $('#wishlist').on('click', 'tbody td', function() {
      var table = $('#wishlist').DataTable();
       var id = table.row( this ).data()[1];
       window.location = "game_details.php?id="+id;
  })
  </script>

    <!-- 3. Instantiate clipboard by passing a HTML element -->
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
   
  <script>
    $(document).ready(function(){
      $( "#shareWishlist" ).click(function() {
      $( "#wishlistLink" ).focus();
      });
    });
  </script>

  <script>
  function clear_search() {
    var table = $('#wishlist').DataTable();
    table.search('').draw();
  }
  </script>

  <script>
$('#wishlistBody').hide();
 
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