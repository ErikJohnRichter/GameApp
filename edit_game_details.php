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
<?php include("side_bar.php"); ?>
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
                    $bggPlayers = $x['players'];
                    $myPlayers = $x['my_players'];
                    $bggPlaytime = $x['bgg_playtime'];
                    $myPlaytime = $x['my_playtime'];
                    
                }
                
            }

            if ($myPlayers) {
              $players = $myPlayers;
            }
            elseif ($bggPlayers) {
              $players = $bggPlayers;
            }

            $players = explode('-', $players);
            $minPlayers = $players[0]; 
            $maxPlayers = $players[1];  

            if ($bggPlayers != null && $bggPlayers != 0) {
              $bggPlayerIntegration = 1;
            }
            else {
              $bggPlayerIntegration = 0;
            }

            if ($bggPlaytime != null && $bggPlaytime != 0) {
              $bggPlaytimeIntegration = 1;
            }
            else {
              $bggPlaytimeIntegration = 0;
            }

        

    ?>

    <div class="row" id="gameList">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="widget row no-gutter p-lg">  
        <header class="widget-header game-list">
            <h3 class="widget-title text-center">Edit <?php echo htmlspecialchars($x['name']); ?> Details</h3>
          </header>          
          <!-- Ajax dataTable -->
          <div class="widget-body">
            <form onsubmit="return validateEditGameForm()" action="save_game_details_edit.php" id="saveEditForm" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <?php if ($x['list_type'] == 2) { ?>
                 <div class="form-group">
                  <label for="gameStatus">Game Status</label>
                  <select class="form-control simple-input select-box" name="status" id="gameStatus">
                      <option selected disabled>Status</option>
                      <option value="Want">Want</option>
                      <option value="Research">Research</option>
                      <option value="Preorder">Preorder</option>
                      <option value="Bought">Bought</option>
                      <option value="">None</option>
                    </select>
                </div>
                <?php } 
                if ($x['list_type'] == 1) { ?>
                <div class="form-group">
                  <label for="gameplayKnowledge">Game Status</label>
                  <select class="form-control simple-input select-box" name="knowledge" id="gameplayKnowledge">
                      <option selected disabled>Status</option>
                      <option value="Great">Great</option>
                      <option value="Favorites">Favorites</option>
                      <option value="Need Rules">Need Rules</option>
                      <option value="Need Refresher">Need Refresher</option>
                      <option value="Sell It">Sell It</option>
                      <?php $customSearchString = $_SESSION['customfilter']; if($customSearchString != null) { echo '<option value="'.$customSearchString.'">'.$customSearchString.'</option>'; } ?>
                      <option value="">None</option>
                    </select>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label for="minPlayers">Players</label><br>
                  <select class="form-control simple-input select-box" name="minPlayers" id="gameMinPlayers" style="display: inline-block; width: 49%;">
                      <option selected disabled>Min Players</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="">None</option>
                    </select>
                    <select class="form-control simple-input select-box" name="maxPlayers" id="gameMaxPlayers" style="display: inline-block; width: 49%; float: right;">
                      <option selected disabled>Max Players</option>
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
                      <option value="">None</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="playWith">Play With</label>
                  <input type="text" name="playwith" id="playWith" class="form-control simple-input" placeholder="Play With" value="<?php echo htmlspecialchars($x['play_with']); ?>">
                </div>
                <div class="form-group">
                  <label for="gameHighscore">Scoring</label>
                  <select class="form-control simple-input select-box" name="highscore" id="gameHighscore">
                      <option selected disabled>Scoring</option>
                      <option value="desc">Highest Score Wins</option>
                      <option value="asc">Lowest Score Wins</option>
                      <option value="coop">Cooperative</option>
                      <option value="set">Flat-Point Win</option>
                      <option value="money">Currency</option>
                      <option value="other">No Points Awarded</option>
                      <option value="lose">Loser Loses Game</option>
                      <option value="">Select</option>
                    </select>
                </div>
                <div class="form-group">
                  <label for="gamePlaytime">Playtime (minutes)</label>
                  <input type="text" name="playtime" id="gamePlaytime" class="form-control simple-input" placeholder="Playtime" value="<?php if ($myPlaytime) { echo htmlspecialchars($myPlaytime); } elseif ($bggPlaytime) { echo htmlspecialchars($bggPlaytime); } ?>">
                </div>
                <div class="form-group">
                  <label for="gameType">Primary Type</label>
                  <select class="form-control simple-input select-box" name="type" id="gameType">
                      <option selected disabled>Type</option>
                      <option value="">None</option>
                      <?php include("game_types.php"); ?>
                    </select>
                </div>
                <div class="form-group">
                  <label for="gameType2">Secondary Type</label>
                  <select class="form-control simple-input select-box" name="type2" id="gameType2">
                      <option selected disabled>Type</option>
                      <option value="">None</option>
                      <?php include("game_types.php"); ?>
                    </select>
                </div>
                <?php 
                if ($x['list_type'] == 1) { ?>
                <div class="form-group">
                  <label for="gamePurchaseDate">Purchase Date</label>
                  <div class='input-group date' id='datetimepicker4' data-plugin="datetimepicker" data-options="{ viewMode: 'years', format: 'MM/YYYY' }">
                          
                          <input type='text' id="gamePurchaseDate" name="purchaseDate" class="form-control simple-input" placeholder="Purchase Date"/>
                          <span class="input-group-addon bg-info text-white">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label for="gameCost">Cost</label>
                  <input type="text" name="cost" id="gameCost" class="form-control simple-input" placeholder="Cost" value="<?php echo htmlspecialchars($x['cost']); ?>">
                </div>
                
                
                
                <!--<div class="form-group">
                  <label for="gameCost">Picture</label>
                  <input type="file" class="form-control" name="picture" id="gamePicture">
                </div>-->
                

                <?php echo '<input type="hidden" name="game-id" value="'.$gameId.'">'; ?>
                <?php echo '<input type="hidden" name="list-type" value="'.$x['list_type'].'">'; ?>
                <?php echo '<input type="hidden" name="bgg-player-integration" value="'.$bggPlayerIntegration.'">'; ?>
              <?php echo '<input type="hidden" name="bgg-playtime-integration" value="'.$bggPlaytimeIntegration.'">'; ?>
              </div><!-- .modal-body -->
              <div class="modal-footer">
                <?php
                
                  echo '<a href="game_details.php?id='.$gameId.'"><button type="button" class="btn btn-danger">Cancel</button></a>';
              ?>
              
              <button type="submit" id="saveEditGame" class="btn btn-success">Save</button>
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
        <?php include("copywrite.php"); ?>
      </div>
    </footer>
  </div>
  <!-- /#app-footer -->
</main>
<!--========== END app main -->

                <script>
                var temp1 = "<?php echo htmlspecialchars($x['gameplay_knowledge']); ?>";
                var exists = $("#gameplayKnowledge option[value='"+temp1+"']").length !== 0;
                
                  if (exists) {
                    $(function(){
                        $("#gameplayKnowledge").val(temp1).attr('selected','selected');
                    });
                  }
                  else {
                    $(function(){
                      
                        $('#gameplayKnowledge').append($("<option value='oldCustom'>Custom Status</option>"));
                    
                        $("#gameplayKnowledge").val("oldCustom").attr('selected','selected');
                    });
                  }



                var temp2 = "<?php echo htmlspecialchars($x['type']); ?>";

                $(function(){
                    $("#gameType").val(temp2).attr('selected','selected');
                });

                var temp3 = "<?php echo htmlspecialchars($x['type2']); ?>";

                $(function(){
                    $("#gameType2").val(temp3).attr('selected','selected');
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