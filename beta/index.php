<?php
	include_once './util/register.inc.php';
	include_once './util/functions.php';
	include_once './util/db_connect.php';
	include_once './connect/login-google.php';
   
	sec_session_start();

	// Redirect to home if logged in via email
	if (isset($_COOKIE['user_id']) && isset($_COOKIE['email'])) {
		header('Location: home.php');
	}
	
	// Redirect to home if logged in via social connect
	if (isset($_COOKIE['connect_id'])) {
		header('Location: home.php');
	}
	
	// Redirect for social connect
	if (array_key_exists("login", $_GET)) {
    	$oauth_provider = $_GET['oauth_provider'];
		if ($oauth_provider == 'twitter') {
			header("Location: connect/login-twitter.php");
		} else if ($oauth_provider == 'facebook') {
			header("Location: connect/login-facebook.php");
		}
	}
	
	// Redirect to edit profile for duplicate email attempt
	if (isset($_GET['register']) && $_GET['register'] == 'duplicate' && isset($_COOKIE['user_id'])) {
		header('Location: editprofile.php?aemail=6112195');
	}

	// Clear cookies and destroy session if logged out
	if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
		setcookie("PHPSESSID", "", time()-3600, "/");
		setcookie("user_id", "", time()-3600, "/");
		setcookie("connect_id", "", time()-3600, "/");
		setcookie("email", "", time()-3600, "/");
		setcookie("name", "", time()-3600, "/");
		session_destroy();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfect Pick'em</title>
	<link rel="icon" type="image/png" href="images/favicon.png" />
	
	<!-- Javascript: Start -->
	<script type="text/JavaScript" src="js/sha512.js"></script>
	<script type="text/JavaScript" src="js/forms.js"></script>
	<!-- Javascript: End -->
	
	<!-- JQuery: Start -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<!-- JQuery: End -->
	
	<!-- Codrops Background Slideshow: Start -->
	<link rel="stylesheet" type="text/css" href="slideshow/css/cbsmain.css" />
	<link rel="stylesheet" type="text/css" href="slideshow/css/cbsstyle.css" />
	<script type="text/javascript" src="slideshow/js/modernizr.custom.86080.js"></script>
	<!-- Codrops Background Slideshow: End -->
	
	<!-- Email Register Popup Box: Start -->
	<script>
		$(function() {
			$("#RegisterContainer").dialog ({
				autoOpen: false,
				height: 240,
				width: 450,
				modal: true,
				close: function() {}
			});
				
			$(".GetStarted").click(function() {
				$("#RegisterContainer").dialog("open");
			});
		});
	</script>
  	<!-- Email Register Popup Box: End -->
	
	<!-- Social Connect Popup Box: Start -->
	<script>
		$(function() {
			$("#SocialContainer").dialog ({
				autoOpen: false,
				height: 250,
				width: 340,
				modal: true,
				close: function() {}
			});
				
			$(".GetConnected").click(function() {
				$("#SocialContainer").dialog("open");
			});
		});
	</script>
  	<!-- Social Connect Popup Box: End -->

	<!-- Sign-In Popup Box: Start -->
	<script>
		$(function() {
			$("#LoginContainer").dialog ({
				autoOpen: false,
				height: 230,
				width: 350,
				modal: true,
				close: function() {}
			});
				
			$(".loginLink").click(function() {
				$("#LoginContainer").dialog("open");
			});
		});
	</script>
  	<!-- Sign-In Popup Box: End -->
	
	<!-- Messi Popup: Start -->
	<link rel="stylesheet" href="messi/messi.css" />
	<script src="messi/messi.js"></script>
	<!-- Messi Popup: End -->
	
	<!-- Password Help Popup: Start -->
	<script type="text/javascript" src="js/nhpup_1.1.js"></script>
	<script>
		function passwordHelp() {
			return "Password must contain:<br/>At least 6 characters<br/>At least one uppercase letter<br/>At least one lowercase letter<br/>At least one number";
		}
	</script>	
	<!-- Password Help Popup: End -->
	
	<!-- CSS: Start -->
	<link rel="stylesheet" href="css/splash.css" />
	<!-- CSS: End -->
