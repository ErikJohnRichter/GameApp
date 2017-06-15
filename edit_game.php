<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

$gameId = $_GET['id'];
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

    <a href="library.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float">Edit Game Details</h5>
        </li>
      </ul>

      <ul class="nav navbar-toolbar navbar-toolbar-right navbar-right">

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

<!-- navbar search -->
<div id="navbar-search" class="navbar-search collapse">
  <div class="navbar-search-inner">
    <form action="#">
      <span class="search-icon"><i class="fa fa-search"></i></span>
      <input class="search-field" type="search" placeholder="search..."/>
    </form>
    <button type="button" class="search-close" data-toggle="collapse" data-target="#navbar-search" aria-expanded="false">
      <i class="fa fa-close"></i>
    </button>
  </div>
  <div class="navbar-search-backdrop" data-toggle="collapse" data-target="#navbar-search" aria-expanded="false"></div>
</div><!-- .navbar-search -->

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="wrap">
	<section class="app-content">
    <?php

    $query = " 
            SELECT * FROM game_details 
            WHERE 
                id = :gameid
                AND user_id = :userid
        "; 
         
        $query_params = array( 
            ':gameid' => $gameId,
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
                    $players = $x['players'];
                    $bggGameId = $x['bgg_id'];
                    
                }
                
            }

        
        $players = explode('-', $players);
        $minPlayers = $players[0]; 
        $maxPlayers = $players[1];  
      

    ?>

    <div class="row" id="gameList">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="widget row no-gutter p-lg">  
        <header class="widget-header game-list">
            <h3 class="widget-title text-center">Edit Game</h3>
          </header>          
          <!-- Ajax dataTable -->
          <div class="widget-body">
            <form onsubmit="return validateEditGameForm()" action="save_game_edit.php" id="saveEditForm" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-group">
                  <label for="gameName">Name</label>
                  <input type="text" name="name" id="gameName" class="form-control validateGame" placeholder="Name" value="<?php echo htmlspecialchars($x['name']); ?>">
                </div>
                <div class="form-group">
                  <label for="gameBggUrl">BoardGameGeek URL</label>
                  <input type="text" name="bggUrl" id="gameBggUrl" class="form-control" placeholder="BoardGameGeek URL" value="<?php echo htmlspecialchars($x['url']); ?>">
                  <br><small class="text-center">Saving this page with a BGG URL will update a game's BGG Rating and Description. It will also reset Game Weight and Published Date.</small>
                </div>
                <!--<div class="form-group">
                  <label for="gameCost">Picture</label>
                  <input type="file" class="form-control" name="picture" id="gamePicture">
                </div>-->
                <!--<div class="form-group">
                  <label for="gameBggId">BoardGameGeek ID</label>
                  <input type="text" name="bggId" id="gameBggId" class="form-control" placeholder="BoardGameGeek ID" value="<?php echo htmlspecialchars($x['bgg_id']); ?>">
                </div>-->
                
                <?php echo '<input type="hidden" name="game-id" value="'.$gameId.'">'; ?>
                <?php echo '<input type="hidden" name="list-type" value="'.$x['list_type'].'">'; ?>
              </div><!-- .modal-body -->
              <div class="modal-footer">
                <?php
                
                  echo '<a href="game_details.php?id='.$gameId.'"><button type="button" class="btn btn-danger">Cancel</button></a>';
              ?>
              <button type="submit" id="saveEditGame" class="btn btn-success">Save</button>

              </div><!-- .modal-footer -->

            </form>
            <br><br><br>
            <?php if ($x['list_type'] == 1 && $bggGameId != null) { ?>
            <form action="update_bgg_details.php" method="post">
              <div class="modal-footer" style="border-top: 0px solid white;">
                <?php echo '<input type="hidden" name="game-id" value="'.$gameId.'">'; ?>
                <?php echo '<input type="hidden" name="bgg-game-id" value="'.$bggGameId.'">'; ?>
                <button id="updateBggDetails" type="submit" onclick="return confirm('Are you sure you want to update all BGG Details for this game?');" class="btn btn-info">Update BGG Details</button>
              </div><!-- .modal-footer -->
            </form>
            <?php } ?>
            <?php if ($x['list_type'] == 2) { ?>
            <form action="archive_game.php" method="post">
              <div class="modal-footer" style="border-top: 0px solid white;">
                <?php echo '<input type="hidden" name="game-id" value="'.$gameId.'">'; ?>
                <button id="archiveGame" type="submit" onclick="return confirm('Are you sure you want to archive this game?');" class="btn btn-default" style="width: 85px;">Archive</button>
              </div><!-- .modal-footer -->
            </form>
            <?php } ?>
            <form action="delete_game.php" method="post">
              <div class="modal-footer" style="border-top: 0px solid white;">
                <?php echo '<input type="hidden" name="game-id" value="'.$gameId.'">'; ?>
                <?php echo '<input type="hidden" name="game-list" value="'.$x['list_type'].'">'; ?>
                <button id="deleteGame" type="submit" onclick="return confirm('Are you sure you want to delete this game?');" class="btn btn-default" style="width: 85px;">Delete</button>
              </div><!-- .modal-footer -->
            </form>

          </div><!-- .widget-body -->
        </div><!-- .widget -->  
      </div>
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
</main>
<!--========== END app main -->

                <script>
                var temp1 = "<?php echo htmlspecialchars($x['gameplay_knowledge']); ?>";

                $(function(){
                    $("#gameplayKnowledge").val(temp1).attr('selected','selected');
                });


                var temp2 = "<?php echo htmlspecialchars($x['rating']); ?>";

                $(function(){
                    $("#gameRating").val(temp2).attr('selected','selected');
                });


                var temp3 = "<?php echo htmlspecialchars($x['type']); ?>";

                $(function(){
                    $("#gameType").val(temp3).attr('selected','selected');
                });

                var temp4 = "<?php echo $minPlayers; ?>";

                if (temp4) {
                  $(function(){
                      $("#gameMinPlayers").val(temp4).attr('selected','selected');
                  });
                }

                var temp5 = "<?php echo $maxPlayers; ?>";

                if (temp5) {
                  $(function(){
                      $("#gameMaxPlayers").val(temp5).attr('selected','selected');
                  });
                }

                var temp6 = "<?php echo htmlspecialchars($x['purchase_date']); ?>";

                $(function(){
                    $("#gamePurchaseDate").val(temp6).attr('selected','selected');
                });


                var temp8 = "<?php echo htmlspecialchars($x['status']); ?>";

                $(function(){
                    $("#gameStatus").val(temp8).attr('selected','selected');
                });

                var temp9 = "<?php echo htmlspecialchars($x['highscore']); ?>";

                $(function(){
                    $("#gameHighscore").val(temp9).attr('selected','selected');
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

  <script>
        $('#summernote').addPlugin({
          name: 'customEnter',
          events: {
              'insertParagraph': function (evt) {
                  if (evt.which === 13 || evt.keyCode === 13)
                      evt.shiftKey = true;
              }
          }
      });
    </script>
  

  <script>
      function validateEditGameForm() {
        var isValid = true;
        $('.validateGame').each(function() {
          if ( $(this).val() === '' ) {
              $(this).addClass('inputError');

              isValid = false;
          }
          else if ($(this).val() != '') {
              $(this).removeClass('inputError');
              
          }
        });
        if (isValid == false) {
          alert("Whoa, whoa, whoa! Looks like you're missing some stuff!")
        }
        else {
          $('#saveEditGame').prop("disabled",true);
          $('#saveEditGame').val('Editing...');
        }
        return isValid;
      }
  </script>
  
</body>
</html>