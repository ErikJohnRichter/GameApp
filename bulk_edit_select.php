<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 
$search = $_GET['search'];

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

    <form action="bulk_edit.php" id="bulkEditSelectForm" method="post" enctype="multipart/form-data">
    <div class="row" id="gameList">
      <div class="col-md-12">
        <div class="widget row no-gutter lib" id="libraryTable"> 
        <header class="widget-header game-list">
            <h3 class="widget-title text-center" style="display:inline-block;">Select Games</h3>
            <button type="submit" id="submitButton" class="btn btn-xs btn-success pull-right" style="margin-left: 10px;display:inline-block;">Edit Selected</button>
          </header>         
          <!-- Ajax dataTable -->
          <!--Place in image for bad images (this may slow things down) onerror=&quot;this.src=\'./images/noimage.jpg\'&quot;-->
          <!--Saved state code => stateSave: true, stateDuration: 6, -->
         

          <div class="widget-body" id="libraryBody" style="padding-top: 0px;">
            <table id="library" data-plugin="DataTable" data-options="{
                  ajax: 'get_bulk_edit.php',
                  responsive: true,
                  keys: true,
                  bLengthChange: false,
                  selected: true,
                  iDisplayLength: 10,
                  pagingType: 'numbers',
                  columnDefs: [{ 'orderable': false, 'targets': 1, 'render': function(data, type, row) {return '<img src=&quot;images/'+data+'.jpg&quot; onerror=&quot;this.src=\'./images/noimage.jpg\'&quot; style=&quot;max-height:100px;max-width:50px;&quot;/>';}},
                  { 'visible': false, 'targets': 0 },
                  { 'width': '8%', 'targets': 6 },
                  { 'width': '8%', 'targets': 7 }],
                  order: [[ 2, 'asc' ]],
                  oSearch: {'sSearch': '<?php echo $search; ?>'},
                  
                  initComplete: function( settings, json ) { $('#libraryBody').fadeIn(200);}
                }" class="table" cellspacing="0" width="100%">
              <thead>
                <tr><th>&nbsp;</th><th class="all">&nbsp;</th><th class="all">Name</th><th class="not-mobile">Status</th><th class="not-mobile">Rating</th><th class="not-mobile">Players</th><th class="not-mobile">Type 1</th><th class="desktop">Type 2</th><th class="desktop">Play With</th><th class="desktop">BGG</th><th class="desktop">Time</th><th class="desktop">Weight</th></tr>
              </thead>
              <tfoot>
                <tr><th>&nbsp;</th><th>&nbsp;</th><th>Name</th><th>Status</th><th>Rating</th><th>Players</th><th>Type</th><th>Type 2</th><th>Play With</th><th>BGG</th><th>Time</th><th>Weight</th></tr>
              </tfoot>
            </table>
          </div><!-- .widget-body -->
        </div><!-- .widget -->  
      </div>
    </div><!-- .row -->
    </form>
    <div class="row" style="margin-bottom: 20px; margin-right: 10px;">
          <div class="m-b-lg">
            <a href="library.php"><button id="goBack" class="btn btn-danger pull-right">Cancel</button></a>
          </div>
          <div class="m-h-md">
          </div>
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

  $('#library').on('click', 'tbody tr', function() {
      var table = $('#library').DataTable();
       var id = table.row( this ).data()[0];
       $(this).toggleClass('selected');

       $('#submitButton').click( function () {
        $('<input />').attr('type', 'hidden')
          .attr('name', "game[]")
          .attr('value', id)
          .appendTo('#bulkEditSelectForm');
      return true;
    });
  });

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