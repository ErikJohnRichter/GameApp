<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        $loggedIn = 0; 
    }
    else {
      $loggedIn = 1;
    } 

$gameId = $_GET['id'];

$query = " 
        SELECT * FROM game_details 
        WHERE 
            id = :gameid
    "; 
     
    $query_params = array( 
        ':gameid' => $gameId
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
          $id = $x['id'];
          $userId = $x['user_id'];
          $list = $x['list_type'];
          $name = $x['name'];
          $knowledge = $x['gameplay_knowledge'];
          $rating = $x['rating'];
          $players = $x['players'];
          $type = $x['type'];
          $cost = $x['cost'];
          $purchase = $x['purchase_date'];
          $url = $x['url'];
          $rules = $x['rules'];
          $notes = $x['notes'];
          $lastplayed = strtotime($x['last_played']);
          $numberofplays = $x['number_of_plays'];
          $rulesNotes = $x['rules_notes'];
          $sort = $x['highscore'];
          $bggid = $x['bgg_id'];
          $bggRating = $x['bgg_rating'];
          $bggDescription = $x['bgg_description'];
          $bggPlaytime = $x['bgg_playtime'];
          $bggType = $x['bgg_type'];
          $bggWeight = $x['bgg_weight'];
          $bggYear = $x['bgg_year'];
          $status = $x['status'];
          $myplaytime = $x['my_playtime'];
          $myplayers = $x['my_players'];
          $mydescription = $x['my_description'];
            
        }
        
        if ($rulesNotes == '&lt;ul&gt;&lt;li&gt;&lt;br&gt;&lt;/li&gt;&lt;/ul&gt;') {
          $rulesNotes = null;
        }
    }

    $query = " 
        SELECT * FROM users 
        WHERE 
            id = :userid
    "; 
     
    $query_params = array( 
        ':userid' => $userId
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
          $userName = $x['username'];
          $wishlistPublic = $x['public'];
          $libraryPublic = $x['library_public'];
        }
        
    }


    $public = false;
    if($list == 1) {
      if ($libraryPublic) {
        $public = true;
      }
    }
    else {
      if ($wishlistPublic) {
        $public = true;
      }
    }

    
    $lastplayed = date('m-d-Y', $lastplayed);

    if (!$sort) {
      $sort = 'desc';
    }

    $searchName = $name;
    $searchName = str_replace(' ','%20',$searchName);

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

    <?php if ($loggedIn == 1) { ?>
    <button type="button" class="navbar-toggle navbar-toggle-right collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="zmdi zmdi-hc-lg zmdi-more"></span>
    </button>

    <button type="button" class="navbar-toggle navbar-toggle-right collapsed livesearch" data-toggle="collapse" data-target="#navbar-search" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="zmdi zmdi-hc-lg zmdi-search"></span>
    </button>
    <?php } ?>

    <a href="stats.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <?php if ($loggedIn == 1) { ?>
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float"><?php if ($public) {echo ucfirst($userName).' - '.$name;} ?></h5>
        </li>
      </ul>

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
    <?php } ?>
  </div><!-- navbar-container -->
</nav>
<!--========== END app navbar -->

<!-- navbar search -->
<div id="navbar-search" class="navbar-search collapse">
  <div class="navbar-search-inner">
    <form style="margin-top: 5px; display: inline-block; width: 100%">
      <input class="form-control search-field" id="live-search" type="text" size="30" style="font-size: 16px;" onkeyup="showResult(this.value)" placeholder="Search your games" autofocus>
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

