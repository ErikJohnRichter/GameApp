<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

    $listType = $_GET['list'];

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
          <h5 class="page-title hidden-menubar-top hidden-float">Add Game</h5>
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
    <div class="row" id="gameList">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="widget row no-gutter p-lg">  
        <header class="widget-header game-list">
            <h3 class="widget-title text-center">Add Game</h3>
          </header>          
          <!-- Ajax dataTable -->
          <div class="widget-body">
            <form onsubmit="return validateAddGameForm()" action="add_game.php" id="addGameForm" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-group">
                  <input type="text" name="name" id="gameName" class="form-control validateGame simple-input" placeholder="Name">
                </div>
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="list-type" id="gameListType">
                      <option selected disabled>Game List</option>
                      <option value="1">Game Library</option>
                      <option value="2">Wish List</option>
                    </select>
                </div>
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="status" id="gameStatus">
                      <option selected disabled>Status</option>
                      <option value="Want">Want</option>
                      <option value="Research">Research</option>
                      <option value="Preorder">Preorder</option>
                      <option value="Bought">Bought</option>
                      <option value="Own">Own</option>
                      <option value="">None</option>
                    </select>
                </div>
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="knowledge" id="gameplayKnowledge">
                      <option selected disabled>Status</option>
                      <option value="Great">Great</option>
                      <option value="Favorites">Favorites</option>
                      <option value="Need Rules">Need Rules</option>
                      <option value="Need Refresher">Need Refresher</option>
                      <?php $customSearchString = $_SESSION['customfilter']; if($customSearchString != null) { echo '<option value="'.$customSearchString.'">'.$customSearchString.'</option>'; } ?>
                    </select>
                </div>
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="rating" id="gameRating">
                      <option selected disabled>Rating</option>
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
                      <option value="">None</option>
                    </select>
                </div>
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="type" id="gameType">
                      <option selected disabled>Primary Type</option>
                      <?php include("game_types.php"); ?>
                      <option value="">None</option>
                    </select>
                </div>
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="type2" id="gameType2">
                      <option selected disabled>Secondary Type</option>
                      <?php include("game_types.php"); ?>
                      <option value="">None</option>
                    </select>
                </div>
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="minPlayers" id="gameMinPlayers" style="display: inline-block; width: 49%;">
                      <option selected disabled>Min Players</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
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
                    </select>
                </div>
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="highscore" id="gameHighscore">
                      <option selected disabled>Scoring</option>
                      <option value="desc">Highest Score Wins</option>
                      <option value="asc">Lowest Score Wins</option>
                      <option value="coop">Cooperative</option>
                      <option value="set">Flat-Point Win</option>
                      <option value="money">Currency</option>
                      <option value="other">No Points Awarded</option>
                    </select>
                </div>
                <div class="form-group">
                  <input type="text" name="cost" id="gameCost" class="form-control simple-input" placeholder="Cost">
                </div>
                <div class="form-group">
                  <input type="text" name="publisher" id="gamePublisher" class="form-control simple-input" placeholder="Publisher">
                </div>
                <!--<div class="form-group">
                  <input type="file" class="form-control" name="picture" id="gamePicture">
                </div>-->
                <div class="form-group">
                  <input type="checkbox" name="searchBgg" id="gameSearchBgg" style="margin-left: 2px;" checked/>
                  <label for="gameSearchBgg" style="margin-left: 2px;">Auto-search BGG&nbsp;
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#addAutoBggHelp" aria-expanded="false" style="color: grey;">
                    <i class="zmdi zmdi-hc-sm zmdi-help-outline"></i>
                   </a>
                  </label>
                </div>
                <div class="form-group">
                  <div class='input-group date'>
                  <input type="text" name="bggUrl" id="gameBggUrl" class="form-control simple-input" placeholder="BoardGameGeek URL">
                  <span class="input-group-addon text-white" style="background-color: white;">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#addBggUrlHelp" aria-expanded="false" style="color: grey;">
                    <span class="glyphicon glyphicon-question-sign"></span>
                   </a>
                          </span>
                        </div>
                  
                </div>
                <div class="form-group">
                  <div class='input-group date' id='datetimepicker4' data-plugin="datetimepicker" data-options="{ viewMode: 'years', format: 'MM/YYYY' }">
                          
                          <input type='text' id="gamePurchaseDate" name="purchaseDate" class="form-control simple-input" placeholder="Purchase Date"/>
                          <span class="input-group-addon bg-info text-white">
                            <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                </div>
                <div class="form-group">
                  <input type="text" name="rules" id="gameRules" class="form-control simple-input" placeholder="Game Rules URL">
                </div>
                <!--<div class="form-group">
                  <textarea type="text" rows="4" name="rulesNotes" id="gameRulesNotes" class="form-control" placeholder="Notes on rules"></textarea>
                </div>-->
                 <div class="form-group">
                  <label for="summernote">Notes</label>
                        <textarea class="m-0 summernote" name="notes" id="summernote" data-plugin="summernote"
                        data-options="{height: 250, toolbar: [
                                    ['style', ['style']],
                                    ['link', ['link']],
                                    ['fullscreen', ['fullscreen']]
                                  ], styleTags: ['p']}" 
                        placeholder="Game Notes"></textarea>
                </div>
              </div><!-- .modal-body -->
              <div class="modal-footer">
                <?php 
                if ($listType == 1) {
                  echo '<a href="library.php"><button type="button" class="btn btn-danger">Cancel</button></a>';
                }
                else {
                  echo '<a href="wish_list.php"><button type="button" class="btn btn-danger">Cancel</button></a>';
                }
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

  <!-- add help -->
  <div id="addAutoBggHelp" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Auto Search BGG (beta)</h4>
        </div>
        <div class="modal-body">
          <p>If you do not, readily, have the specific BGG URL for the game you're adding, by checking this box, GameApp will automatically search for the game's BGG URL based on the name you enter. If multiple results are returned, no URL will be assigned.</p>
          <p>You may always edit the game details and add a BGG URL at a future date.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  <div id="addBggUrlHelp" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add BGG URL</h4>
        </div>
        <div class="modal-body">
          <p>By entering the specific BGG Game URL for this game (including https://), GameApp will automatically get specific details from BGG including:</p>
          <p>-Game picture<br>
            -BGG Rating<br>
            -Number of players<br>
            -Game description<br>
            -Play time<br>
            -Game weight<br>
            -Publisher<br>
            -Published year<br></p>
          <p>You may always add or edit the BGG URL at a future date.</p>
          <p>To integrate with BGG without needing to enter the game URL, simply add games by searching for them in the BGG search bar on your stats page</p>
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
      var temp10 = "<?php echo htmlspecialchars($listType); ?>";

      $(function(){
          $("#gameListType").val(temp10).attr('selected','selected');
      });
  </script>
  <script>
      function validateAddGameForm() {
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
          $('#saveEditGame').val('Adding...');
        }
        return isValid;
      }
  </script>
  <script>
  
$(document).ready( function() {
    if ($('#gameListType').val() == '1') {
        $('#gameplayKnowledge').show();
      $('#gameStatus').hide();
    }
    else if ($('#gameListType').val() == '2') {
      $('#gameplayKnowledge').hide();
      $('#gameStatus').show();
    } // hide div if value is not "custom"
});
  
  $(document).ready( function() {
  $('#gameListType').bind('change', function (e) { 
    if( $('#gameListType').val() == 1) {
      $('#gameplayKnowledge').show();
      $('#gameStatus').hide();
    }
    else if ( $('#gameListType').val() == 2){
      $('#gameplayKnowledge').hide();
      $('#gameStatus').show();

    }         
  });
});
  </script>

</body>
</html>