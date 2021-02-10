<?php
	if(!isset($_SESSION)) {
		sec_session_start();
	}
	
	// Redirect to profile page if profile not created
	if (!isset($_COOKIE['name'])) {
		header('Location: profile.php');
	}
	
	// Redirect to login page if not signed in
	if (!isset($_COOKIE['email']) && !isset($_COOKIE['connect_id'])) {
		header('Location: ./');
	}
?>

<!DOCTYPE html>
<head>
</head>
<body>
<div id="HeaderContainer">
		<div id="HeaderLogo">
			<a href="home.php"><img class="logo" src="images/logoTitle.png" alt="Perfect Pickem" title="Return To Home Page" /></a>
		</div>
		<div id="HeaderNav">
			<li class="NavOptions"><a class="link" href="logout.php">Logout</a></li>
			<li class="NavOptions"><a class="link" href="contact.php">Contact</a></li>
			<li class="NavOptions"><a class="link" href="matchlist.php">Matches</a></li>
			<li class="NavOptions"><a class="link" href="dashboard.php?id=<?php echo $_COOKIE['user_id'] ?>">Dashboard</a></li>
			<li class="NavOptions"><a class="link" href="home.php">Home</a></li>
		</div>
	</div>
</body>
</html>
