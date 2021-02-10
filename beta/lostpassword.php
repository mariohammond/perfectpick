<?php
	include_once './util/db_connect.php';
    include_once './util/db_config.php';
	include_once './util/functions.php';
	
	if(!isset($_SESSION)) {
		sec_session_start();
	}
	
	if (isset($_POST['email'], $_POST['p'])) {
    
		$email = $_POST['email'];
		$p = $_POST['p'];
		
		if(checkEmail($mysqli, $email)) {
			if ($stmt = $mysqli->prepare("SELECT salt FROM user_account WHERE email = ? LIMIT 1")) {
				$stmt->bind_param('s', $email);
				$stmt->execute(); 
				$stmt->store_result();
				
				// Get variable from result.
				$stmt->bind_result($salt);
				$stmt->fetch();
				
				// Hash new password with salt.
				$pass = hash('sha512', $p);
				$pass = hash('sha512', $pass . $salt);
				
				if ($stmt->num_rows == 1) {
					$stmt->close();
					
					$query = "UPDATE user_account SET password = ? WHERE email = ?";
						
					$update=$mysqli->prepare($query);
					$update->bind_param('ss', $pass, $email);
					$update->execute();
					$update->close();
				}
				
				// Email new password to user.
				$subject = "Password Reset";
				$txt = "Your password has been reset. Your new password is " . $p . ".";
				$headers = "From: Perfect Pick'em <admin@perfectpickem.com>";
				mail($email, $subject, $txt, $headers);
				
				$_SESSION['reset'] = 'true';
				header('Location: lostpassword.php');
			}
		} else {
			$_SESSION['reset'] = 'false';
			header('Location: lostpassword.php');
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfect Pick'em</title>
	<link rel="icon" type="image/png" href="images/favicon.png" />
	
	<!-- Javascript: Start -->
	<script type="text/JavaScript" src="js/forms.js"></script>
	<!-- Javascript: End -->
	
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
			<li class="NavOptions"><a class="link" href="contact.php">Contact</a></li>
			<li class="NavOptions"><a class="link" href="about.php">About</a></li>
		</div>
	</div>
	<div id="PasswordContainer">	
		<label id="passwordTitle">Enter your email address and a reset password will be sent to you.</label><br/><br/>
		
		<?php if($_SESSION['reset'] && $_SESSION['reset'] == 'true') : ?>
			<label id="successMessage">Success! Your password has been reset and sent to your email.</label><br/><br/>
		<?php endif; ?>
		
		<?php if($_SESSION['reset'] && $_SESSION['reset'] == 'false') : ?>
			<label id="errorMessage">Email address not found. Please try again.</label><br/><br/>
		<?php endif; ?>
		
		<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="reset_form">
			<table>
				<tr>
					<td><label for="email">Email:&nbsp;&nbsp;</label></td>
					<td><input type="email" name="email" id="email" onKeyDown="if (event.keyCode == 13) document.getElementById('register').click()"/></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" id="register" value="Reset Password" onClick="resetPassword(form, email)" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>
