<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 
          $query = " 
        SELECT * FROM users
        WHERE 
            id = :id
    "; 
     
    $query_params = array( 
        ':id' => $_SESSION['userid']
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
          $userEmail = $x['email'];
          $public = $x['public'];
          $publicLibrary = $x['library_public'];
          $subscription = $x['is_subscribed'];
          $searchFilterString = $x['custom_filter'];
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

    <a href="stats.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-toolbar navbar-toolbar-left navbar-left">
        
        <li>
          <h5 class="page-title hidden-menubar-top hidden-float">Settings</h5>
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
                  <a class="text-color" href="stats.php">
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
  <div class="wrap">
	<section class="app-content">
    <!--<h3 class="text-center" style="padding-bottom:20px;">User Settings</h3>-->

    <div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix text-center">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">Custom Game Status Category</h3>
    <small>This input allows you to assign a custom category to your Game Library's Game Status. It will appear in all Game Library game's status dropdowns on add/edit and will set the red Stats Dashboard button to automatically search for it in your Game Library.</small><br><br>
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
       $('#addCustomString').each(function(){
            if($(this).val().length < 2){
                 disable = true;      
            }
       });
  $('#setCustomString').prop('disabled', disable);
});
</script>
</div>   


    <div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix text-center">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">Wishlist Privacy</h3>
    <?php if($public != 1) { ?>
    <small>By default, your Wishlist is private. If you would like to share your Wishlist games with other users and on your Public Wishlist, simply turn on the following switch and click "Set" to make them public. When public, the titles and costs of your Wishlist games with the status of "Want" will be shared. </small><br><br>
    <?php } else { ?>
    <small>YOUR WISHLIST IS CURRENTLY PUBLIC.<br>To make it private again, turn off the following switch and click "Set."</small><br><br>
    <?php } ?>
    <div class="form-group" id="changeAdminCredentials">
    <form action="account_privacy.php" method="post">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td>
                <input id="accountPrivacy" type="checkbox" data-switchery="true" data-size="small" name="privacy" style="font-size: 16px; margin-right: 2px;" value=""<?php if ($public == 1) { echo "checked"; } ?>/>
                <label for="accountPrivacy" style="margin-left: 2px;">Public Wishlist</label>
            </td>
            
            <td><button id="changePrivacy" disabled type="submit" class="btn btn-success" style="margin-left: 70px;">Set</button></td>
            
        </tr>
    </tbody>
    </table>
    </form>
  </div>
  </div>

  
</div>   

<div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix text-center">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">Library Privacy</h3>
    
    <?php if($publicLibrary != 1) { ?>
    <small>By default, your Game Library is private. If you would like to share the titles in your Library with other users through the "Search Users" feature, turn on the following switch and click "Set" to make them public. When public, the game details of your Library games will be public, however, all notes, costs, and gameplay stats will remain private.</small><br><br>
    <?php } else { ?>
    <small>YOUR GAME LIBRARY IS CURRENTLY PUBLIC.<br>To make it private again, turn off the following switch and click "Set."</small><br><br>
    <?php } ?>

    <div class="form-group" id="changeAdminCredentials">
    <form action="library_privacy.php" method="post">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td>
                <input id="libraryPrivacy" type="checkbox" data-switchery="true" data-size="small" name="libraryprivacy" style="font-size: 16px; margin-right: 2px;" value=""<?php if ($publicLibrary == 1) { echo "checked"; } ?>/>
                <label for="libraryPrivacy" style="margin-left: 2px;">Public Library</label>
            </td>
            
            <td><button id="changeLibraryPrivacy" disabled type="submit" class="btn btn-success" style="margin-left: 80px;">Set</button></td>
            
        </tr>
    </tbody>
    </table>
    </form>
  </div>
  </div>
  
</div>   



<div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix text-center">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">Import BGG Collection</h3>
    <small>Use this tool to search for your BGG "Own" or "Wishlist" Collections. After returning results, you may import them into your Library or Wishlist.</small><br><br>
    <div class="form-group" id="bggUserSearch">
    <form action="bgg_user_collection.php" id="searchBGGUser" method="get">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr>
          <td>
            <div class="form-group" style="margin-bottom: 15px;">
                  <select class="form-control simple-input select-box" name="bgg-list" id="bggList">
                      <option disabled>Select Collection</option>
                      <option selected value="Own">Own</option>
                      <option value="Wishlist">Wishlist</option>
                    </select>
                </div>
          </td>
        </tr>
        <tr> 
            <td>
              <div class='input-group'>
              <input type="text" name="bgg-username" id="bggUser" class="form-control simple-input" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Search BGG User">
                  <span class="input-group-addon text-white bggSpan bggSpan1" style="background-color: white;">
                    <a href="#" onclick="document.getElementById('searchBGGUser').submit();"><span class="glyphicon glyphicon-search"></span></a>
                  </span>
                </div>
            </td>
        </tr>
    </tbody>
    </table>
    </form>
  </div>
  </div>
  
