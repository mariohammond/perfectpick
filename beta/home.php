<?php
	include_once 'util/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfect Pick'em</title>
	<link rel="icon" type="image/png" href="images/favicon.png" />
	
	<!-- JQuery: Start -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<!-- JQuery: End -->
	
	<!-- Leaderboard Tabs: Start -->
	<script>
	$(document).ready(function(){
		$('ul.LeaderboardTabs').each(function(){
			// For each set of tabs, we want to keep track of which tab is active and it's associated content
			var $active, $content, $links = $(this).find('a');

			// If the location.hash matches one of the links, use that as the active tab.
			$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
			$active.addClass('active');
			$content = $($active[0].hash);

			// Hide the remaining content
			$links.not($active).each(function () {
				$(this.hash).hide();
			});

			// Bind the click event handler
			$(this).on('click', 'a', function(e){
				// Make the old tab inactive.
				$active.removeClass('active');
				$content.hide();

				// Update the variables with the new link and content
				$active = $(this);
				$content = $(this.hash);

				// Make the tab active.
				$active.addClass('active');
				$content.show();

				// Prevent the anchor's default click action
				e.preventDefault();
			});
		});
	});
	</script>
	<!-- Leaderboard Tabs: End -->
	
	<script>
	$(document).ready(function(){
		var displayTime = 5000, transitionTime = 1000;
		var currIdx = 0;
		var $slides = $('#UpcomingContainer div');
		
		function animateBG() {
			currIdx = (currIdx < 3) ? currIdx + 1 : 0;
			setTimeout(function() {
				$slides.css('z-index', 1).fadeOut();
				$slides.eq(currIdx).css('z-index', 2).fadeIn(transitionTime, function() {
					$slides.not(this).hide();
					animateBG();
				});
			}, displayTime)
		
		}
		animateBG();
	});
	</script>
  
	<!-- CSS: Start -->
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/main.css" />
	<!-- CSS: End -->
</head>
<body>
	<?php include 'header.php'; ?>
	<div id="UpcomingContainer">
		<div>
			<label class="upcomingContent">Upcoming Match: NFL Season Predictions</label>
		</div>
		<div>
			<label class="upcomingContent">Upcoming Match: Packers vs Chargers</label>
		</div>
		<div>
			<label class="upcomingContent">Upcoming Match: NFL Week 1 Predictions</label>
		</div>
		<div>
			<label class="upcomingContent">Upcoming Match: Seahawks vs Broncos</label>
		</div>    
	</div>
	<div id="HomeContainer">
		<div id="LeaderboardContainer">
			<div id="LeaderboardTitle">
				<label class="tabTitle">CURRENT LEADERBOARD</label>
			</div>
			<ul class='LeaderboardTabs'>
				<li><a href='#tab1'>This Week</a></li>
				<li><a href='#tab2'>This Month</a></li>
				<li><a href='#tab3'>All-Time</a></li>
			</ul>
			<div id='tab1'>
				<a href="dashboard.php?id=77"><label class="tabContent">1. Mario Hammond - 131</label></a><br/>
				<label class="tabContent">2. Mark Hammond - 130</label><br/>
				<label class="tabContent">3. Rashad Hammond - 126</label><br/>
				<label class="tabContent">4. Ryan Hammond - 122</label><br/>
				<label class="tabContent">5. Kendrick Mitchell - 120</label><br/>
				<label class="tabContent">6. Mario Hammond - 131</label><br/>
				<label class="tabContent">7. Mark Hammond - 130</label><br/>
				<label class="tabContent">8. Rashad Hammond - 126</label><br/>
				<label class="tabContent">9. Ryan Hammond - 122</label><br/>
				<label class="tabContent">10. Kendrick Mitchell - 120</label><br/>
				<label class="tabContent">11. Mario Hammond - 131</label><br/>
				<label class="tabContent">12. Mark Hammond - 130</label><br/>
				<label class="tabContent">13. Rashad Hammond - 126</label><br/>
				<label class="tabContent">14. Ryan Hammond - 122</label><br/>
				<label class="tabContent">15. Kendrick Mitchell - 120</label><br/>
				<label class="tabContent">16. Mario Hammond - 131</label><br/>
				<label class="tabContent">17. Mark Hammond - 130</label><br/>
				<label class="tabContent">18. Rashad Hammond - 126</label><br/>
				<label class="tabContent">19. Ryan Hammond - 122</label><br/>
				<label class="tabContent">20. Kendrick Mitchell - 120</label><br/>
			</div>
			<div id='tab2'>
				<label class="tabContent">Hi, this is the month tab.</label>
			</div>
			<div id='tab3'>
				<label class="tabContent">Hi, this is the all-time tab.</label>
			</div>
		</div>
		<div id="SocialContainer">
			<div id="VideoContainer">
				<iframe width="100%" height="400" src="//www.youtube.com/embed/CeYmRC0hFJc" frameborder="0" allowfullscreen="true"></iframe>
			</div>
			<div id="ConnectContainer">
				<label class="connectTitle">Connect with us!</label><br/>
				<img src="images/social_links.png" usemap="#ImageMap">
				<map id="ImageMap" name="ImageMap">
					<area shape="rect" coords="1,0,35,50" href="https://www.facebook.com/pages/Perfect-Pickem/324372977710787" target="_blank">
					<area shape="rect" coords="42,1,102,49" href="https://twitter.com/PerfectPickem" target="_blank">
					<area shape="rect" coords="112,0,158,50" href="http://www.youtube.com" target="_blank">
				</map>
			</div>
		</div>
		<div id="LatestContainer">
			<div id="LatestTitle">
				<label class="latestTitle">LATEST RESULTS</label>
			</div>
			<div id="LatestContent">
				<label class="latestContent">Ravens vs Steelers</label><br/>
				<label class="latestContent">September 2, 2015</label><br/>
				<label class="latestContent">Winner: Zipporah Hammond</label><br/><br/>
				<label class="latestContent">Knicks vs Heat</label><br/>
				<label class="latestContent">October 2, 2015</label><br/>
				<label class="latestContent">Winner: Kirstin Mitchell</label><br/><br/>
				<label class="latestContent">Ravens vs Steelers</label><br/>
				<label class="latestContent">September 2, 2015</label><br/>
				<label class="latestContent">Winner: Zipporah Hammond</label><br/><br/>
				<label class="latestContent">Knicks vs Heat</label><br/>
				<label class="latestContent">October 2, 2015</label><br/>
				<label class="latestContent">Winner: Kirstin Mitchell</label><br/><br/>
				<label class="latestContent">Ravens vs Steelers</label><br/>
				<label class="latestContent">September 2, 2015</label><br/>
				<label class="latestContent">Winner: Zipporah Hammond</label><br/><br/>
				<label class="latestContent">Knicks vs Heat</label><br/>
				<label class="latestContent">October 2, 2015</label><br/>
				<label class="latestContent">Winner: Kirstin Mitchell</label><br/><br/>
			</div>
		</div>
	</div>
</body>
</html>
