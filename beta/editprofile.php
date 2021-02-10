<?php
	include_once './util/register.inc.php';
	include_once './util/change_name.php';
	include_once './util/change_image.php';
	include_once './util/functions.php';
	include_once './util/db_connect.php';
	include_once './connect/login-google.php';
	
	sec_session_start();
	
	// Process change password request
	if (isset($_POST['p'], $_POST['p2'])) {
		changePassword($mysqli, $_POST['p'], $_POST['p2']);
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
	
	<!-- Get User Info: Start -->
	<script> 
	function loadUserInfo() {
		<?php
			$info = getUserInfo($mysqli, $_COOKIE['user_id']);
			$teams = getFavoriteTeams($mysqli, $_COOKIE['user_id']);
		?>
	}
	</script>
	<!-- Get User Info: End -->
	
	<!-- Password Help Popup: Start -->
	<script type="text/javascript" src="js/nhpup_1.1.js"></script>
	<script>
		function passwordHelp() {
			return "Password must contain:<br/>At least 6 characters<br/>At least one uppercase letter<br/>At least one lowercase letter<br/>At least one number";
		}
	</script>	
	<!-- Password Help Popup: End -->
	
	<!-- Change Profile Name: Start -->
	<script>
	function changeName(firstName, lastName) {
		document.getElementById("favteam1").innerHTML = "";
		
		xmlhttp = new XMLHttpRequest();
		
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("favteam1").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "util/change_name.php?first=" + firstName + "&last=" + lastName, true); 
		xmlhttp.send();
	}
	</script>
	<!-- Change Profile Name: End -->
	
	<!-- Update Mailing List: Start -->
	<script>
	<?php if($info['mailing_list'] == 'true') : ?>
		$(document).ready(function() {
			$mailList = document.getElementById("mailinglist");
			$mailList.checked = true;
		});
	<?php endif; ?>
	
	function updateMailing() {
		$mailList = document.getElementById("mailinglist");
		
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {}
		}
		xmlhttp.open("GET", "util/update_mailing.php?m=" + $mailList.checked, true); 
		xmlhttp.send();
	}
	</script>
	<!-- Update Mailing List: End -->
	
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
	
	<!-- Manage Favorite Teams: Start -->
	<script>
	function addTeam(sport, team) {
		if (sport != "" && team != "") {
			document.getElementById("favteam").innerHTML = "";
			
			xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("favteam").innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.open("GET", "util/add_team.php?s=" + sport + "&t=" + team, true); 
			xmlhttp.send();
			setInterval(function(){window.location.replace("../editprofile.php?ateam=2018215")}, 500);
		}
	}
	</script>
	<script>
	function removeTeam(team) { 
		xmlhttp = new XMLHttpRequest();
		
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {}
		}
		xmlhttp.open("GET", "util/remove_team.php?t=" + team, true); 
		xmlhttp.send();
		setInterval(function(){window.location.replace("../editprofile.php?rteam=2018215")}, 500);
	}
	</script>
	<!-- Manage Favorite Teams: End -->
	
	<!-- CSS: Start -->
	<link rel="stylesheet" href="css/main.css" />
	<!-- CSS: End -->
