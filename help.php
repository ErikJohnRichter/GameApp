<?php
    require("common.php"); 
     
   
    if(empty($_SESSION['user'])) 
    { 
        
        header("Location: index.php"); 
         
        
        die("Redirecting to index.php"); 
    } 
$search = $_GET['search'];
    
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
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-96191447-1', 'auto');
  ga('send', 'pageview');

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

    <button type="button" class="navbar-toggle navbar-toggle-right collapsed">
      <span class="sr-only">Toggle navigation</span>
      <a href="create_game.php" style="color: #fff;"><span class="zmdi zmdi-hc-lg zmdi-plus"></span></a>
    </button>

    <a href="library.php" class="navbar-brand">
      <span class="brand-icon"><i class="fa fa-gg"></i></span>
      <span class="brand-name">GameApp</span>
    </a>
  </div><!-- .navbar-header -->
  
  <div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      

      <ul class="nav navbar-toolbar navbar-toolbar-right navbar-right">
        <li class="nav-item dropdown hidden-float">
          <a href="create_game.php">
            <i class="zmdi zmdi-hc-lg zmdi-plus"></i>
          </a>
        </li>

        <li class="dropdown">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-hc-lg zmdi-settings"></i></a>
          <ul class="dropdown-menu">
            <li><a href="logout.php"><i class="zmdi m-r-md zmdi-hc-lg zmdi-sign-in"></i>Logout</a></li>
          </ul>
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
  <div class="wrap">
  <!-- CONTENT -->
  <section class="app-content">
    <div class="row">
      <div class="col-md-2">
        <div class="panel-group" id="support-action-panel">

          <div class="app-actions-list scrollable-container">
            <!-- mail category list -->

            <hr class="m-0 m-b-md" style="border-color: #ddd;">
            <div class="list-group">
              <a href="mailto:help@codingerik.com?Subject=Sent%20from%20GameApp" class="list-group-item"><i class="fa m-r-sm fa-edit"></i>Submit bug or feature</a>
            </div><!-- .list-group -->
          </div><!-- .app-actions-list -->
        </div><!-- .app-action-panel -->
      </div><!-- END column -->

      <div class="col-md-10">
        <div class="panel-group accordion" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-1">
              <a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                <h4 class="panel-title">What is this?</h4>
                <i class="fa acc-switch"></i>
              </a>
            </div>
            <div id="collapse-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-1">
              <div class="panel-body">
                <p>Ever wish you could catalogue your entire board game library? Ever wish you could reference that catalogue, easily, across all environments? Welcome to GameApp. Starting today you can finally get rid of that clunky notes list on your phone and start keeping real stats on your board games. With this tool, you can document every game you own or want to own, down to its smallest detail. Sure, you can add the game's name, but, with this app, you can also add:</p>
                <br><p>
                -Your level of knowledge of the game
                <br>
                -Your rating for it
                <br>
                -The type of game it is
                <br>
                -How many players it requires
                <br>
                -How much it costs
                <br>
                -The date you acquired it
                <br>
                -Quick rules you can easily reference when playing
                <br>
                -Log gameplays, see how many times you played a game, when it was last played, and reference a log with notes for each time you played it
                <br>
                -Your thoughts on the game
                <br>
                -A wish list of games you want or want to explore further
                <br>
                -Quickly share the titles on that wish list with family members or friends for gift ideas
                <br>
                -See other GameApp users' Libraries and Wishlists
                <br>
                -Additionally, by independently integrating with BGG, this app automatically taps into their API to get additional content for your games such as the BGG rating, comments, pictures, reviews, and other fun game stats!</p>
                <br>
                -Also with this integration, search for any game ever made to see its stats or description and quickly add it to your library or wishlist.</p>
                <br>
                <p>Each parameter above, through the app, is fully searchable and sortable...
                <br><br>
                -Keep track of the games you need to brush up on and, when you do, record quick rules to make your next gameplay easier.
                <br>
                -Have house rules? Write 'em down so you remember next time.
                <br>
                -See the value of your library! Or, want to sell a game? First figure out how much you bought it for!
                <br>
                -How does your rating compare to those of the public?
                <br>
                -Having a party? Filter a list of Party games you own and quickly choose one.
                <br>
                -Keep a list of the games you would like to own and when you do, quickly import them to your library.
                <br>
                -Quickly record plays with notes and see what games you play the most and which you haven't played in a while.
                <br><br>
                As you can see, this app can do a lot! Use it to quickly and efficently organize, catalogue, and reference your entire board game library!</p>

              </div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-2">
              <a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                <h4 class="panel-title">Why use this rather than BGG?</h4>
                <i class="fa acc-switch"></i>
              </a>
            </div>
            <div id="collapse-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-2">
              <div class="panel-body">
               <p>If you are looking for full stats and histories and everything ever written on any given game, this app is probably not for you. But if you just need a tool to quickly reference your game library or wishlists, maintain them, save rules or thoughts on games, or log gameplays, you are in the right place.</p>
                <br>
                <p>BoardGameGeek is an amazing tool and I use it all the time. However, it has two large flaws that make me cringe whenever I use it…</p>
                <br>
                <p>First, there is just way too much "stuff" on any given page. It's cluttered. The site is great if I'm writing a research paper on the history of the game, but when I just need quick facts, it's not thrilling when I need to parse through globs of data for them. There is way too much going on.</p>
                <br>
                <p>Second, it's user-based-pages are not mobile friendly. They, simply, were not made to use on a phone…and when I'm at the board game store or sitting around the table with my family playing a game, all I have is my phone. So if I want to see my library or wishlist, or record a gameplay, on BGG I need to trudge through the ugly desktop version of the site on my small phone screen to use it. Not cool.</p>
                <br>
                <p>Another inspiration for this app comes from, when playing games, especially if there has been some time between playings, I may forget some of the important rules. With GameApp, users can quickly record and reference "Quick Rules" to eliminate the need to re-read the whole rulebook. With this, brushups on games become instantaneous and very simple!</p>
                <br>
                <p>This app is built independently of BGG with the added convenience of its integrations. As such, I don't want this to be an encyclopedia. I want it to be accessible and useful. This app has all the major tools you need from BGG but allows users to quickly access AND READ their info in ALL environments.</p>
              </div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-3">
              <a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                <h4 class="panel-title">How do I...?</h4>
                <i class="fa acc-switch"></i>
              </a>
            </div>
            <div id="collapse-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-3">
             <div class="panel-body">
              <p><b>Search for any game in the whole world</b><br>
                  -On the <a href="stats.php">Stats</a> page, find the search input and type in any game your heart desires. Use the results to quickly see its basic information or "Add to Library" or "Add to Wishlist."</p>
                  <br>
                <p><b>Search only for the games on my lists</b><br>
                  -On the <a href="stats.php">Stats</a> page, click the magnifying glass icon in the top navbar. A search input will appear. When you start typing a list of all games in your lists that match that string will appear.<br>
                  -Alternately, you may visit your Game Library or Wishlist and search the table directly. From here, you may search for any data field in your game.</p>
                  <br>
                <p><b>Hook up with BoardGameGeek?</b><br>
                  -On the <a href="stats.php">Stats</a> page, search BGG for the game you want to add to your Library or Wishlist. Once in that game's details, simply click "Add to Library" or "Add to Wishlist."<br>
                  -Importing your BGG collections into GameApp automatically integrates your games with BGG.
                  -If you manually add or edit a game, place the BGG Url (including https://) into the provided input and save. GameApp will do the rest. If you do not, readily, have the specific BGG URL for the game you're adding, by checking the "Auto-search BGG" box when adding a game, GameApp will automatically search BGG based on the name you enter. If no or multiple results are returned, no URL will be assigned. This feature is currently in beta.</p>
                  <br>
                <p><b>Import my existing BoardGameGeek Collection</b><br>
                  -In <a href="settings.php">Settings</a>, find "Import BGG Collection" and type in the name of the BGG user's collection you would like to import. Follow the instructions on the screen"<br>
                  <br>
                <p><b>Add a game without BoardGameGeek integrations</b><br>
                  -The great thing about GameApp is it works independently of BGG! At the top of any main page, click the "+" button. From here, fill in all of the game's details and press "Save."</p>
                  <br>
                <p><b>Change my game's details?</b><br>
                  -On the Game Details page, click on any of the data fields in the three primary boxes under the game name or on any of the details in the Info tab to edit them. If you have or add an associated BGG Url for a game, many fields will auto-generate. If you want to assign your own data to any given field, simply edit the field and save. Existing BGG data will remain in place along with your desired changes.</p>
                  <br>
                <p><b>Add game scoring logic?</b><br>
                  -When you add a game manually or edit its scoring data (either from Game Info or the Create a Gameplay page), you may select the mechanics of the game's scoring to "Highscore wins," "Lowscore wins," "No scoring," "Set-point-win," "Currency," or "Cooperative." Without being set, a game will default to "Highscore wins." This field will affect a game's best/worst score stats and how players are logged in gameplays.</p>
                  <br>
                <p><b>Log a gameplay?</b><br>
                  -When a game is in your Game Library, from the Game Details page, click "Log a Gameplay." Confirm the scoring logic is set appropriately, and then fill in the gameplay details.<br>
                  -You must log, at least, one player's name (if there are no players in the Player dropdown list, visit your <a href="profile.php">Profile</a> to add some). If you just log one player, that player will be considered the winner. If you select multiple players, all player names and scores must be logged. If this is the case, GameApp will automatically discover the winning and losing scores based on the game's scoring logic.</p>
                  <br>
                <p><b>Log a team win?</b><br>
                  -If you want to log a team win (rather than a single player win) in a gameplay, add the team "as a single player" to your Player List in your <a href="profile.php">Profile</a>. When you log your gameplay, select the team you added from the Player dropdown.</p>
                  <br>
                <p><b>Transfer a game from my wish list to my game library?</b><br>
                  -When you acquire a game on your wishlist, there is no need to re-enter everything in your library. Simply go to that game's details and click "Add to my library." This will transfer that game over to your Game Library and mark the game's status as "Need Rules" or "Great" depending on its data.</p>
                  <br>
                <p><b>Quickly see what games I need to brush up on?</b><br>
                  -In the <a href="stats.php">Stats</a> page, simply click the "Need Refresher" box to pull up a list of games you need a refresh on. You may also sort your library by "Status."</p>
                  <br>
                <p><b>Add custom rules?</b><br>
                  -In the Game Details page, select the "Rules" tab and click on the pencil icon inside of it.</p>
                  <br>
                <p><b>Add custom Game Status?</b><br>
                  -In <a href="settings.php">Settings</a>, the Custom Game Status input allows you to assign a custom category to your Game Library's Game Status. It will appear in all Game Library game's status dropdowns on add/edit and will set the red Stats Dashboard button to automatically search for it in your Game Library. Some good examples of a custom status would be "Need to Learn" or "Party Game."</p>
                  <br>
                <p><b>I have a game in my Wishlist that I don't want to delete but I don't want to keep it there either. What do I do?</b><br>
                  -Archive it! Simply click the edit pencil at the top of the Game Details page and press the "Archive" button. To re-add these archived games or delete them, access your Archive List in your profile.</p>
                  <br>
                <p><b>My Public Wishlist details are not showing. Why?</b><br>
                  -By default, your Wishlist is private. If you would like others to see the titles on your Wishlist with the Status: "Want," visit your <a href="settings.php">Settings</a> and flip the switch to make them public.</p>
                  <br>
                <p><b>Let other users see my Game Library and Wishlist</b><br>
                  -By default, your Game Library and Wishlists are private. If you would like others to see these, visit your <a href="settings.php">Settings</a> and flip the switchs to make either or both public.</p>
                  <br>
              </div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-4">
              <a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                <h4 class="panel-title">What if BGG stopped it's API?</h4>
                <i class="fa acc-switch"></i>
              </a>
            </div>
            <div id="collapse-4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-4">
              <div class="panel-body">
                <p>Great question! Simple answer, nothing. This app was originally built as an independent service to that of BoardGameGeek. So if their API went down tomorrow, all of your library and wishlist games would remain as you left them and still be fully editable.</p>
                <br>
                <p>Longer answer: Any new games you add to your library or wishlist would have to be, exclusively, added manually by pressing the "+" button and would not receive new BGG details. Additionally, existing game's BGG details would remain as they were prior to the API going offline but could not get updated.</p>
              </div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-5">
              <a class="accordion-toggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                <h4 class="panel-title">Misc items and future features</h4>
                <i class="fa acc-switch"></i>
              </a>
            </div>
            <div id="collapse-5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-5">
              <div class="panel-body">
                <p>State is saved on the library table for 6 seconds. I did this so a user could return to the library, after quickly viewing game details, and have its settings as they were before leaving and not reset to default. Why 6? Because I felt 7 was too long and 5 was too short. This was a UX decision, but will cause an issue if a user uses a stat's library link before the 6 second gap is up (a filtered link will return the user to the library as it was when previously left if 6 seconds has not elapsed since).</p><br>
                <p>Upcoming Features:
                  <br>
                -Automatically get game prices and set them (while remaining editable).<br>
                -Sync BGG gameplays with GameApp.<br>
                -Various performance improvements.</p>
                
              </div>
            </div>
          </div>
        </div>

        
    </div>
  </section><!-- .app-content -->
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
  
</body>
</html>