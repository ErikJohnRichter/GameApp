
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
  
<body class="theme-primary" style="padding-top: 5px;">

<!--============= start main area -->

<main id="app-main" class="app-main">
  <div class="wrap">
  <!-- CONTENT -->
  <section class="app-content">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <a href="welcome.html" style="color: silver;"><i class="fa fa-chevron-left fa-2x" style="padding-left: 15px;"></i></a>
        <div class="simple-page-logo text-center" style="padding-top: 30px;">
          <a href="index.php" style="font-size: 25px;">
            <span><i class="fa fa-gg"></i></span>
            <span>GameApp</span>
          </a>
        </div><!-- logo -->
        <br>
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
                <p>Ever wish you could catalogue your entire board game library? Ever wish you could reference that catalogue, easily, across all environments? Welcome to <a href="signup.php">GameApp</a>. Starting today you can finally get rid of that clunky notes list on your phone and start keeping real stats on your board games. With this tool, you can document every game you own or want to own, down to its smallest detail. Sure, you can add the game's name, but, with this app, you can also add:</p>
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
                -A wishlist of games you want or want to explore further
                <br>
                -Quickly share the titles on that wishlist with family members or friends for gift ideas
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
                As you can see, this app can do a lot! Use it to quickly and efficently organize, catalogue, and reference your entire board game library! <a href="signup.php">Sign up for free today!</a></p>

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
        </div>
        
    </div>
  </section><!-- .app-content -->
  <br><br>
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
  
</body>
</html>