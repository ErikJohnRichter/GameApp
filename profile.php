<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 
$search = $_GET['search'];

$query = " 
        SELECT * FROM users 
        WHERE 
            id = :userid
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
    if ($rows) {
        foreach ($rows as $x) {
          $userFirstName = $x['first'];
          $userLastName = $x['last'];
          $searchFilterString = $x['custom_filter'];
        }
    }

    $query = " 
        SELECT * FROM rating_scale 
        WHERE 
            user_id = :userid
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
  <script src="libs/bower/jquery/dist/jquery.js"></script>
  <script src="libs/bower/jquery-ui/jquery-ui.min.js"></script>
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
          <h5 class="page-title hidden-menubar-top hidden-float">User Profile</h5>
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
      <!--<h3 class="text-center" style="padding-bottom:20px;">User Profile</h3>-->

    <div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">My Photo</h3>
    <div class="form-group" id="changeAdminCredentials">
    <form action="add_photo.php" method="post" enctype="multipart/form-data">
    <table align="center" style="margin: 0 auto;">
        <tbody>
          <tr>
            <td style="padding-right: 40px;">&nbsp;</td>
            <td><?php echo '<img src="assets/images/'.$_SESSION['picture'].'" alt="avatar" style="max-width: 50px; margin: 0 auto;"/>'; ?></td>
            <td>Current photo</td>
            <td>&nbsp;</td>
          </tr>
          <tr><td colspan="4"><hr></td></tr>
        <tr> 
            <td colspan="3">
                <input type="file" name="photo" id="fileSelect" style="width: 200px;">
            </td>
        
            <td><button id="addPhoto" disabled type="submit" class="btn btn-success" style="margin-left: 10px;">Add</button></td>
            
        </tr>
    </tbody>
    </table>
    </form>
  </div>
  </div>
</div>   

    <div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">My Name</h3>
    <div class="form-group" id="changeAdminCredentials">
    <form action="add_name.php" method="post">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td>
                <input class="form-control simple-input" id="addFirstName" type="text" name="first" style="font-size: 16px; margin-bottom:20px;" placeholder="First Name" value="<?php echo $userFirstName; ?>"/>
                <br>
                <input class="form-control simple-input" id="addLastName" type="text" name="last" style="font-size: 16px" placeholder="Last Name" value="<?php echo $userLastName; ?>"/>
            </td>
        
            <td><button id="addName" type="submit" class="btn btn-success" style="margin-left: 10px;">Set</button></td>
            
        </tr>
    </tbody>
    </table>
    </form>
  </div>
  </div>
  <script>
  $('#addName').attr('disabled', true);
$('#addFirstName').keyup(function () {
   var disable = false;
       $('#addFirstName').each(function(){
            if($(this).val().length < 2){
                 disable = true;      
            }
       });
  $('#addName').prop('disabled', disable);
});
</script>
</div>   


    <div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">My Players</h3>
    <div class="form-group" id="changeAdminCredentials">
    <form action="add_player.php" method="post">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td>
                <input class="form-control simple-input" id="addPlayerInput" type="text" name="player" style="font-size: 16px" placeholder="Type Player Name"/>
            </td>
        
            <td><button id="addPlayer" type="submit" class="btn btn-success" style="margin-left: 10px;">Add</button></td>
            
        </tr>
    </tbody>
    </table>
    </form>
    <br>
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td>
    <select class="form-control simple-input select-box" name="players" id="userPlayers" style="font-size: 16px; width: 240px;">
      <option selected value="">Current Players</option>
      <?php
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
        if ($rows) {
            foreach ($rows as $x) {
                echo '<option value="'.$x['id'].'">'.$x['player'].'</option>';
                
            }
        }
        else {
          echo '<option disabled>None added yet.</option>';
        }
      ?>
    </select>
  </td>
  <td>
    <?php echo '<a id="deleteButton"><button id="deletePlayer" class="btn btn-danger" style="margin-left: 10px; margin-right: 14px;"><i class="fa fa-times" aria-hidden="true"></i></button></a>'; ?>
    </td>
            
        </tr>
    </tbody>
    </table>
  </div>
  </div>
    <script>
  $('#addPlayer').attr('disabled', true);
$('#addPlayerInput').keyup(function () {
   var disable = false;
       $('#addPlayerInput').each(function(){
            if($(this).val().length < 2){
                 disable = true;      
            }
       });
  $('#addPlayer').prop('disabled', disable);
});
</script>

<script>
  $('#deletePlayer').attr('disabled', true);
