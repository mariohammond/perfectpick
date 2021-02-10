<?php
	include_once 'util/db_connect.php';
	include_once 'util/functions.php';
	sec_session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfect Pick'em</title>
	<link rel="icon" type="image/png" href="images/favicon.png" />
	
	<!-- Get User Info: Start -->
	<script> 
	function loadUserInfo() {
		<?php
			$info = getUserInfo($mysqli, $_GET['id']);
			$teams = getFavoriteTeams($mysqli, $_GET['id']);
		?>
	}
	</script>
	<!-- Get User Info: End -->
	
	<!-- CSS: Start -->
	<link rel="stylesheet" href="css/splash.css" />
	<!-- CSS: End -->
</head>
<body onLoad="loadUserInfo()">
	<div id="HeaderContainer">
		<div id="HeaderLogo">
			<a href="home.php"><img class="logo" src="images/logoTitle.png" alt="Perfect Pickem" title="Return To Home Page" /></a>
		</div>
		<div id="HeaderNav">
			<li class="NavOptions"><a class="link" href="contact.php">Contact</a></li>
			<li class="NavOptions"><a class="link" href="about.php">About</a></li>
		</div>
	</div>
	<div>
		<?php getAllLogos($mysqli); ?>
	</div>
</body>
</html>
