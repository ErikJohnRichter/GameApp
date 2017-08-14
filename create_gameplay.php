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
<?php include("side_bar.php"); ?>
<!--========== END app aside -->

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
  <div class="profile-header">
  <div class="profile-cover" style="padding-top: 30px; padding-bottom: 40px;">
    <?php
      echo '<a href="game_details.php?id='.$_POST['id'].'" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>';
    ?>
    <div class="text-center">
      <h3 class="profile-info-name m-b-lg" id="logGameplayTitle" style="font-size: 30px; margin-top: 5px;">Add gameplay for<br><?php echo $name; ?>
        <label for="logGameplayTitle" style="margin-left: 2px;">
          <a href="javascript:void(0)" data-toggle="modal" data-target="#gameplayLoggingHelp" aria-expanded="false" style="color: grey; display: inline-block;">
          <i class="zmdi zmdi-hc-sm zmdi-help-outline"></i>
         </a>
        </label>
      </h3>
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
              
                <?php
                  if ($scoring) {
                    if ($scoring == 'desc') {
                      $system = "Highscore wins";
                    }
                    elseif ($scoring == 'asc') {
                      $system = "Lowscore wins";
                    }
                    elseif ($scoring == 'coop') {
                      $system = "Cooperative";
                    }
                    elseif ($scoring == 'set') {
                      $system = "Flat-point win";
                    }
                    elseif ($scoring == 'money') {
                      $system = "Currency";
                    }
                    elseif ($scoring == 'other') {
                      $system = "No points awarded";
                    }
                    elseif ($scoring == 'lose') {
                      $system = "Loser loses game";
                    }
                    else {
                      $system = "Highscore wins";
                    }
                    echo '<div class="form-group text-left">';
                    echo '<p style="font-size: 16px; display: inline-block; padding-left: 3px;"><b>Current scoring system:&nbsp;&nbsp;</b>'.$system.'<a href="edit_scoring.php?id='.$gameId.'" style="color: #188AE2; display: inline-block; text-decoration: none;"><span class="glyphicon glyphicon-pencil" style="font-size: 12px; padding-left: 10px;"></span></a></p>';
                     echo '</div>';
                }
                  ?>
              
              <div class="form-group">
                <div class="input-group date" id='date' data-plugin="datetimepicker">
                  <input type='text' id="gamePlayDate" name="playDate" class="form-control simple-input" placeholder="Date  (if today, leave blank)"/>
                  <span class="input-group-addon bg-info text-white">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
              <div class="form-group">
                  <input type="text" name="location" id="playLocation" class="form-control simple-input" placeholder="Location">
              </div>
              <div class="form-group pull-left">
                <input type="checkbox" name="tie-game" id="tieGame" style="margin-left: 2px;"/>
                <label for="tieGame" style="margin-left: 2px;">Tie Game
                  <a href="javascript:void(0)" data-toggle="modal" data-target="#tieLoggingHelp" aria-expanded="false" style="color: grey; display: inline-block;">
                  <i class="zmdi zmdi-hc-sm zmdi-help-outline"></i>
                 </a>
                </label>
              </div>
              <div class="form-group">
                <select class="form-control simple-input select-box" name="players" id="totalPlayers">
                  <option selected value="">Total Players</option>
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
                <select name="player-1" id="playWinner" class="form-control validateGame simple-input select-box">
                      <?php
                  if ($scoring == "other" || $scoring == "coop" || $scoring == "set") {
                      echo '<option selected disabled>Winner</option>';
                    }
                    elseif ($scoring == "lose") {
                      echo '<option selected disabled>Loser</option>';
                    }
                    else {
                      echo '<option id="player-winner" selected disabled>Winner</option>';
                    }
                      
                      ?>
                    
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
                          $extraPlayers = $extraPlayers.'<option value="Tie">Tie</option>';
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
                  if ($scoring != 'coop' && $scoring != 'other' && $scoring != 'set' && $scoring != 'lose') { ?>
              <div class="form-group">
                  <input type="text" name="player-1-score" id="playWinningScore" class="form-control simple-input" placeholder="Winning score">
              </div>
              <?php } 
                if ($scoring != 'coop') { ?>
              <div id="extraPlayers"></div>
              <script>
              var gameScoring = '<?php echo $scoring; ?>';
              if (gameScoring == 'other' || gameScoring == 'set' || gameScoring == 'lose') {
                $("#totalPlayers").on("change", function () {
                  var number = parseInt($("#totalPlayers").val());
                  $('#player-winner').text("Player 1");
                  $('#playWinningScore').attr("placeholder", "Player 1 score");
                  $('#playWinningScore').addClass('validateGame');
                  
                  var html = '';
                  $("#extraPlayers").html('');
                  var player = 1;

                  for (i = 1; i < number; i++) {
                     player++;
                    var players = <?php echo json_encode($extraPlayers); ?>;
                    var extraPlayerList = '<div class="form-group"><select name="player-'+player+'" class="form-control validateGame simple-input select-box"><option selected disabled>Player '+player+'</option>'+players+'</select></div>';
                      html += extraPlayerList;
                     
                  };
                  console.log(player);

                  $("#extraPlayers").html(html);
              });
              }
              else {
                $("#totalPlayers").on("change", function () {
                  var number = parseInt($("#totalPlayers").val());
                  $('#player-winner').text("Player 1");
                  $('#playWinningScore').attr("placeholder", "Player 1 score");
                  $('#playWinningScore').addClass('validateGame');
                  
                  var html = '';
                  $("#extraPlayers").html('');
                  var player = 1;

                  for (i = 1; i < number; i++) {
                     player++;
                    var players = <?php echo json_encode($extraPlayers); ?>;
                    var extraPlayerList = '<div class="form-group"><select name="player-'+player+'" class="form-control validateGame simple-input select-box"><option selected disabled>Player '+player+'</option>'+players+'</select></div>';
                    var extraPlayerScore = '<div class="form-group"><input type="text" name="player-'+player+'-score" class="form-control validateGame simple-input" placeholder="Player '+player+' score"></div>';
                      html += extraPlayerList+extraPlayerScore;
                     
                  };
                  console.log(player);

                  $("#extraPlayers").html(html);
              });
              }
                </script>
                <?php } ?>
              <div class="form-group">
                  <input type="text" name="play-time" id="playTime" class="form-control simple-input" placeholder="Time played (in mins)">
              </div>
              <div class="form-group">
                <textarea type="text" rows="4" name="notes" id="playNotes" class="form-control simple-input" placeholder="Gameplay notes"></textarea>
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
        <?php include("copywrite.php"); ?>
      </div>
    </footer>
  </div>
  <!-- /#app-footer -->

  <!-- add help -->
  <div id="tieLoggingHelp" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tie Game</h4>
        </div>
        <div class="modal-body">
          <p>-If your game ended in a tie, check this box and continue to fill out all player names and scores as normal.</p>
          <p>-The Game Winner will be logged as "Tie" and all players will be logged as "Other Players."</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  <!-- add help -->
  <div id="gameplayLoggingHelp" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Gameplay Logging Help</h4>
        </div>
        <div class="modal-body">
          <ul style="list-style-type: circle; padding: 1em;">
            <li style="padding-top: .5em; padding-bottom: .5em;"><b>Date of Play</b> - <span style="color: red;">required</span></li>
            <li style="padding-top: .5em; padding-bottom: .5em;"><b>Game Winner</b> with or without a score - <span style="color: red;">required</span> <b>-OR-</b></li>
            <li style="padding-top: .5em; padding-bottom: .5em;"><b>Number of Players</b> - <span style="color: #10C469;">optional, but if set...</span>:
              <ul style="list-style-type: circle; padding-left: 2em;">
                <li style="padding-top: .5em; padding-bottom: .5em;"><b>Player Names</b> must be logged for all players - <span style="color: red;">required</span></li>
                <li style="padding-top: .5em; padding-bottom: .5em;"><b>Player Score</b> must be logged for all players, if applicable - <span style="color: red;">required</span></li> 
                <li style="padding-top: .5em; padding-bottom: .5em;">GameApp will automatically calculate the winner and loser based on the game's scoring mechanic</li>
              </ul>
            </li>
            <li style="padding-top: .5em; padding-bottom: .5em;"><b>Tie Game</b> - <span style="color: #10C469;">optional</span>
              <ul style="list-style-type: circle; padding-left: 2em;">
                <li style="padding-top: .5em; padding-bottom: .5em;">If your game ended in a tie, check this box and continue to fill out all player names and scores as normal</li>
                <li style="padding-top: .5em; padding-bottom: .5em;">The Game Winner will be logged as "Tie" and all players will be logged as "Other Players."</li>
              </ul>
            </li>
          </ul>
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
          alert("Whoa, whoa, whoa! Looks like you're missing some stuff!")
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