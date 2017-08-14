<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

    $userName = ucfirst($_GET['username']);
    $userList = $_GET['list'];

    $query = " 
        SELECT * FROM users 
        WHERE 
            
            username = :username
    "; 
     
    $query_params = array( 
        ':username' => $_GET['username']
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
        $userId = $x['id'];
        $picture = $x['picture'];
        $first = $x['first'];
        $last = $x['last'];
        $libraryPrivacy = $x['library_public'];
        $wishlistPrivacy = $x['public'];
      }
    }

    $query = " 
        SELECT * FROM game_details 
        WHERE 
            
            user_id = :userid
            AND list_type = :list
            ORDER BY name asc
    "; 
     
    $query_params = array( 
        ':userid' => $userId,
        ':list' => '1'
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
    if ($libraryPrivacy) {
      $gameList = "<tr><td style='border-top: 0px solid white;'>This user does not have any games</td></tr>";
      if ($rows) {
        $gameList = "";
        $i=1;
        foreach ($rows as $x) {
          if ($i == 1) {
            $gameList = $gameList."<tr class='clickable-row' data-href='user_game_details.php?id=".$x['id']."'><td style='border-top: 0px solid white; width:90px;'><img src='./images/".$x['bgg_id'].".jpg' style='max-height:90px;max-width:50px;' onerror='this.src=&#39;./images/noimage.jpg&#39;'></td><td style='border-top: 0px solid white; font-size:16px;'>".$x['name']."</td></td>";
          }
          else {
            $gameList = $gameList."<tr class='clickable-row' data-href='user_game_details.php?id=".$x['id']."'><td style='width:90px;'><img src='./images/".$x['bgg_id'].".jpg' style='max-height:90px;max-width:50px;' onerror='this.src=&#39;./images/noimage.jpg&#39;'></td><td style='font-size:16px;'>".$x['name']."</td></td>";
          }
          $i++;
        }
      }
    }
    else {
      $gameList = "<tr><td style='border-top: 0px solid white;'>This user's Game Library is not public</td></tr>";
    }

    $query = " 
        SELECT * FROM game_details 
        WHERE 
            
            user_id = :userid
            AND list_type = :list
            AND status = :status
            ORDER BY wishlist_order asc
    "; 
     
    $query_params = array( 
        ':userid' => $userId,
        ':list' => '2',
        ':status' => 'Want'
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
    if ($wishlistPrivacy) {
      $wishList = "<tr><td style='border-top: 0px solid white;'>This user does not want any games</td></tr>";
      if ($rows) {
        $wishList = "";
        $i=1;
        foreach ($rows as $x) {
          if ($i == 1) {
            $wishList = $wishList."<tr class='clickable-row' data-href='user_game_details.php?id=".$x['id']."'><td style='border-top: 0px solid white; width:20px;'>".$i.".</td><td style='border-top: 0px solid white; width:90px;'><img src='./images/".$x['bgg_id'].".jpg' style='max-height:90px;max-width:50px;' onerror='this.src=&#39;./images/noimage.jpg&#39;'></td><td style='border-top: 0px solid white; font-size:16px;'>".$x['name']."</td></td>";
          }
          else {
            $wishList = $wishList."<tr class='clickable-row' data-href='user_game_details.php?id=".$x['id']."'><td style='width:20px;'>".$i.".</td><td style='width:90px;'><img src='./images/".$x['bgg_id'].".jpg' style='max-height:90px;max-width:50px;' onerror='this.src=&#39;./images/noimage.jpg&#39;'></td><td style='font-size:16px;'>".$x['name']."</td></td>";
          }
          $i++;
        }
      }
    }
    else {
      $wishList = "<tr><td style='border-top: 0px solid white;'>This user's Wishlist is not public</td></tr>";
    }

    $query = " 
        SELECT * FROM game_details 
        WHERE 
            
            user_id = :userid
            AND list_type = :list
            AND rating > 1
            ORDER BY CAST(`rating` AS decimal) desc, name asc
            LIMIT 10
    "; 
     
    $query_params = array( 
        ':userid' => $userId,
        ':list' => '1'
        
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
    if ($libraryPrivacy) {
      $topGames = "<tr><td style='border-top: 0px solid white;'>This user has not rated any games.</td></tr>";
      if ($rows) {
        $topGames = "";
        $i=1;
        foreach ($rows as $x) {
          if ($i == 1) {
            $topGames = $topGames."<tr class='clickable-row' data-href='user_game_details.php?id=".$x['id']."'><td style='border-top: 0px solid white; width:20px;'>".$i.".</td><td style='border-top: 0px solid white; width:90px;'><img src='./images/".$x['bgg_id'].".jpg' style='max-height:90px;max-width:50px;' onerror='this.src=&#39;./images/noimage.jpg&#39;'></td><td style='border-top: 0px solid white; font-size:16px;'>".$x['name']."</td></td>";
          }
          else {
            $topGames = $topGames."<tr class='clickable-row' data-href='user_game_details.php?id=".$x['id']."'><td style='width:20px;'>".$i.".</td><td style='width:90px;'><img src='./images/".$x['bgg_id'].".jpg' style='max-height:90px;max-width:50px;' onerror='this.src=&#39;./images/noimage.jpg&#39;'></td><td style='font-size:16px;'>".$x['name']."</td></td>";
          }
          $i++;
        }
      }
    }
     else {
      $topGames = "<tr><td style='border-top: 0px solid white;'>This user's Favorite Games are not public</td></tr>";
    }


    $query = " 
        SELECT * FROM rating_scale 
        WHERE 
            user_id = :userid
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

    $rowz = $stmt->fetchAll();
    if ($rowz) {
        foreach ($rowz as $x) {
          $ten = $x['ten'];
          $nine = $x['nine'];
          $eight = $x['eight'];
          $seven = $x['seven'];
          $six = $x['six'];
          $five = $x['five'];
          $four = $x['four'];
          $three = $x['three'];
          $two = $x['two'];
          $one = $x['one'];
          
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

    <a href="social.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        
        <li>
          <?php 
          if ($first) {
          echo '<h5 class="page-title hidden-menubar-top hidden-float">'.$first.'\'s GameApp</h5>';
        }
        else {
          echo '<h5 class="page-title hidden-menubar-top hidden-float">'.$userName.'\'s GameApp</h5>';
        }
          ?>
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
<?php include("side_bar.php"); ?>
<!--========== END app aside -->

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="profile-header">
  <div class="profile-cover" style="padding-top: 30px; padding-bottom: 40px;">
    <?php 
      if ($userList == "search") {
        echo '<a href="search_users.php?username='.$userName.'" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
      }
      else {
        echo '<a href="social.php" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
      }

    ?>
    <div class="text-center">
      <?php echo '<img src="assets/images/'.$picture.'" style="padding-bottom: 10px; max-width: 150px;">';?>
      <br>
      <table align="center">
        <tr>
          <td>
          <?php
            if ($first) {
              echo '<h3 class="profile-info-name m-b-lg" style="font-size: 30px; margin-top: 5px; display:inline-block;">'.ucfirst($first).' '.ucfirst($last).'</h3>';
            }
            else {
              echo '<h3 class="profile-info-name m-b-lg" style="font-size: 30px; margin-top: 5px; display:inline-block;">'.$userName.'</h3>';
            }
           ?>
          </td>
        </tr>
        <tr>
          <?php
          $query = " 
            SELECT COUNT(*) 
            FROM following
            WHERE follower = :follower AND following=:following;
            "; 
             
            $query_params = array( 
                ':follower' => $_SESSION['userid'],
                ':following' => $userId
            ); 
             
            try 
            { 
                $result = $db->prepare($query); 
                $result->execute($query_params); 
                $following = $result->fetchColumn(0);
            } 
            catch(PDOException $ex) 
            { 
                die($ex); 
            } 

          if ($_SESSION['userid'] == $userId) {
            echo '<td>
            <button class="btn btn-sm btn-info" disabled>This is your details page</button>
            </td>';
          }
          elseif ($following > 0) {
            echo '<td>
            <form action="unfollow_user.php" method="post">
            <input type="hidden" name="following-id" value="'.$userId.'">
            <input type="hidden" name="following-username" value="'.$_GET['username'].'">
            <button class="btn btn-sm btn-info" type="submit">Unfollow</button>
            </form>
            </td>';
          }
          else {
            echo '<td>
            <form action="follow_user.php" method="post">
            <input type="hidden" name="following-id" value="'.$userId.'">
            <input type="hidden" name="following-username" value="'.$_GET['username'].'">
            <button class="btn btn-sm btn-success" type="submit">Follow</button>
            </form>
            </td>';
          }
          ?>
        </tr>
      </table>
    </div>
  </div><!-- .profile-cover -->
</div>

<div class="wrap" style="padding-top: 0px;">
  <section class="app-content">

    <div class="row" >
      <div class="col-md-12 promo-tab text-center" >
        <div class="text-center" style="display:inline-block;">
            <div style="border-top: 0px solid white;">
              <?php
                if ($first) {
                  echo '<a href="javascript:void(0)" data-toggle="modal" data-target="#ratingDescription" aria-expanded="false"><button class="btn btn-default" style="width: 280px;height: 50px;">'.ucfirst($first).'\'s Rating Definitions</button></a>';
                }
                else {
                  echo '<a href="javascript:void(0)" data-toggle="modal" data-target="#ratingDescription" aria-expanded="false"><button class="btn btn-default" style="width: 280px;height: 50px;">'.$userName.'\'s Rating Definitions</button></a>';
                }
               ?>
            </div>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12">
        <div id="profile-tabs" class="nav-tabs-horizontal white m-b-lg">
          <!-- tabs list -->
          <ul class="nav nav-tabs text-left" role="tablist">
            <li role="presentation" class="active" style="font-size: 18px;"><a href="#description" aria-controls="photos" role="tab" data-toggle="tab">Library</a></li>
            <li role="presentation" style="font-size: 18px;"><a href="#notes" aria-controls="stream" role="tab" data-toggle="tab">Wishlist</a></li>
            <li role="presentation" style="font-size: 18px;"><a href="#topgames" aria-controls="stream" role="tab" data-toggle="tab">Favorites</a></li>
          </ul><!-- .nav-tabs -->

          <!-- Tab panes -->
          <div class="tab-content">

            <div role="tabpanel" id="description" class="tab-pane in active fade p-md">

              <div class="media stream-post" style="padding-top: 5px;">
                <div class="media-body">
                  <table class="table table-hover">

                  <?php
                  echo $gameList;
                  ?>
                </table>
                </div>
              </div><!-- .stream-post -->
              
            </div><!-- .tab-pane -->

            <div role="tabpanel" id="notes" class="tab-pane fade p-md">

              <div class="media stream-post" style="padding-top: 5px;">
                <div class="media-body">
                  <table class="table table-hover">

                  <?php
                  echo $wishList;
                  ?>
                </table>
                </div>
              </div><!-- .stream-post -->
              
            </div><!-- .tab-pane -->

            <div role="tabpanel" id="topgames" class="tab-pane fade p-md">

              <div class="media stream-post" style="padding-top: 5px;">
                <div class="media-body">
                  <table class="table table-hover">

                  <?php
                  echo $topGames;
                  ?>
                </table>
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
        <?php include("copywrite.php"); ?>
      </div>
    </footer>
  </div>
  <!-- /#app-footer -->

  <div id="ratingDescription" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Rating Definitions</h4>
        </div>
        <div class="modal-body">
          <br>
          <?php if ($rowz) { ?>
            <div class="col-xs-1" style="margin-bottom: 10px;"><b>10</b></div><div class="col-xs-10" style="margin-bottom: 10px;"><?php echo $ten; ?></div>
            <div class="clearfix"></div>
            <div class="col-xs-1" style="margin-bottom: 10px;"><b>9</b></div><div class="col-xs-10" style="margin-bottom: 10px;"><?php echo $nine; ?></div>
            <div class="clearfix"></div>
            <div class="col-xs-1" style="margin-bottom: 10px;"><b>8</b></div><div class="col-xs-10" style="margin-bottom: 10px;"><?php echo $eight; ?></div>
            <div class="clearfix"></div>
            <div class="col-xs-1" style="margin-bottom: 10px;"><b>7</b></div><div class="col-xs-10" style="margin-bottom: 10px;"><?php echo $seven; ?></div>
            <div class="clearfix"></div>
            <div class="col-xs-1" style="margin-bottom: 10px;"><b>6</b></div><div class="col-xs-10" style="margin-bottom: 10px;"><?php echo $six; ?></div>
            <div class="clearfix"></div>
            <div class="col-xs-1" style="margin-bottom: 10px;"><b>5</b></div><div class="col-xs-10" style="margin-bottom: 10px;"><?php echo $five; ?></div>
            <div class="clearfix"></div>
            <div class="col-xs-1" style="margin-bottom: 10px;"><b>4</b></div><div class="col-xs-10" style="margin-bottom: 10px;"><?php echo $four; ?></div>
            <div class="clearfix"></div>
            <div class="col-xs-1" style="margin-bottom: 10px;"><b>3</b></div><div class="col-xs-10" style="margin-bottom: 10px;"><?php echo $three; ?></div>
            <div class="clearfix"></div>
            <div class="col-xs-1" style="margin-bottom: 10px;"><b>2</b></div><div class="col-xs-10" style="margin-bottom: 10px;"><?php echo $two; ?></div>
            <div class="clearfix"></div>
            <div class="col-xs-1" style="margin-bottom: 20px;"><b>1</b></div><div class="col-xs-10" style="margin-bottom: 20px;"><?php echo $one; ?></div>
            <div class="clearfix"></div>
            <?php } else { ?>
            <div class="col-xs-11" style="margin-bottom: 20px;">No user ratings defined.</div>
            <div class="clearfix"></div>
            <?php } ?>
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
  <script>
  jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
  </script>
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