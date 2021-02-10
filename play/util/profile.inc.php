<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

include_once 'util/functions.php';
include_once 'connect/db-connect.php';

if(!isset($_SESSION)) {
	sec_session_start();
}

if (isset($_POST['firstname'], $_POST['lastname'])) {

	// Sanitize and validate submitted data
	$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
	$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
	
	// Send notification email to admin
	$subject = "New Pick'em User!";
	$txt = "A new user account has been created. The name is " . $firstname . " " . $lastname . ".";
	$headers = "From: Perfect Pick'em <admin@perfectpickem.com>";
	mail("admin@perfectpickem.com", $subject, $txt, $headers);
	
	// Upload submitted photo
	if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
		$uploadDir = 'uploads/';
	
		$fileName = time() . $_FILES['photo']['name'];
		$tmpName = $_FILES['photo']['tmp_name'];
		$fileSize = $_FILES['photo']['size'];
		$fileType = $_FILES['photo']['type'];
	
		$filePath = $uploadDir . $fileName;
	
		$result = move_uploaded_file($tmpName, $filePath);
			
	} else {
		$filePath = "uploads/logo.png";
	}
	
	// Set default skill level
	$skill_level = "Rookie";
	
	// Insert new profile into database
	if ($insert_stmt = $connection->prepare("INSERT INTO user_profile (user_id, first_name, last_name, image, skill_level) VALUES (?, ?, ?, ?, ?)")) {
			$insert_stmt->bind_param('issss', $_COOKIE['user_id'], $firstname, $lastname, $filePath, $skill_level);
			if (!$insert_stmt->execute()) {
				echo "Database error.";
		}
		
		$insert_stmt->close();
	}
	
	setcookie('name', $lastname, time() + 3600 * 24 * 30, '/');
	header("Location: http://play.perfectpickem.com/profile?userId=" . $_COOKIE['user_id']);
}

// Reset Password
if (isset($_POST['p_reset'])) {
    
	$email = $_POST['email'];
	$p = $_POST['p_reset'];
	
	if(checkEmail($connection, $email)) {
		if ($stmt = $connection->prepare("SELECT salt FROM user_account WHERE email = ? LIMIT 1")) {
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
					
				$update=$connection->prepare($query);
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
		}
	} else {
		$_SESSION['reset'] = 'false';
	}
}
?>