</head>
<body onLoad="loadUserInfo()">
	<?php include 'header.php'; ?>
	<div id="FullEditProfile">
		<div id="EditProfileMessage">
			<?php if(isset($_GET['nchange']) && $_GET['nchange'] == '2018215') : ?>
				<label class="editMessage">Profile name changed!</label>
			<?php endif; ?>
			<?php if(isset($_GET['nchange']) && $_GET['nchange'] == '6112195') : ?>
				<label class="editMessage">Unable to change name. Please try again.</label>
			<?php endif; ?>
			<?php if(isset($_GET['ichange']) && $_GET['ichange'] == '2018215') : ?>
				<label class="editMessage">Profile image changed!</label>
			<?php endif; ?>
			<?php if(isset($_GET['ichange']) && $_GET['ichange'] == '6112195') : ?>
				<label class="editMessage">Unable to load new image. Please try again.</label>
			<?php endif; ?>
			<?php if(isset($_GET['aemail']) && $_GET['aemail'] == '2018215') : ?>
				<label class="editMessage">Email added to account!</label>
			<?php endif; ?>
			<?php if(isset($_GET['aemail']) && $_GET['aemail'] == '6112195') : ?>
				<label class="editMessage">An account with this email address already exists.</label>
			<?php endif; ?>
			<?php if(isset($_GET['pchange']) && $_GET['pchange'] == '2018215') : ?>
				<label class="editMessage">Password updated!</label>
			<?php endif; ?>
			<?php if(isset($_GET['pchange']) && $_GET['pchange'] == '6112195') : ?>
				<label class="editMessage">Incorrect current password.</label>
			<?php endif; ?>
			<?php if(isset($_GET['alink']) && $_GET['alink'] == '61352151511') : ?>
				<label class="editMessage">Successfully linked to Facebook account!</label>
			<?php endif; ?>
			<?php if(isset($_GET['alink']) && $_GET['alink'] == '202392020518') : ?>
				<label class="editMessage">Successfully linked to Twitter account!</label>
			<?php endif; ?>
			<?php if(isset($_GET['alink']) && $_GET['alink'] == '720207125') : ?>
				<label class="editMessage">Successfully linked to Google account!</label>
			<?php endif; ?>
			<?php if(isset($_GET['ateam']) && $_GET['ateam'] == '2018215') : ?>
				<label class="editMessage">New favorite team added!</label>
			<?php endif; ?>
			<?php if(isset($_GET['rteam']) && $_GET['rteam'] == '2018215') : ?>
				<label class="editMessage">Favorite team removed.</label>
			<?php endif; ?>
		</div>
		<div id="EditTitleContainer">
			<label class="mainTitle">Edit Profile</label>
		</div>
		<div id="EditContentContainer">
			<div id="ContentContainerA">
				<div id="ChangeNameContainer">
					<label class="editTitle">Change Name</label>
					<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="name_form">		
						<table>
							<tr>
								<td><label for="firstname" class="tableLabel">First Name:</label></td>
								<td>
									<input type="text" name="firstname" id="firstname"
									onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/>
								</td>
							</tr>
							<tr>
								<td><label for="lastname" class="tableLabel">Last Name:&nbsp;&nbsp;</label></td>
								<td>
									<input type="text" name="lastname" id="lastname"
									onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="button" id="register" value="Change Name" onClick="checkFields(form, form.firstname, form.lastname)" />
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div id="ChangeImageContainer">
					<label class="editTitle">Change Image</label>
					<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" enctype='multipart/form-data' name="photo_form">
						<table>
							<tr>
								<td><input type="file" name="photo" id="photo"><br/></td>
							</tr>
						</table><br/>
						<input type="submit" name="submit" value="Change Image" />
					</form>
				</div>
			</div>
			<div id="ContentContainerB">
				<div id="EmailAccountContainer">
					<?php if(!isset($_COOKIE['email']) || $_COOKIE['email'] == '') : ?>
						<label class="editTitle">Add Email Account</label>
						<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="email_form">
							<table>
								<tr>
									<td><label for="email" class="tableLabel">Email:</label></td>
									<td><input type="email" name="email" id="email" onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/></td>
								</tr>
								<tr>
									<td><label for="password" class="tableLabel">Password:&nbsp;&nbsp;<img class="help" src="images/help.png" 
										onMouseOver="nhpup.popup(passwordHelp());"></label></td>
									<td><input type="password" name="password" id="password" 
											onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/></td>
								</tr>
								<tr>
									<td><label for="confirmpwd" class="tableLabel">Confirm Password:&nbsp;&nbsp;</label></td>
									<td><input type="password" name="confirmpwd" id="confirmpwd" 
											onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/></td>
								</tr>
								<tr>
									<td>
										<input type="button" id="register" value="Register" onClick="checkRegistration(form, email, password, confirmpwd)" />
									</td>
								</tr>
							</table>
						</form>
					<?php endif; ?>
					<?php if(isset($_COOKIE['email']) && $_COOKIE['email'] != '') : ?>
						<label class="editTitle">Change Sign-In Password</label>
						<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="password_form">
							<table>
								<tr>
									<td><label class="tableLabel">Old Password:</label></td>
									<td><input name="oldPassword" type="password" id="oldPassword" 
									onkeydown="if (event.keyCode == 13) document.getElementById('btnSubmit').click()"/></td>
								</tr>
								<tr>
									<td><label class="tableLabel">New Password:</label></td>
									<td><input name="newPassword" type="password" id="newPassword" 
									onkeydown="if (event.keyCode == 13) document.getElementById('btnSubmit').click()"/></td>
								</tr>
								<tr>
									<td><label class="tableLabel">Confirm Password:&nbsp;&nbsp;</label></td>
									<td><input name="newPasswordConfirm" type="password" id="newPasswordConfirm" 
									onkeydown="if (event.keyCode == 13) document.getElementById('btnSubmit').click()"/></td>
								</tr>
							</table>
							<input type="button" id="btnSubmit" value="Change Password" 
								onClick="return newPass(this.form, this.form.oldPassword, this.form.newPassword, this.form.newPasswordConfirm);" />
						</form>
					<?php endif; ?>
				</div>
				<div id="SocialAccountContainer">
					<label class="editTitle">Link To Social Accounts</label>
					<div>
						<a href="?login&oauth_provider=facebook"><img src="images/fb_link.png" /></a>
						<a href="?login&oauth_provider=twitter"><img src="images/tw_link.png" /></a>
						<a <?php echo "href='$authUrl'" ?>><img src="images/gp_link.png" /></a>
					</div>
				</div>
			</div>
			<div id="ContentContainerC">
				<div id="FavTeamsContainer">
					<label class="editTitle">Manage Favorite Teams (up to 4)</label><br/>
					<input type="checkbox" name="mailinglist" id="mailinglist" value="true" onChange="updateMailing()"/>
						<label class="tableLabel">&nbsp;Email me about favorite sport/team matches.</label>
					<table>
					<?php if(isset($teams[0])) : ?>
						<tr>
							<td><label class="tableLabel">
									Current Team:&nbsp;<?php echo $teams[0]->getTeamName(); ?>&nbsp;(<?php echo $teams[0]->getSportName(); ?>)&nbsp;&nbsp;</label></td>
							<td><label class="removeLabel" onClick="removeTeam('<?php echo $teams[0]->getTeamId(); ?>')">Remove Team</label></td>
						</tr>
					<?php endif; ?>
					<?php if(isset($teams[1])) : ?>
						<tr>
							<td><label class="tableLabel">
									Current Team:&nbsp;<?php echo $teams[1]->getTeamName(); ?>&nbsp;(<?php echo $teams[1]->getSportName(); ?>)&nbsp;&nbsp;</label></td>
							<td><label class="removeLabel" onClick="removeTeam('<?php echo $teams[1]->getTeamId(); ?>')">Remove Team</label></td>
						</tr>
					<?php endif; ?>
					<?php if(isset($teams[2])) : ?>
						<tr>
							<td><label class="tableLabel">
									Current Team:&nbsp;<?php echo $teams[2]->getTeamName(); ?>&nbsp;(<?php echo $teams[2]->getSportName(); ?>)&nbsp;&nbsp;</label></td>
							<td><label class="removeLabel" onClick="removeTeam('<?php echo $teams[2]->getTeamId(); ?>')">Remove Team</label></td>
						</tr>
					<?php endif; ?>
					<?php if(isset($teams[3])) : ?>
						<tr>
							<td><label class="tableLabel">
									Current Team:&nbsp;<?php echo $teams[3]->getTeamName(); ?>&nbsp;(<?php echo $teams[3]->getSportName(); ?>)&nbsp;&nbsp;</label></td>
							<td><label class="removeLabel" onClick="removeTeam('<?php echo $teams[3]->getTeamId(); ?>')">Remove Team</label></td>
						</tr>
					<?php endif; ?>
					</table>
					<?php if(!isset($teams[3])) : ?>
					<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="team_form">		
						<table>
							<tr>
								<td><label for="favsport" class="tableLabel">Favorite Sport:&nbsp;&nbsp;</label></td>
								<td><select name="favsport" id="favsport" onChange="getTeams()">
										<option value="">Select Sport</option>
										<?php getSports($mysqli) ?>
									</select>
								</td>
								<td><label for="favteam" class="tableLabel">Favorite Team:&nbsp;&nbsp;</label></td>
								<td><select name="favteam" id="favteam">
										<option value="">Select Sport</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="button" id="addTeams" value="Add New Team" onClick="addTeam(form.favsport.value, form.favteam.value)" />
								</td>
							</tr>
						</table>
					</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