<?php if ($loggedIn == 1) { ?>
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
<?php }
else { ?>
  <!-- APP ASIDE ==========-->
<aside id="menubar" class="menubar light">
  <div class="menubar-scroll">
    <div class="menubar-scroll-inner">
      <ul class="app-menu">
        <li>
          <a href="welcome.html">
            <i class="menu-icon zmdi zmdi-help-outline zmdi-hc-lg"></i>
            <span class="menu-text">What is this?</span>
          </a>
        </li>
        
      </ul><!-- .app-menu -->
    </div><!-- .menubar-scroll-inner -->
  </div><!-- .menubar-scroll -->
</aside>
<!--========== END app aside -->
<?php } ?>

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="profile-header">
  <div class="profile-cover" style="padding-top: 30px; padding-bottom: 40px;">
    <?php
    if ($loggedIn == 1) {
      if($public) {
        echo '<a href="user_details.php?username='.$userName.'" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
      }
      else {
        echo '<a href="stats.php" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
      }
    }
    else {
      echo '<i class="fa fa-chevron-left fa-2x" style="padding-left: 15px; color: white;"></i>';
    }
    
    
    ?>
    <div class="text-center">
      <?php 
      
      if (!$public) {
        echo '<br><br><h3 class="profile-info-name m-b-lg" style="font-size: 25px; margin-top: 5px; margin-right: 4px; display:inline-block;">This game is private.</h3><br><br><br><br>';
      }
      else {
      if ($bggid) {echo '<a href="'.$url.'" target="_blank" style="color: #188ae2"><img src="./images/'.$bggid.'.jpg" onerror="this.src=&#39;./images/noimage.jpg&#39;" style="padding-bottom: 10px;"></a>';}
      else {echo '<img src="./images/noimage.jpg" style="padding-bottom: 10px; max-width: 100px;">';} 
      
      ?>
      <br>
       <table align="center">
        <tr>
          <td>
      <?php

      if ($bggRating)
      {
      echo '<span class="zmdi-hc-stack zmdi-hc-lg" style="margin-top:-33px; margin-right: 16px; display: inline-block;">';
      echo' <i class="zmdi zmdi-label-alt zmdi-hc-stack-2x" style="font-size: 52px;color:#188ae2;"></i>';
      echo '<i class="zmdi zmdi-hc-stack-1x zmdi-hc-inverse" style="font-family: Raleway; font-size: 18px; margin-top:7px; margin-left:-1px;">'.number_format((float)$bggRating, 1, '.', '').'</i>';
      echo '</span>'; 
      } 

      echo '</td><td class="text-left">';
      
      if (strlen($name) > 18) {
        echo '<h3 class="profile-info-name m-b-lg" style="font-size: 25px; margin-top: 5px; margin-right: 4px; display:inline-block;">'.$name.'</h3>';
      }
      else {
        echo '<h3 class="profile-info-name m-b-lg" style="font-size: 30px; margin-top: 5px; margin-right: 4px; display:inline-block;">'.$name.'</h3>';
      }

      ?>
      </td>
  </tr>
</table>
    
    </div>
  </div><!-- .profile-cover -->
  <div class="promo-footer">
    <div class="row no-gutter">
      
      <div class="col-sm-2 col-sm-offset-3 col-xs-4 promo-tab">
        <div class="text-center">
          <small>Players</small>
          <?php
            if ($myplayers) {
              echo '<h4 class="m-0 m-t-xs">'.$myplayers.' people</h4>';
            }
            
            else {
              echo '<h4 class="m-0 m-t-xs">None</h4>';
            }
            ?>
        </div>
      </div>
      
      <div class="col-sm-2 col-xs-4 promo-tab">
        <div class="text-center">
          <small><?php echo ucfirst($userName)."'s Rating"; ?></small>
            <div class="m-t-xs">
            <?php
              if ($rating) {
                echo '<h4 class="m-0 m-t-xs">'.$rating.'.0</h4>';
              }
              else {
                echo '<h4 class="m-0 m-t-xs">None</h4>';
              }
            ?>
          </div>
        </div>
      </div>
      <div class="col-sm-2 col-xs-4 promo-tab">
        <div class="text-center">
          <small>Playtime</small>
          <div class="m-t-xs">
            <?php
            if ($myplaytime) {
              echo '<h4 class="m-0 m-t-xs">'.$myplaytime.' min</h4>';
            }
            
            else {
              echo '<h4 class="m-0 m-t-xs">None</h4>';
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
    
    <div class="row" style="padding-top: 20px;padding-bottom: 20px;">
        <?php 
        if ($loggedIn == 1) {
        echo '<div class="col-md-12 promo-tab text-center">';
        echo '<div class="text-center" style="display:inline-block;">';
         echo '<form action="user_game_to_wishlist.php" method="post">';
              echo '<div style="border-top: 0px solid white;">';
                 echo '<input type="hidden" name="game-id" value="'.$gameId.'">';
                echo '<button id="deleteGame" type="submit" onclick="return confirm(&#39Are you sure you want to add this game to your wishlist?&#39);" class="btn btn-default" style="width: 200px;height: 50px;">Add to Wishlist</button>';
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
          <ul class="nav nav-tabs nav-tabs-public" role="tablist">
            <li role="presentation" class="active" style="font-size: 18px;"><a href="#rules" aria-controls="photos" role="tab" data-toggle="tab">Rules</a></li>
            <li role="presentation" style="font-size: 18px;"><a href="#details" aria-controls="stream" role="tab" data-toggle="tab">Info</a></li>
            <?php //echo '<li role="presentation"><a href="add_gameplay.php?id='.$gameId.'&name='.$name.'" onclick="return confirm_alert(this);"><span class="glyphicon glyphicon-play"></span>&nbsp;&nbsp;Add Play</a></li>'; ?>
          </ul><!-- .nav-tabs -->

          <!-- Tab panes -->
          <div class="tab-content">

            <div role="tabpanel" id="rules" class="tab-pane in active fade p-md">

              <div class="media stream-post" style="padding-top: 5px;">
                <div class="media-body">
                  
                  <h4 class="media-heading" style="float: right; margin-top:0px;">
                  </h4>
                  <div class="stream-body m-t-l" style="margin-top: 10px;">
                    <?php 
                    if ($rulesNotes) { echo '<p>'.htmlspecialchars_decode($rulesNotes, ENT_QUOTES).'</p>';} else {echo '<h4 class="m-0 m-t-xs" >None listed</h4>';} 
                    ?>
                  </div>
                  <?php
                  if ($rules) {
                    echo '<hr><h4 class="media-heading m-t-xs" style="padding-top: 5px;">';
                      echo '<a href="'.$rules.'" target="_blank" style="color: #188ae2">Rules Link</a>';
                    echo '</h4>';
                  }
                  ?>
                </div>
              </div><!-- .stream-post -->
              
            </div><!-- .tab-pane -->
            
            <div role="tabpanel" id="details" class="tab-pane fade" style="padding-top: 25px;">

              <div class="media stream-post" style="padding-top: 5px;">
                <div class="media-body">
                  <div class="col-md-6 col-md-offset-3">
                  <table class="table table-sm" style="font-size:18px; margin-bottom: 20px;">
                      <thead style="background-color: #188AE2; color: white;">
                      <tr><td style="width: 60%;"><b>Details:</b></td><td>&nbsp;</td></tr>
                      
                    </thead>
                  <?php
                  if ($myplayers) {
                  echo '<tr>';
                    echo '<td style="padding-right: 10px; word-break: break-word;">Players: </td><td>'.$myplayers.' people</td>';
                    echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($myplaytime) {
                  echo '<tr>';
                    echo '<td style="padding-right: 10px; word-break: break-word;">Playtime: </td><td>'.$myplaytime.' mins</td>';
                    echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($bggYear) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Published: </td><td>'.$bggYear.'</td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($type) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Type: </td><td>'.$type.'</td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  /*if ($bggType) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">BGG type: </td><td>'.$bggType.'</td>';
                      echo '</tr>';
                  }*/
                  ?>
                  <?php
                  if ($sort) {
                    if ($sort == 'desc') {
                      $scoring = "Highscore wins";
                    }
                    elseif ($sort == 'asc') {
                      $scoring = "Lowscore wins";
                    }
                    elseif ($sort == 'coop') {
                      $scoring = "Cooperative";
                    }
                    elseif ($sort == 'set') {
                      $scoring = "Flat-point win";
                    }
                    elseif ($sort == 'other') {
                      $scoring = "No points awarded";
                    }
                    else {
                      $scoring = "Highscore wins";
                    }
                  
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Scoring: </td><td>'.$scoring.'</td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($bggWeight) {
                    echo '<tr>';
                      echo '<td style="padding-right: 10px; word-break: break-word;">Weight: </td><td>'.number_format((float)$bggWeight, 1, '.', '').'/5.0</td>';
                      echo '</tr>';
                  }
                  ?>
                  <?php
                  if ($url) {
                    echo '<tr>';
                      echo '<td style="padding: 18px 0px 18px 14px;" colspan="2"><a href="get_game_reviews.php?id='.$bggid.'&name='.$name.'&list=mygames&gameid='.$gameId.'" style="color: #188ae2"><b>Game Reviews</b></a></td>';
                     echo '</tr>';
                   }
                   echo '<tr>';
                      echo '<td style="padding: 0px;" colspan="2">&nbsp;</td>';
                      echo '</tr>';
                     ?>
                   </table>
                  <table class="table table-sm" style="font-size:18px; margin-bottom: 20px;">
                      <thead style="background-color: #188AE2; color: white;">
                      <tr><td style="width: 60%;"><b>Description:</b></td><td>&nbsp;</td></tr>
                    </thead>
                  <?php
                  if ($bggDescription) {
                    
                    echo '<tr >';
                    echo '<td colspan="2">'.$bggDescription.'</td>';
                  echo '</tr>';
                  }
                  elseif ($mydescription) {
                    
                    echo '<tr >';
                    echo '<td colspan="2"><p>'.htmlspecialchars_decode($mydescription, ENT_QUOTES).'</p></td>';
                  echo '</tr>';
                  }
                  else {
                    echo '<tr >';
                    echo '<td colspan="2">None</td>';
                  echo '</tr>';
                  }
                  ?>
                  </table>
                </div>
                </div>
              </div><!-- .stream-post -->

            </div><!-- .tab-pane -->

          
      </div><!-- END column -->

      
    </div><!-- .row -->

    
  </section><!-- #dash-content -->
</div><!-- .row -->
<?php } ?>

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
  <script type="text/javascript">
    function confirm_alert(node) {
       return confirm("Add gameplay?");
    }
  </script>
</body>
</html>