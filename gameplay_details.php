<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

$gameplayId = $_GET['gameplayId'];
$gameId = $_GET['id'];
$name = $_GET['name'];

$query = " 
        SELECT * FROM game_details 
        WHERE 
            id = :id
            AND user_id = :userid
    "; 
     
    $query_params = array( 
        ':id' => $gameId,
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
     if ($rows) {
      foreach ($rows as $x) {
        $sort = $x['highscore'];
      }
    }


  if ($sort != 'other' && $sort != 'coop' && $sort != 'set') { 
    if ($sort == null) {
      $sort = "desc";
      $highscore = "(highest)";
    }
    elseif ($sort == 'desc') {
      $highscore = "(highest)";
    }
    elseif ($sort == 'asc') {
      $highscore = "(lowest)";
    }
    elseif ($sort == 'money') {
      $sort = 'desc';
      $highscore = "(currency)";
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

    <a href="library.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float"><?php echo $name; ?> Gameplay Details</h5>
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

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="profile-header">
  <div class="profile-cover" style="padding-top: 30px; padding-bottom: 40px;">
    <?php
      echo '<a href="gameplay_log.php?id='.$gameId.'&name='.$name.'" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
    ?>
    <div class="text-center">
      <h3 class="profile-info-name m-b-lg" style="font-size: 30px; margin-top: 5px;"><?php echo $name; ?><br>Gameplay</h3>
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

<div class="wrap" style="padding-top: 20px;">
  <section class="app-content">
     
   
  <div class="row">
    <div class="col-md-6 col-md-offset-3 p-md">
      <div class="widget p-md clearfix">
        <div class="col-md-12 p-md">

           <?php
           $query = " 
              SELECT * FROM gameplay 
              WHERE 
                  id = :id
                  AND user_id = :userid
          "; 
           
          $query_params = array( 
              ':id' => $gameplayId,
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
           if ($rows) {
              foreach ($rows as $x) {
                $notes = $x['notes'];
                $lastplayed = strtotime($x['timestamp']);
                echo '<div class="row text-center">';
                echo '<h3 style="margin-top:0px;">'.date('l, F d, Y', $lastplayed).'</h3>';
                if ($x['location']) { echo '<h3 style="margin-top:0px;">at '.$x['location'].'</h3>'; }
                echo '</div>';
                echo '<div class="col-md-6 col-md-offset-3">';
                echo '<table class="table no-cellborder" style="width:100%">';
                echo '<tr><th width="70%"><hr></th><th width="30%"><hr></th></tr>';
                if ($x['players']) { echo '<tr><td width="70%"><b>Players:</b></td><td width="30%">'.$x['players'].'</td></tr>'; }
                if ($x['play_time']) { echo '<tr><td><b>Play time:</b></td><td>'.$x['play_time'].' mins</td></tr>'; }
                if ($x['winner']) { echo '<tr><td><b>Winner:</b></td><td>'.$x['winner'].'</td></tr>'; }
                if ($x['winning_score']) { echo '<tr><td><b>Winning score:</b></td><td>'.($x['winning_score'] + 0).'</td></tr>'; }
                
              }
          }
          if ($sort != 'other' && $sort != 'coop' && $sort != 'set') {
            $query = " 
                SELECT * FROM gameplay 
                WHERE 
                    associated_gameplay = :id
                    AND user_id = :userid
                    ORDER BY extra_players_score $sort
            "; 
             
            $query_params = array( 
                ':id' => $gameplayId,
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
        }
          else {
            $query = " 
                SELECT * FROM gameplay 
                WHERE 
                    associated_gameplay = :id
                    AND user_id = :userid
                    
            "; 
             
            $query_params = array( 
                ':id' => $gameplayId,
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
          }

          $rows = $stmt->fetchAll();
           if ($rows) {
              if ($sort != 'other' && $sort != 'coop' && $sort != 'set') { 
                echo '<tr><td colspan="2"><hr></td></tr><tr><td colspan="2" style="padding-bottom: 15px;"><b>Other player scores:</b></td></tr>';
                  foreach ($rows as $x) {
                    if ($x['extra_players']) { echo '<tr><td>'.$x['extra_players'].'</td><td>'.($x['extra_players_score'] + 0).'</td></tr>'; }
                  }
                
              }
              else {
                echo '<tr><td colspan="2"><hr></td></tr><tr><td colspan="2" style="padding-bottom: 15px;"><b>Other players:</b></td></tr>';
                  foreach ($rows as $x) {
                    if ($x['extra_players']) { echo '<tr><td>'.$x['extra_players'].'</td></tr>'; }
                  }
                
              }
            }
            if ($notes) { echo '<tr><td colspan="2"><hr></td></tr><tr><td colspan="2">'.$notes.'</td></tr>'; } else { echo '<br>';}
          ?>
          </table>
        </div>
        </div>
      </div>
    </div>
  </div>
    
    
  </section><!-- #dash-content -->
  <br><br>
  <form action="delete_gameplay.php" method="post">
    <div class="modal-footer" style="border-top: 0px solid white;">
      <?php echo '<input type="hidden" name="gameplay-id" value="'.$gameplayId.'">'; ?>
      <?php echo '<input type="hidden" name="game-id" value="'.$gameId.'">'; ?>
      <button id="deleteGame" type="submit" onclick="return confirm('Are you sure you want to delete this gameplay?');" class="btn btn-default">Delete</button>
    </div><!-- .modal-footer -->
  </form>
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
  
</body>
</html>