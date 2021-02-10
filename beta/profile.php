<?php
	include_once './util/profile.inc.php';
	include_once './util/functions.php';
	include_once './util/db_connect.php';
	
	if(!isset($_SESSION)) {
		sec_session_start();
	}
	
	// Redirect to login page if not signed in
	if (!isset($_COOKIE['email']) && !isset($_COOKIE['connect_id'])) {
		header('Location: ./');
	}
	
	// Redirect to edit profile page if profile already created
	if (isset($_COOKIE['user_id']) && isset($_COOKIE['name'])) {
		header('Location: editprofile.php');
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
	
	<!-- Messi Popup: Start -->
	<link rel="stylesheet" href="messi/messi.css" />
	<script src="messi/messi.js"></script>
	<!-- Messi Popup: End -->
	
	<!-- Populate Team Select: Start -->
	<script>
		function getTeams() { 
			$favsport = document.getElementById("favsport");
			document.getElementById("favteam").innerHTML = "";
			
			xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("favteam").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "util/get_teams.php?s=" + $favsport.value, true); 
			xmlhttp.send();
		}
	</script>
	<!-- Populate Team Select: End -->
	
	<!-- CSS: Start -->
	<link rel="stylesheet" href="css/splash.css" />
	<!-- CSS: End -->
</head>
<body>
	<div id="HeaderContainer">
		<div id="HeaderLogo">
			<a href="home.php"><img class="logo" src="images/logoTitle.png" alt="Perfect Pickem" title="Return To Home Page" /></a>
		</div>
		<div id="HeaderNav">
			<li class="NavOptions"><a class="link" href="logout.php">Logout</a></li>
			<li class="NavOptions"><a class="link" href="contact.php">Contact</a></li>
			<li class="NavOptions"><a class="link" href="about.php">About</a></li>
		</div>
	</div>
	<div id="WelcomeContainer">
		<h1>One more step! Enter your personal information<br/>to create your own custom profile.</h1>
	</div>
	<div id="ProfileContainer">
		<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" name="profile_form">		
			<table style="margin:0px auto">
				<tr>
					<td><label for="firstname">First Name:</label></td>
					<td>
						<input type="text" name="firstname" id="firstname" placeholder="Required" 
						onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/>
					</td>
				</tr>
				<tr>
					<td><label for="lastname">Last Name:</label></td>
					<td>
						<input type="text" name="lastname" id="lastname" placeholder="Required" 
						onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/>
					</td>
				</tr>
				<tr>
					<td><label for="favsport">Favorite Sport:</label></td>
					<td><select name="favsport" id="favsport" onChange="getTeams()">
							<option value="">Select Sport</option>
							<?php getSports($mysqli) ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="favteam">Favorite Team:&nbsp;&nbsp;</label></td>
					<td><select name="favteam" id="favteam">
							<option value="">Select Sport</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="photo">Profile Photo:</label></td>
					<td><input type="file" name="photo"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center">
						<input type="button" id="register" value="Create Account" onClick="checkFields(form, firstname, lastname)" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>
