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
          <h5 class="page-title hidden-menubar-top hidden-float">User Profile</h5>
        </li>
      </ul>

      <ul class="nav navbar-toolbar navbar-toolbar-right navbar-right">

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
      <!--<h3 class="text-center" style="padding-bottom:20px;">User Profile</h3>-->


<div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">Search for Users</h3>
    <div class="form-group" id="changeAdminCredentials">
    <form action="search_users.php" method="get" id="searchUsersForm">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            
                <div class='input-group' style="margin: 0 auto; width: 250px;">
                  <input type="text" name="username" class="form-control simple-input" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Username or Name">
                  <span class="input-group-addon text-white bggSpan bggSpan1" style="background-color: white;">
                    <a href="#" onclick="document.getElementById('searchUsersForm').submit();"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </span>
                </div>
             
            
        </tr>
    </tbody>
    </table>
    </form>
  </div>
  </div>
  <script>
  $('#findFriend').attr('disabled', true);
$('#friendUsername').keyup(function () {
   var disable = false;
       $('#friendUsername').each(function(){
            if($(this).val().length < 2){
                 disable = true;      
            }
       });
  $('#findFriend').prop('disabled', disable);
});
</script>
</div>   


<div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">Following</h3>
    <hr>
    <div class="form-group" id="followingUsers">
      <div class="col-md-12">
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
        echo '<tr class="text-center"><td>You are not following any GameApp users.<br><br>Follow users to quickly see their Rules, Wishlists, and Top Rated games!</td></tr>';
    }
    ?>
  </table>
</div>
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
  jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
  </script>
  <script>
  $(document).ready(
    function(){
    $('#fileSelect').change(
        function(){
            if ($(this).val()) {
                $('#addPhoto').attr('disabled',false);
                // or, as has been pointed out elsewhere:
                // $('input:submit').removeAttr('disabled'); 
            } 
        }
        );
    });
  </script>
 
  <script>
  function clear_search() {
    var table = $('#library').DataTable();
    table.search('').draw();
  }
  </script>
  
</body>
</html>