</head>
<body>
	<div class="HomePageTop">
		<div id="SplashHeaderContainer">
			<div id="HeaderLogo">
				<img class="logo" src="images/logoTitle.png" alt="Perfect Pickem" />
			</div>
			<div id="HeaderNav">
				<li class="NavOptions"><a class="loginLink">Sign In</a></li>
				<li class="NavOptions"><a class="link" href="contact.php">Contact</a></li>
				<li class="NavOptions"><a class="link" href="about.php">About</a></li>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div id="SlideshowContainer">
		<ul class="slideshow">
			<li><span>Image 01</span><div><h3></h3></div></li>
			<li><span>Image 02</span><div><h3></h3></div></li>
			<li><span>Image 03</span><div><h3></h3></div></li>
			<li><span>Image 04</span><div><h3></h3></div></li>
		</ul>
	</div>
	<div class="container">
		<header>
			<div id="TaglineContainer">
				<label class="TaglineTitle">All picks. All sports. All the time.</label><br/><br/>
				<label class="TaglineContent">The one-stop shop for year-round sports picks and predictions. And it's 100% free.</label>
			</div>
			<div id="LoginMessage">
				<?php if(isset($_GET['login']) && $_GET['login'] == 'false') : ?>
					<label id="messageLabel">Invalid email/password combination.</label><br/>
				<?php endif; ?>
				
				<?php if(isset($_GET['login']) && $_GET['login'] == 'locked') : ?>
					<label id="messageLabel">Too many invalid attempts. Account is locked for 15 minutes.</label><br/>
				<?php endif; ?>
				
				<?php if(isset($_GET['register']) && $_GET['register'] == 'duplicate') : ?>
					<label id="messageLabel">An account with this email address already exists.</label><br/>
				<?php endif; ?>
			</div>
			<div id="FeaturesContainer">
				<img src="images/features.png" alt="Features" />
			</div>
			<div id="GetStartedContainer">
				<a class="GetStarted"><img src="images/getStarted.png" 
					onMouseOver="this.src='images/getStartedHover.png'" onMouseOut="this.src='images/getStarted.png'"/></a>
				<strong class="joiner">OR</strong>
				<a class="GetConnected"><img src="images/getConnected.png" 
					onMouseOver="this.src='images/getConnectedHover.png'" onMouseOut="this.src='images/getConnected.png'"/></a>
			</div>
			<div id="RegisterContainer" title="Create New Account">
				<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="register_form">
					<table>
						<tr>
							<td><label for="email">Email:</label></td>
							<td><input type="email" name="email" id="email" onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/></td>
						</tr>
						<tr>
							<td><label for="password">Password:&nbsp;<img class="help" src="images/help.png" onMouseOver="nhpup.popup(passwordHelp());"></label></td>
							<td><input type="password" name="password" id="password" 
									onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/></td>
						</tr>
						<tr>
							<td><label for="confirmpwd">Confirm Password:&nbsp;&nbsp;</label></td>
							<td><input type="password" name="confirmpwd" id="confirmpwd" 
									onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/></td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center">
								<input type="button" id="register" value="Register" onClick="checkRegistration(form, email, password, confirmpwd)" />
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="LoginContainer" title="Sign In To Account">
				<form action="util/process_login.php" method="post" name="login_form" id="login_form">
					<table>
						<tr>
							<td><label for="email">Email:</label></td>
							<td><input type="text" class="" name="email" onKeyDown="if (event.keyCode == 13) document.getElementById('signin').click()"/></td>
						</tr>
						<tr>
							<td><label for="password">Password:&nbsp;&nbsp;</label></td>
							<td><input type="password" class="" name="password" id="password" onKeyDown="if (event.keyCode == 13) document.getElementById('signin').click()" /></td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center">
								<input type="button" id="signin" class="" value="Sign In" onClick="createHash(this.form, this.form.password);" />
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center">
								<a id="forgotPassword" href="lostpassword.php"><label id="forgotPassword">Forgot Password?</label></a>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="SocialContainer" title="Register / Sign In">
				<table>
					<tr>
						<td><a href="?login&oauth_provider=facebook"><img src="images/fb_connect.png" /></a></td>
					</tr>
					<tr>
						<td><a href="?login&oauth_provider=twitter"><img src="images/tw_connect.png" /></a></td>
					</tr>
					<tr>
						<td><a <?php echo "href='$authUrl'" ?>><img src="images/gp_connect.png" /></a></td>
					</tr>
				</table>
			</div>
		</header>
	</div>
</body>
</html>
