<?php 
	include_once 'connect/db-connect.php';
	include_once 'util/register.inc.php';
	include_once 'util/profile.inc.php';
	include_once 'util/functions.php';
	
	session_start();
?>

<html>
<head>
	<title>Pick'em Dashboard | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
</head>
<body>
	<div id="main-container">
   		<?php include 'menu.php'; ?>
    	<?php include 'header.php'; ?>
        <div id="page-dashboard" class="content">
        	<div class="cover-container"></div>
            <div id="region-1">
            	<a class="dashboard-image view-profile" href="/profile" data-category="pp-dashboard" data-action="dashboard-button" data-label="view-profile"><img src="images/bg-football.jpg"/></a>
                <a class="dashboard-image find-match" href="/matches" data-category="pp-dashboard" data-action="dashboard-button" data-label="find-match"><img src="images/bg-basketball.jpg"/></a>
                <a class="dashboard-image leaderboard" href="/leaderboard" data-category="pp-dashboard" data-action="dashboard-button" data-label="leaderboard"><img src="images/bg-baseball.jpg"/></a>
                <a class="dashboard-image achievements" href="/achievements" data-category="pp-dashboard" data-action="dashboard-button" data-label="achievements"><img src="images/bg-trophy.jpg"/></a>
                <a class="dashboard-image how-to-play" href="/how-to-play" data-category="pp-dashboard" data-action="dashboard-button" data-label="how-to-play"><img src="images/bg-hockey.jpg"/></a>
                <a class="dashboard-image contact-us" href="http://www.perfectpickem.com/contact" data-category="pp-dashboard" data-action="dashboard-button" data-label="contact-us"><img src="images/bg-email.jpg"/></a>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    	<span class="wideCheck"></span><span class="desktopCheck"></span><span class="tabletCheck"></span><span class="mobileCheck"></span>
   	</div>
</body>
</html>