</div>   

<div class="col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix text-center">
    <h3 class="text-center" style="margin-top:8px; margin-bottom: 20px;">Email Subscription</h3>
    <?php if($subscription == 1) { ?>
    <small>YOU ARE SUBSCRIBED TO GAMEAPP EMAILS.<br>By default, your account is subscribed to account-related automated emails sent by GameApp. If you would like to unsubscribe from these, simply turn off the following switch and click "Set." This can be modified at any time. </small><br><br>
    <?php } else { ?>
    <small>YOU ARE UNSUBSCRIBED TO GAMEAPP EMAILS.<br>To resubscribe again, turn on the following switch and click "Set."</small><br><br>
    <?php } ?>
    <div class="form-group" id="changeAdminCredentials">
    <form action="subscription_update.php" method="post">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td>
                <input id="subscriptionSwitch" type="checkbox" data-switchery="true" data-size="small" name="subscription" style="font-size: 16px; margin-right: 2px;" value=""<?php if ($subscription == 1) { echo "checked"; } ?>/>
                <label for="subscriptionSwitch" style="margin-left: 2px;">Email Subscriptions</label>
            </td>
            
            <td>
              <input type="hidden" name="email" value="<?php echo $userEmail; ?>">
              <button id="changeSubscription" disabled type="submit" class="btn btn-success" style="margin-left: 30px;">Set</button>
            </td>
            
        </tr>
    </tbody>
    </table>
    </form>
  </div>
  </div>

</div>
   
    <div class="text-center col-md-4 col-md-offset-4">
      <div class="widget p-md clearfix">
    <h3 style="margin-top:8px;">Change Account Credentials</h3>
    <div class="form-group" id="changeAdminCredentials">
    <form action="change-admin-credentials.php" method="post">
    <table align="center" style="margin: 0 auto;">
        <tbody>
        <tr> 
            <td style="width: 100px;">
                <label for="changeAdminUsernameInput" style="font-size: 16px;">Username</label>
            </td>
            <td>
                <input disabled class="form-control simple-input" id="changeAdminUsernameInput" type="text" name="new-admin-username" style="font-size: 16px" placeholder="New Username" value="<?php echo $_SESSION['username']; ?>"/>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr> 
            <td style="width: 100px;">
                <label for="changeAdminEmailInput" style="font-size: 16px;">Email</label>
            </td>
            <td>
                <input class="form-control simple-input" id="changeAdminEmailInput" type="text" name="new-admin-email" style="font-size: 16px" placeholder="New Email" value="<?php echo $userEmail; ?>"/>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr> 
            <br>
            <td style="width: 100px;">
                <label for="changeAdminPasswordInput" style="font-size: 16px;">Password</label>
            </td>
            <td>
                <input class="form-control simple-input" id="changeAdminPasswordInput" type="password" name="new-admin-password" style="font-size: 16px" placeholder="Enter Password" value=""/>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr> 
            <br>
            <td style="width: 100px;">
                <label for="changeAdminPasswordInputConfirm" style="font-size: 16px;">Confirm</label>
            </td>
            <td>
                <input class="form-control simple-input" id="changeAdminPasswordInputConfirm" type="password" name="new-admin-password-confirm" style="font-size: 16px" placeholder="Confirm Password" value=""/>
            </td>
        </tr>
    </table>
        <table style="margin: 0 auto;">
        <tr>
            <td><br><button id="changeAdmin" type="submit" class="btn btn-info">Change</button></td>
            
        </tr>
    </tbody>
    </table>
    </form>
  </div>
  </div>
    <script>
  $('#changeAdmin').attr('disabled', true);
$('#changeAdminPasswordInput').keyup(function () {
   var disable = false;
       $('#changeAdminPasswordInput').each(function(){
            if($(this).val().length < 5){
                 disable = true;      
            }
       });
  $('#changeAdmin').prop('disabled', disable);
});
</script>
</div>   
<div class="col-md-12 clearfix"> </div>
	</section><!-- #dash-content -->
</div><!-- .wrap -->

  <!-- APP FOOTER -->
  <div class="col-md-12 p-t-0">
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
  $(document).ready(
    function(){

      var changeCheckbox = document.querySelector('#accountPrivacy');
  

    changeCheckbox.onchange = function() {
    $('#changePrivacy').attr('disabled',false);
  };
    
    });
  </script>

  <script>
  $(document).ready(
    function(){

      var changeCheckbox = document.querySelector('#libraryPrivacy');
  

    changeCheckbox.onchange = function() {
    $('#changeLibraryPrivacy').attr('disabled',false);
  };
    
    });
  </script>

  <script>
  $(document).ready(
    function(){

      var changeCheckbox = document.querySelector('#subscriptionSwitch');
  

    changeCheckbox.onchange = function() {
    $('#changeSubscription').attr('disabled',false);
  };
    
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