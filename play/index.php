<?php 
	include_once 'connect/db-connect.php';
	include_once 'util/register.inc.php';
	include_once 'util/profile.inc.php';
	include_once 'util/functions.php';
	
	session_start();
	
	if (isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != '') {
		header("Location: http://play.perfectpickem.com/dashboard");	
	}
?>

<html>
<head>
	<title>Play Pick'em | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
    <meta name="google-site-verification" content="YhJA1YcItTO-Vs9KurpcjiCkF9p0EOEbdRPSraTihV8" />
</head>
<body>
	<div id="main-container">
   		<?php include 'menu.php'; ?>
    	<?php include 'header.php'; ?>
        <div id="page-home" class="content">
        	<div class="cover-container"></div>
            <div id="region-1">
            	<img src="images/banner.png" /> 
            	<h1>Make your best picks and predictions for<br/>NFL, NBA, MLB, NHL, and college games.</h1>
                <a href="/dashboard" data-category="pp-home" data-action="call-to-action" data-label="top"><div class="action-button">PLAY NOW FOR FREE!</div></a>
            </div>
            <div id="region-2">
            	<h1>HOW TO PLAY</h1>
                <img src="images/features.png" />
            </div>
            <div id="region-3">
            	<h1>FOLLOW US EVERYWHERE!</h1>
                <div class="social-icons">
                	<a href="http://www.facebook.com/perfectpickem" target="_blank" data-category="pp-home" data-action="social-follow" data-label="facebook"><img src="images/facebook_follow.png"></a>
                    <a href="http://www.twitter.com/perfectpickem" target="_blank" data-category="pp-home" data-action="social-follow" data-label="twitter"><img src="images/twitter_follow.png"></a>
                    <a href="http://plus.google.com/+perfectpickem1" target="_blank" data-category="pp-home" data-action="social-follow" data-label="google"><img src="images/google_follow.png"></a>
                    <a href="http://perfectpickem.tumblr.com" target="_blank" data-category="pp-home" data-action="social-follow" data-label="tumblr"><img src="images/tumblr_follow.png"></a>
                    <a href="http://www.pinterest.com/perfectpickem" target="_blank" data-category="pp-home" data-action="social-follow" data-label="pinterest"><img src="images/pinterest_follow.png"></a>
                    <a href="http://www.instagram.com/perfectpickem" target="_blank" data-category="pp-home" data-action="social-follow" data-label="instagram"><img src="images/instagram_follow.png"></a>
                </div>
                <a href="/dashboard" data-category="pp-home" data-action="call-to-action" data-label="bottom"><div class="action-button">GET STARTED NOW!</div></a>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    	<span class="wideCheck"></span><span class="desktopCheck"></span><span class="tabletCheck"></span><span class="mobileCheck"></span>
   	</div>
</body>
</html>
