<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

$gameId = $_POST['id'];
$name = $_POST['name'];
$scoring = $_POST['scoring'];

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

    <a href="library.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float"><?php echo $name; ?> Details</h5>
        </li>
      </ul>

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
<aside id="menubar" class="menubar light">
  <div class="app-user">
    <div class="media">
      <div class="media-left">
        <div class="avatar avatar-md avatar-circle">
          <?php 
          if ($_SESSION['first']) {
            $displayUser = $_SESSION['first'];
          }
          else {
            $displayUser = $_SESSION['username'];
          }
          echo '<a href="javascript:void(0)"><img class="img-responsive" src="assets/images/'.$_SESSION['picture'].'" alt="avatar"/></a>'; ?>
        </div><!-- .avatar -->
      </div>
      <div class="media-body">
        <div class="foldable">
          <h5><a href="javascript:void(0)" class="username">Hey <?php echo ucfirst($displayUser); ?>!</a></h5>
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

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="profile-header">
  <div class="profile-cover" style="padding-top: 30px; padding-bottom: 40px;">
    <?php
      echo '<a href="game_details.php?id='.$_POST['id'].'" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
    ?>
    <div class="text-center">
      <h3 class="profile-info-name m-b-lg" style="font-size: 30px; margin-top: 5px;">Add gameplay for<br><?php echo $name; ?></h3>
      <div>
        <span class="theme-color"></span>
      </div>
    </div>
  </div><!-- .profile-cover -->

  <div class="promo-footer">
    <div class="row no-gutter">
      
    </div>
  </div><!-- .promo-footer -->
</div><!-- .profile-header -->

<div class="wrap" style="padding-top: 0px;">
  <section class="app-content">
     
      
      <div class="col-md-12 promo-tab">
        <div class="col-md-6 col-md-offset-3 text-center">
         <form onsubmit="return validateAddGameForm()" action="add_gameplay.php" method="post" enctype="multipart/form-data">
            <div style="border-top: 0px solid white;">
              <div class="form-group">
                <div class="input-group date" id='date' data-plugin="datetimepicker">
                  <input type='text' id="gamePlayDate" name="playDate" class="form-control" placeholder="Date  (if today, leave blank)"/>
                  <span class="input-group-addon bg-info text-white">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
              <div class="form-group">
                  <input type="text" name="location" id="playLocation" class="form-control" placeholder="Location">
              </div>
              <div class="form-group">
                <select class="form-control" name="players" id="totalPlayers">
                  <option selected disabled>Total Players</option>
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
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                </select>
              </div>
              <div class="form-group">
                <select name="winner" id="playWinner" class="form-control validateGame">
                      <option selected disabled>Winner</option>
                      
                    
                <?php
                  if ($scoring != 'coop') {
                    $query = " 
                      SELECT * FROM players 
                      WHERE 
                          user_id = :userid
                          ORDER BY player asc
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
                      $extraPlayers = "";
                      if ($rows) {
                          foreach ($rows as $x) {
                            $extraPlayers = $extraPlayers.'<option value="'.$x['player'].'">'.$x['player'].'</option>';
                          }
                      }
                      else {
                        $extraPlayers = '<option disabled>Add players in Profile</option>';
                      }
                  }
                  else {
                    $extraPlayers = '<option value="Game">Game</option><option value="Players">Players</option>';
                  }
                  echo $extraPlayers;
                ?>
                </select>
              </div>
              <?php
                  if ($scoring != 'coop' && $scoring != 'other' && $scoring != 'set') { ?>
              <div class="form-group">
                  <input type="text" name="winning-score" id="playWinningScore" class="form-control" placeholder="Winning score">
              </div>
              
              <div id="extraPlayers"></div>
              <script>
                $("#totalPlayers").on("change", function () {
                  var number = parseInt($("#totalPlayers").val());
                  
                  var html = '';
                  $("#extraPlayers").html('');
                  var player = 1;

                  for (i = 1; i < number; i++) {
                     player++;
                    var players = <?php echo json_encode($extraPlayers); ?>;
                    var extraPlayerList = '<div class="form-group"><select name="player-'+player+'" class="form-control"><option selected disabled>Player '+player+'</option>'+players+'</select></div>';
                    var extraPlayerScore = '<div class="form-group"><input type="text" name="player-'+player+'-score" class="form-control" placeholder="Player '+player+' score"></div>';
                      html += extraPlayerList+extraPlayerScore;
                     
                  };
                  console.log(player);

                  $("#extraPlayers").html(html);
              });
                </script>
                <?php } ?>
              <div class="form-group">
                  <input type="text" name="play-time" id="playTime" class="form-control" placeholder="Time played (mins)">
              </div>
              <div class="form-group">
                <textarea type="text" rows="4" name="notes" id="playNotes" class="form-control" placeholder="Gameplay notes"></textarea>
              </div>
              <?php echo '<input type="hidden" name="id" value="'.$gameId.'">';
              echo '<input type="hidden" name="name" value="'.$name.'">'; ?>
              <button id="logGame" type="submit" class="btn btn-info" style="width: 200px;">Log Gameplay</button>
            </div>
          </form>
        </div>
      </div>

    
    
  </section><!-- #dash-content -->
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
      function validateAddGameForm() {
        var isValid = true;
        $('.validateGame').each(function() {
          if ( $(this).val() === null || $(this).val() === '' ) {
              $(this).addClass('inputError');

              isValid = false;
          }
          else if ($(this).val() != null || $(this).val() != '') {
              $(this).removeClass('inputError');
              
          }
        });
        if (isValid == false) {
          alert("Whoa, whoa, whoa! Looks like you're missing a winner!")
        }
        else {
          $('#logGame').prop("disabled",true);
          $('#logGame').val('Adding...');
        }
        return isValid;
      }
  </script>
  
  
</body>
</html>