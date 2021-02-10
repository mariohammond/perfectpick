<?php ?>
<!DOCTYPE html>
<html>
<head>
	<title>How To Play | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
    <link rel="stylesheet" href="js/liquid-slider/css/liquid-slider.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
    <script src="js/liquid-slider/js/jquery.liquid-slider.min.js"></script>
</head>
<body>
	<div class="HowToPlayWrapper">
		<?php include 'menu.php'; ?>
        <?php include 'header.php'; ?>
        <div class="TutorialContainer Main">
            <div class="cover-container"></div>
            <div id="main-slider" class="liquid-slider" style="display: none;">
                <div>
                  <h2 class="title">BUILD YOUR PROFILE</h2>
                  <img src="images/beta-profile.jpg"/>
                  <p>Create your Pick'em Profile by providing an email address or simply connecting with your Facebook, Twitter, or Google+ account.</p>
                </div>
                <div>
                  <h2 class="title">CHOOSE YOUR MATCH</h2>
                  <img src="images/beta-matches.jpg"/>
                  <p>Pick a match to join on the Find Match page. You can filter matches by sport or game type (single game, series of games, or season-long).</p>
                </div>          
                <div>
                  <h2 class="title">MAKE YOUR PICKS</h2>
                  <img src="images/beta-picks.jpg"/>
                  <p>Enter your picks and predictions for the selected match. Picks can be changed until registration is closed.</p>
                </div>
                <div>
                  <h2 class="title">CHECK STANDINGS</h2>
                  <img src="images/beta-standings.jpg"/>
                  <p>Track your progress against other players during the match. Scores are updated in real time.</p>
                </div>
                <div>
                  <h2 class="title">EARN ACHIEVEMENTS</h2>
                  <img src="images/beta-achievements.jpg"/>
                  <p>After matches are completed, take a look at the achievements you've earned. Play more matches, earn more badges, take over the world.</p><a href="/profile" data-category="pp_how_to" data-action="how_to_link" data-label="profile"><p class="get-started">GET STARTED NOW!</p></a>
                </div>
              </div>
        </div>
        <?php include 'footer.php'; ?>
        <script>
    		$("#main-slider").liquidSlider({
				hoverArrows: false,
				hideSideArrows: true,
				mobileNavigation: false,
				hideArrowsWhenMobile: false,
				dynamicTabs: false,
				preloader: true,
			});
			
			$container = $(".liquid-slider").css("width");
			$imageWidth = parseInt($container.substring(0, 3)) - 70;
			$(".panel-container img").css("width", $imageWidth);
			$(".liquid-slider").show();
 	 	</script>
    </div>
    <span class="wideCheck"></span><span class="desktopCheck"></span><span class="tabletCheck"></span><span class="mobileCheck"></span>
</body>
