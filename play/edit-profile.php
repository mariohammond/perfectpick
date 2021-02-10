<?php
	include_once 'connect/connect-info.php';
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	include_once 'util/register.inc.php';
	include_once 'util/change_name.php';
	include_once 'util/change_image.php';
	
	// Get user info
	$user_info = getUserInfo($connection, $_COOKIE['user_id']);
	
	// Process change password request
	if (isset($_POST['p'], $_POST['p2'])) {
		changePassword($connection, $_POST['p'], $_POST['p2']);
	}
	
	// Redirect for social connect
	if (array_key_exists("login", $_GET)) {
    	$oauth_provider = $_GET['oauth_provider'];
		if ($oauth_provider == 'twitter') {
			header("Location: connect/twitter/login.php");
		} else if ($oauth_provider == 'facebook') {
			header("Location: connect/facebook/login.php");
		} else if ($oauth_provider == 'google') {
			header("Location: connect/google/login.php");
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
	
	<!-- Get User Info: Start -->
	<script> 
	function loadUserInfo() {
		<?php
			$info = getUserInfo($connection, $_COOKIE['user_id']);
			$teams = getFavoriteTeams($connection, $_COOKIE['user_id']);
		?>
	} 
	</script>
	<!-- Get User Info: End -->
	
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
			setInterval(function(){window.location.replace("../edit-profile?ateam=2018215")}, 500);
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
		setInterval(function(){window.location.replace("../edit-profile?rteam=2018215")}, 500);
	}
	</script>
	<!-- Manage Favorite Teams: End -->
</head>
<body onLoad="loadUserInfo()">
	<?php include 'menu.php'; ?>
	<?php include 'header.php'; ?>
	<div class="FullEditProfile Main">
    	<div class="cover-container"></div>
    	<?php if (isset($_GET['nchange']) || isset($_GET['ichange']) || isset($_GET['aemail']) || isset($_GET['pchange']) || isset($_GET['alink']) || isset($_GET['ateam']) || isset($_GET['rteam'])) : ?>
		<div class="EditProfileMessage">
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
        <?php endif; ?>
		<div class="EditTitleContainer">
			<label class="mainTitle">Edit Profile <a class="back-profile" href="profile" data-category="pp-edit-profile" data-action="return-button" data-label="profile">Back To Profile</a></label>
		</div>
		<div class="EditContentContainer">
			<div class="ContentContainerA">
				<div class="ChangeNameContainer">
					<label class="editTitle">Change Name</label>
					<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="name_form">		
						<table>
							<tr>
								<td><label for="firstname" class="tableLabel">First Name:</label></td>
								<td>
									<input type="text" name="firstname" id="firstname" value="<?php echo $user_info['first_name']; ?>" />
								</td>
							</tr>
							<tr>
								<td><label for="lastname" class="tableLabel">Last Name:&nbsp;&nbsp;</label></td>
								<td>
									<input type="text" name="lastname" id="lastname" value="<?php echo $user_info['last_name']; ?>" />
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<a data-category="pp-edit-profile" data-action="edit-button" data-label="change-name"><input type="button" id="register" value="Change Name" onClick="checkFields(form, form.firstname, form.lastname)" /></a>
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div class="ChangeImageContainer">
					<label class="editTitle">Change Image</label>
					<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" enctype='multipart/form-data' name="photo_form">
						<table>
							<tr>
								<td><input type="file" name="photo" id="photo"><br/></td>
							</tr>
						</table><br/>
						<a data-category="pp-edit-profile" data-action="edit-button" data-label="change-image"><input type="submit" name="submit" value="Change Image" /></a>
					</form>
				</div>
			</div>
			<div class="ContentContainerB">
				<div class="EmailAccountContainer">
					<?php if(!isset($_COOKIE['email']) || $_COOKIE['email'] == '') : ?>
						<label class="editTitle">Add Email Account</label>
						<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="email_form">
							<table>
								<tr>
									<td><label for="email" class="tableLabel">Email:</label></td>
									<td><input type="email" name="email" id="email" /></td>
								</tr>
								<tr>
									<td><label for="password" class="tableLabel">Password:&nbsp;&nbsp;</label></td>
									<td><input type="password" name="password" id="password" /></td>
								</tr>
								<tr>
									<td><label for="confirmpwd" class="tableLabel">Confirm Password:&nbsp;&nbsp;</label></td>
									<td><input type="password" name="confirmpwd" id="confirmpwd" /></td>
								</tr>
                                <tr>
                                	<td><input type="hidden" name="page" value="<?php echo $_SERVER['PHP_SELF']; ?>"></td>
                                </tr>
								<tr>
									<td>
										<a data-category="pp-edit-profile" data-action="edit-button" data-label="add-email"><input type="button" id="register" value="Register" onClick="checkRegistration(form, email, password, confirmpwd)" /></a>
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
									<td><input name="oldPassword" type="password" id="oldPassword" /></td>
								</tr>
								<tr>
									<td><label class="tableLabel">New Password:</label></td>
									<td><input name="newPassword" type="password" id="newPassword" /></td>
								</tr>
								<tr>
									<td><label class="tableLabel">Confirm Password:&nbsp;&nbsp;</label></td>
									<td><input name="newPasswordConfirm" type="password" id="newPasswordConfirm" /></td>
								</tr>
							</table>
							<a data-category="pp-edit-profile" data-action="edit-button" data-label="change-password">
                            	<input type="button" id="btnSubmit" value="Change Password" onClick="return newPass(this.form, this.form.oldPassword, this.form.newPassword, this.form.newPasswordConfirm);" /></a>
						</form>
					<?php endif; ?>
				</div>
				<div class="SocialAccountContainer">
					<label class="editTitle">Link To Social Accounts</label>
					<div>
						<a href="?login&oauth_provider=facebook" data-category="pp-edit-profile" data-action="link-social" data-label="facebook"><img src="images/fb_link.png" /></a>
						<a href="?login&oauth_provider=twitter" data-category="pp-edit-profile" data-action="link-social" data-label="twitter"><img src="images/tw_link.png" /></a>
						<a href="?login&oauth_provider=google" data-category="pp-edit-profile" data-action="link-social" data-label="google"><img src="images/gp_link.png" /></a>
					</div>
				</div>
			</div>
			<div class="ContentContainerC">
				<div id="fav-teams" class="FavTeamsContainer">
					<label class="editTitle"><p style="text-align:center">Manage Favorite Teams<br/>(Up To 4 Teams)</p></label>
					<table>
					<?php if(isset($teams[0])) : ?>
						<tr>
							<td style="width:70%"><label class="tableLabel">
									<strong>Current Team:</strong>&nbsp;<?php echo $teams[0]->getTeamName(); ?>&nbsp;(<?php echo $teams[0]->getSportName(); ?>)&nbsp;&nbsp;</label></td>
							<td><a data-category="pp-edit-profile" data-action="edit-button" data-label="remove-team"><label class="removeLabel" onClick="removeTeam('<?php echo $teams[0]->getTeamId(); ?>')">Remove Team</label></a></td>
						</tr>
					<?php endif; ?>
					<?php if(isset($teams[1])) : ?>
						<tr>
							<td style="width:70%"><label class="tableLabel">
									<strong>Current Team:</strong>&nbsp;<?php echo $teams[1]->getTeamName(); ?>&nbsp;(<?php echo $teams[1]->getSportName(); ?>)&nbsp;&nbsp;</label></td>
							<td><a data-category="pp-edit-profile" data-action="edit-button" data-label="remove-team"><label class="removeLabel" onClick="removeTeam('<?php echo $teams[1]->getTeamId(); ?>')">Remove Team</label></a></td>
						</tr>
					<?php endif; ?>
					<?php if(isset($teams[2])) : ?>
						<tr>
							<td style="width:70%"><label class="tableLabel">
									<strong>Current Team:</strong>&nbsp;<?php echo $teams[2]->getTeamName(); ?>&nbsp;(<?php echo $teams[2]->getSportName(); ?>)&nbsp;&nbsp;</label></td>
							<td><a data-category="pp-edit-profile" data-action="edit-button" data-label="remove-team"><label class="removeLabel" onClick="removeTeam('<?php echo $teams[2]->getTeamId(); ?>')">Remove Team</label></a></td>
						</tr>
					<?php endif; ?>
					<?php if(isset($teams[3])) : ?>
						<tr>
							<td style="width:70%"><label class="tableLabel">
									<strong>Current Team:</strong>&nbsp;<?php echo $teams[3]->getTeamName(); ?>&nbsp;(<?php echo $teams[3]->getSportName(); ?>)&nbsp;&nbsp;</label></td>
							<td><a data-category="pp-edit-profile" data-action="edit-button" data-label="remove-team"><label class="removeLabel" onClick="removeTeam('<?php echo $teams[3]->getTeamId(); ?>')">Remove Team</label></a></td>
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
										<?php getSports($connection) ?>
									</select>
								</td>
                            </tr>
                   			<tr>
								<td><label for="favteam" class="tableLabel">Favorite Team:&nbsp;&nbsp;</label></td>
								<td><select name="favteam" id="favteam">
										<option value="">Select Sport</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<a data-category="pp-edit-profile" data-action="edit-button" data-label="add-team"><input type="button" id="addTeams" value="Add New Team" onClick="addTeam(form.favsport.value, form.favteam.value)" /></a>
								</td>
							</tr>
						</table>
					</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
    <?php include 'footer.php'; ?>
    <span class="wideCheck"></span><span class="desktopCheck"></span><span class="tabletCheck"></span><span class="mobileCheck"></span>
</body>
</html>
