<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

$bggGameId = $_GET['id'];
$list = $_GET['list'];
if ($list != "search") {
  $list = "";
}

$xmlurl = 'https://www.boardgamegeek.com/xmlapi/boardgame/'.$bggGameId.'?stats=1';
            $sxml = simplexml_load_file($xmlurl);
            foreach ($sxml->boardgame[0]->name as $primary) {
                if ((string) $primary['primary'] == 'true') {
                    $bggGameName = $primary;
                }
            }
            $bggRating = $sxml->boardgame[0]->statistics->ratings->average;
            $bggDescription = $sxml->boardgame[0]->description;
            $bggMinPlayers = $sxml->boardgame[0]->minplayers;
            $bggMaxPlayers = $sxml->boardgame[0]->maxplayers;
            $bggMinPlayTime = $sxml->boardgame[0]->minplaytime;
            $bggMaxPlayTime = $sxml->boardgame[0]->maxplaytime;
            $bggPlayType = $sxml->boardgame[0]->boardgamesubdomain;
            $bggWeight = $sxml->boardgame[0]->statistics->ratings->averageweight;
            $bggYear = $sxml->boardgame[0]->yearpublished;
            $bggImageThumb = $sxml->boardgame[0]->thumbnail;
            $bggImageUrl = 'https:'.$bggImageThumb;
           
           /*// Create a stream
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            'header'=>"Referer: https://boardgamegeek.com/"
          )
        );

        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $bggImageContent = file_get_contents($bggImageUrl, false, $context);*/


        $bggImageContent = file_get_contents($bggImageThumb);


            file_put_contents('./images/'.$bggGameId.'.jpg', $bggImageContent);

            if ($bggMaxPlayTime != 0) {
                $bggPlayTime = round((($bggMinPlayTime + $bggMaxPlayTime)/2));
            }
            else {
                $bggPlayTime = $bggMinPlayTime;
            }

            $playerDifference = $bggMinPlayers - $bggMaxPlayers;

            if ($playerDifference == 0) {
                $players = $bggMinPlayers;
            }
            else {
                $players = $bggMinPlayers."-".$bggMaxPlayers;
            }
            if ($bggYear) {
              $year = '&nbsp;('.$bggYear.')';
            }
            else {
              $year = "";
            }

            $url = 'https://boardgamegeek.com/boardgame/'.$bggGameId;

