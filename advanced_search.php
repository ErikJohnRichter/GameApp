<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 

    $listType = $_GET['list'];

    $query = " 

          SELECT *, COUNT(play_with)
          FROM game_details WHERE play_with IS NOT null AND user_id=:userid
          GROUP BY play_with ORDER BY COUNT(play_with) desc, play_with asc 
          
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
      $rowz = $stmt->fetchAll();

      $query = " 

          SELECT *, COUNT(publisher)
          FROM game_details WHERE publisher IS NOT null AND user_id=:userid
          GROUP BY publisher ORDER BY publisher asc, COUNT(publisher) desc 
          
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
      $rowzzs = $stmt->fetchAll();
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
          <h5 class="page-title hidden-menubar-top hidden-float">Advanced Search</h5>
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
            <h3 class="widget-title text-center">Advanced Search</h3>
          </header>          
          <!-- Ajax dataTable -->
          <div class="widget-body">
            <form action="advanced_search_results.php" id="addGameForm" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-group">
                  <input type="text" name="name" id="gameName" class="form-control validateGame simple-input" placeholder="Name">
                </div>
                
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="type" id="gameType">
                      <option selected value="">Type</option>
                      <?php include("game_types.php"); ?>
                    </select>
                </div>
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="ratingOperator" style="display: inline-block; width: 19%;">
                    <option disabled>Operand</option>
                    <option value="equal">&#61;</option>
                    <option value="less">&le;</option>
                    <option value="greater" selected>&ge;</option>
                  </select>
                  <input type="text" name="rating" id="gameRating" class="form-control validateGame simple-input" placeholder="My Rating" style="display: inline-block; width: 79%; float: right;">
                </div>
                
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="minPlayerOperator" style="display: inline-block; width: 19%;">
                    <option disabled>Operand</option>
                    <option value="equal" selected>&#61;</option>
                    <option value="less">&le;</option>
                    <option value="greater">&ge;</option>
                  </select>
                  <input type="text" name="minPlayers" id="gameMinPlayers" class="form-control validateGame simple-input" placeholder="Min Players" style="display: inline-block; width: 79%; float: right;">
                </div>
                
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="maxPlayerOperator" style="display: inline-block; width: 19%;">
                    <option disabled>Operand</option>
                    <option value="equal" selected>&#61;</option>
                    <option value="less">&le;</option>
                    <option value="greater">&ge;</option>
                  </select>
                  <input type="text" name="maxPlayers" id="gameMaxPlayers" class="form-control validateGame simple-input" placeholder="Max Players" style="display: inline-block; width: 79%; float: right;">
                </div>
                
                <div class="form-group">
                  <select class="form-control simple-input select-box" name="timeOperator" style="display: inline-block; width: 19%;">
                    <option disabled>Operand</option>
                    <option value="equal">&#61;</option>
                    <option value="less" selected>&le;</option>
                    <option value="greater">&ge;</option>
                  </select>
                  <input type="text" name="time" id="gameTime" class="form-control validateGame simple-input" placeholder="Time" style="display: inline-block; width: 79%; float: right;">
                </div>

                <div class="form-group">
                  <select class="form-control simple-input select-box" name="weightOperator" style="display: inline-block; width: 19%;">
                    <option disabled>Operand</option>
                    <option value="equal">&#61;</option>
                    <option value="less" selected>&le;</option>
                    <option value="greater">&ge;</option>
                  </select>
                  <input type="text" name="weight" id="gameWeight" class="form-control validateGame simple-input" placeholder="Weight" style="display: inline-block; width: 79%; float: right;">
                </div>

                <div class="form-group">
                  <select class="form-control simple-input select-box" name="costOperator" style="display: inline-block; width: 19%;">
                    <option disabled>Operand</option>
                    <option value="equal">&#61;</option>
                    <option value="less" selected>&le;</option>
                    <option value="greater">&ge;</option>
                  </select>
                  <input type="text" name="cost" id="gameCost" class="form-control validateGame simple-input" placeholder="Cost" style="display: inline-block; width: 79%; float: right;">
                </div>

                <div class="form-group">
                  <select class="form-control simple-input select-box" name="publisher">
                  <?php 
                    if ($rowzzs) {
                      echo '<option selected value="">Publisher</option>';
                      foreach ($rowzzs as $q) {
                        if ($q['publisher'] != "") {
                          echo '<option value="'.$q['publisher'].'">'.$q['publisher'].'</option>';
                        }
                      }
                    }
                    else {
                      echo '<option selected disabled value="">Publisher</option>
                            <option disabled>None</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <select class="form-control simple-input select-box" name="playWith">
                  <?php 
                    if ($rowz) {
                      echo '<option selected value="">Play With</option>';
                      foreach ($rowz as $p) {
                        if ($p['play_with'] != "") {
                          echo '<option value="'.$p['play_with'].'">'.$p['play_with'].'</option>';
                        }
                      }
                    }
                    else {
                      echo '<option selected disabled value="">Play With</option>
                            <option disabled>None</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <select class="form-control simple-input select-box" name="scoring" id="gameHighscore">
                      <option selected value="">Scoring</option>
                      <option value="desc">Highest Score Wins</option>
                      <option value="asc">Lowest Score Wins</option>
                      <option value="coop">Cooperative</option>
                      <option value="set">Flat-Point Win</option>
                      <option value="money">Currency</option>
                      <option value="other">No Points Awarded</option>
                    </select>
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
                  <select class="form-control simple-input select-box" name="status" id="gameplayKnowledge">
                      <option selected value="">Status</option>
                      <option value="Great">Great</option>
                      <option value="Favorites">Favorites</option>
                      <option value="Need Rules">Need Rules</option>
                      <option value="Need Refresher">Need Refresher</option>
                      <?php $customSearchString = $_SESSION['customfilter']; if($customSearchString != null) { echo '<option value="'.$customSearchString.'">'.$customSearchString.'</option>'; } ?>
                    </select>
                </div>

              </div><!-- .modal-body -->
              <div class="modal-footer">
                <?php 
                
                  echo '<a href="library.php"><button type="button" class="btn btn-danger">Cancel</button></a>';
                
                
                ?>
              <button type="submit" id="saveEditGame" class="btn btn-success">Search</button>
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