$("#userPlayers").change (function() {
  var disable = false;
    $("#deleteButton").attr("href", "delete_player.php?id=" + $(this).val());
    if($(this).val().length < 1){
                 disable = true;      
            }
            else {
              disable = false; 
            }

  $('#deletePlayer').prop('disabled', disable);
});
</script>
</div>   



<div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">My Custom Types</h3>
    <div class="form-group" id="changeCustomType">
    <form action="add_custom_type.php" method="post">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td>
                <input class="form-control simple-input" id="addTypeInput" type="text" name="type" style="font-size: 16px" placeholder="Custom Game Type"/>
            </td>
        
            <td><button id="addType" type="submit" class="btn btn-success" style="margin-left: 10px;">Add</button></td>
            
        </tr>
    </tbody>
    </table>
    </form>
    <br>
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td>
    <select class="form-control simple-input select-box" name="types" id="userTypes" style="font-size: 16px; width: 240px;">
      <option selected value="">Custom Types</option>
      <?php
        $query = " 
        SELECT * FROM custom_types 
        WHERE 
            user_id = :userid
            ORDER BY type asc
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
        if ($rows) {
            foreach ($rows as $x) {
                echo '<option value="'.$x['id'].'">'.$x['type'].'</option>';
                
            }
        }
        else {
          echo '<option disabled>None added yet.</option>';
        }
      ?>
    </select>
  </td>
  <td>
    <?php echo '<a id="deleteTypesButton"><button id="deleteType" class="btn btn-danger" style="margin-left: 10px; margin-right: 14px;"><i class="fa fa-times" aria-hidden="true"></i></button></a>'; ?>
    </td>
            
        </tr>
    </tbody>
    </table>
  </div>
  </div>
    <script>
  $('#addType').attr('disabled', true);
$('#addTypeInput').keyup(function () {
   var disable = false;
       $('#addTypeInput').each(function(){
            if($(this).val().length < 2){
                 disable = true;      
            }
       });
  $('#addType').prop('disabled', disable);
});
</script>

<script>
  $('#deleteType').attr('disabled', true);
$("#userTypes").change (function() {
  var disable = false;
    $("#deleteTypesButton").attr("href", "delete_custom_type.php?id=" + $(this).val());
    if($(this).val().length < 1){
                 disable = true;      
            }
            else {
              disable = false; 
            }

  $('#deleteType').prop('disabled', disable);
});
</script>
</div>   


<div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix text-center">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">Custom Game Status</h3>
    <small>Create a custom status for your Game Library's game statuses. Adding this will also set the red Stats Dashboard button to automatically search for this word in your Game Library's game statuses and/or notes.</small><br><br>
    <div class="form-group" id="changeAdminCredentials">
    <form action="add_custom_filter.php" method="post">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td>
                <input class="form-control simple-input" id="addCustomString" type="text" name="custom-string" style="font-size: 16px;" placeholder="Custom Filter Word" value="<?php echo $searchFilterString; ?>"/>
            </td>
        
            <td><button id="setCustomString" type="submit" class="btn btn-success" style="margin-left: 10px;">Set</button></td>
            
        </tr>
    </tbody>
    </table>
    </form>
  </div>
  </div>
  <script>
  $('#setCustomString').attr('disabled', true);
$('#addCustomString').keyup(function () {
   var disable = false;
       /*$('#addCustomString').each(function(){
            if($(this).val().length == 0){
                 disable = true;      
            }
       });*/
  $('#setCustomString').prop('disabled', disable);
});
</script>
</div>   




<div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 40px;">My Rating Definitions</h3>
    <div class="col-xs-12" style="margin: 0 auto;">
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
        <div class="col-xs-1" style="margin-bottom: 40px;"><b>1</b></div><div class="col-xs-10" style="margin-bottom: 40px;"><?php echo $one; ?></div>
        <div class="clearfix"></div>
        <?php } ?>
        <div class="col-xs-12 text-center" style="margin-bottom: 15px;"><a href="edit_rating_scale.php"><button id="addName" class="btn btn-success">Set Rating Definitions</button></a></div>
    </div>
  </div>
</div>   


<div class="col-md-12 clearfix"> </div>
  </section><!-- #dash-content -->
</div><!-- .wrap -->

  <!-- APP FOOTER -->
  <div class="col-md-12 p-t-0">
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
  $(document).ready(
    function(){
    $('#fileSelect').change(
        function(){
            if ($(this).val()) {
                $('#addPhoto').attr('disabled',false);
                // or, as has been pointed out elsewhere:
                // $('input:submit').removeAttr('disabled'); 
            } 
        }
        );
    });
  </script>
 
  <script>
  function clear_search() {
    var table = $('#library').DataTable();
    table.search('').draw();
  }
  </script>
  
</body>
</html>