if($_GET['string']) {
  $urlName = $_GET['string'];
}
else {
  $urlName = $bggGameName;
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

    <a href="stats.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float"><?php echo $bggGameName; ?> Details</h5>
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
    if ($list == "search") {
      echo '<form action="search_bgg.php" method="post" id="searchBGGForm">';
      echo '<input type="hidden" name="search-string" value="'.$urlName.'">';
      echo '<a href="" style="color: silver;" onclick="parentNode.submit();return false;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
      echo '</form>';
    }
    else {
      echo '<a href="bgg_hotlist.php" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
    }

    ?>
    <div class="text-center">
      <?php if ($bggImageContent) {echo '<a href="'.$url.'" target="_blank" style="color: #188ae2"><img src="./images/'.$bggGameId.'.jpg" style="padding-bottom: 10px;"></a>';}?>
      <br>
      <table align="center">
        <tr>
          <td class="text-right">
          <span class="zmdi-hc-stack zmdi-hc-lg" style="margin-top:-33px; margin-right: 8px; display: inline-block;">
            
            <a href="bgg_reviews.php?id=<?php echo $bggGameId; ?>&name=<?php echo $bggGameName; ?>&list=<?php echo $list; ?>">
          <i class="zmdi zmdi-label-alt zmdi-hc-stack-2x" style="font-size: 52px;color:#188ae2;"></i>
          <i class="zmdi zmdi-hc-stack-1x zmdi-hc-inverse" style="font-family: Raleway; font-size: 18px; margin-top:7px; margin-left:-1px;"><?php echo number_format((float)$bggRating, 1, '.', ''); ?></i>
          </a>
          </span>
          </td>
          <td class="text-left">
          <?php
      
          if (strlen($bggGameName) > 18) {
            echo '<h3 class="profile-info-name m-b-lg" style="font-size: 25px; margin-top: 5px; margin-left:8px; margin-right: 4px; display:inline-block;">'.$bggGameName.'<small>'.$year.'</small></h3>';
          }
          else {
            echo '<h3 class="profile-info-name m-b-lg" style="font-size: 30px; margin-top: 5px; margin-left:8px; margin-right: 4px; display:inline-block;">'.$bggGameName.'</h3><small>'.$year.'</small>';
          }
           ?>
          </td>
        </tr>
      </table>
    </div>
  </div><!-- .profile-cover -->

<?php

      $query = " 
        SELECT * FROM game_details 
        WHERE 
            bgg_id = :gameid
            AND user_id = :userid
    "; 
     
    $query_params = array( 
        ':gameid' => $bggGameId,
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
        echo ' <div class="promo-footer" style="background-color: #188AE2;">';
        echo '<div class="row no-gutter">';
        foreach ($rows as $x) {
          $id = $x['id'];
          if ($x['list_type'] == 1) {
            echo '<div class="col-sm-12 col-xs-12 promo-tab">';
              echo '<div class="text-center">';
                echo '<a href="game_details.php?id='.$id.'"><h4 class="m-0 m-t-xs" style="color: white;">IN YOUR GAME LIBRARY</h4></a>';
              echo '</div>';
            echo '</div>';
          }
          elseif ($x['list_type'] == 2) {
            echo '<div class="col-sm-12 col-xs-12 promo-tab">';
              echo '<div class="text-center">';
                echo '<a href="game_details.php?id='.$id.'"><h4 class="m-0 m-t-xs" style="color: white;">ON YOUR WISHLIST</h4></a>';
              echo '</div>';
            echo '</div>';
          }
          elseif ($x['list_type'] == 3) {
            echo '<div class="col-sm-12 col-xs-12 promo-tab">';
              echo '<div class="text-center">';
                echo '<a href="game_details.php?id='.$id.'"><h4 class="m-0 m-t-xs" style="color: white;">IN YOUR ARCHIVE</h4></a>';
              echo '</div>';
            echo '</div>';
          }
          echo '</div>';
        echo '</div>';
        }
      }
?>

  <div class="promo-footer">
    <div class="row no-gutter">

      <div class="col-sm-2 col-sm-offset-2 col-xs-6 promo-tab">
        <div class="text-center">
          <small>Type</small>
          <?php
            if ($bggPlayType) {
              echo '<h4 class="m-0 m-t-xs" style="font-size:22px;">'.$bggPlayType.'</h4>';
            }
            else {
              echo '<h4 class="m-0 m-t-xs">Not listed</h4>';
            }
            ?>
        </div>
      </div>
      
      
      <div class="col-sm-2 col-xs-6 promo-tab">
        <div class="text-center">
          <small>Players</small>
          <?php
            if ($players) {
              echo '<h4 class="m-0 m-t-xs" style="font-size:22px;">'.$players.' people</h4>';
            }
            else {
              echo '<h4 class="m-0 m-t-xs">Not listed</h4>';
            }
            ?>
        </div>
      </div>

      <div class="col-sm-2 col-xs-6 promo-tab">
        <div class="text-center">
          <small>Weight</small>
          <div class="m-t-xs">
            <?php
            if ($bggWeight) {
              echo '<h4 class="m-0 m-t-xs" style="font-size:22px;">'.number_format((float)$bggWeight, 1, '.', '').'/5</h4>';
            }
            else {
              echo '<h4 class="m-0 m-t-xs">None</h4>';
            }
            ?>
          </div>
        </div>
      </div>

      <div class="col-sm-2 col-xs-6 promo-tab">
        <div class="text-center">
          <small>Time</small>
          <div class="m-t-xs">
            <?php
            if ($bggPlayTime) {
              echo '<h4 class="m-0 m-t-xs" style="font-size:22px;">'.$bggPlayTime.' min</h4>';
            }
            else {
              echo '<h4 class="m-0 m-t-xs">Not listed</h4>';
            }
            ?>
          </div>
        </div>
      </div>
      
    </div>
  </div><!-- .promo-footer -->
</div><!-- .profile-header -->


      
     
<div class="wrap" style="padding-top: 0px;">
  <section class="app-content">


    <div class="row" style="padding-top: 40px;padding-bottom: 40px;">
         <?php 
      
    if (!$rows) {
      echo '<div class="col-md-12 promo-tab">';
        echo '<div class="text-center">';
           echo '<form action="add_bgg_game.php" method="post" style="display: inline-block;margin-right: 30px;">';
              echo '<div style="border-top: 0px solid white;">';
                 echo '<input type="hidden" name="id" value="'.$bggGameId.'">';
                 echo '<input type="hidden" name="list" value="1">';
                echo '<button type="submit" onclick="return confirm(&#39Are you sure you want to add this game to your Library&#39);" class="btn btn-default" style="width: 140px;height: 60px;">Add to Library</button>';
              echo '</div>';
            echo '</form>';
        
         echo '<form action="add_bgg_game.php" method="post" style="display: inline-block;">';
              echo '<div style="border-top: 0px solid white;">';
                 echo '<input type="hidden" name="id" value="'.$bggGameId.'">';
                 echo '<input type="hidden" name="list" value="2">';
                echo '<button type="submit" onclick="return confirm(&#39Are you sure you want to add this game to your Wishlist?&#39);" class="btn btn-default" style="width: 140px;height: 60px;">Add to Wishlist</button>';
              echo '</div>';
            echo '</form>';
        echo '</div>';
      echo '</div>';
}
  ?>
    </div>
    

    <div class="row">
      <div class="col-md-12">
        <div id="profile-tabs" class="nav-tabs-horizontal white m-b-lg">
          <!-- tabs list -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active" style="font-size: 18px;"><a href="#description" aria-controls="photos" role="tab" data-toggle="tab">Description</a></li>
            <?php echo '<li role="presentation" style="font-size: 18px;"><a href="get_game_reviews.php?id='.$bggGameId.'&name='.$bggGameName.'&list='.$list.'" style="color: #188ae2">Reviews</a></li>'; ?>
            <?php $searchName = $bggGameName;
                    $searchName = str_replace(' ','%20',$searchName);
                    echo '<li role="presentation" style="font-size: 18px;"><a href="http://www.boardgameprices.com/compare-prices-for?q='.$searchName.'" target="_blank" style="color: #188ae2">Prices</a></li>'; ?>
          </ul><!-- .nav-tabs -->

          <!-- Tab panes -->
          <div class="tab-content">

            <div role="tabpanel" id="description" class="tab-pane in active fade p-md">

              <div class="media stream-post" style="padding-top: 5px;">
                <div class="media-body">
                  
                  <?php
                  if ($bggDescription) {
                    echo '<div class="stream-body m-t-xl">';
                    echo '<p>'.$bggDescription.'</p>';
                  echo '</div><br>';
                  }
                  ?>
                </div>
              </div><!-- .stream-post -->
              
            </div><!-- .tab-pane -->
            
          </div><!-- .tab-content -->
        </div><!-- #profile-components -->
      </div><!-- END column -->

      
    </div><!-- .row -->

    
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
function goBack() {
    window.history.back();
}
</script>s
  <script type="text/javascript">
    function confirm_alert(node) {
       return confirm("Add gameplay?");
    }
  </script>
</body>
</html>