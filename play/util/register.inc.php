<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

$error_msg = "";

if (isset($_POST['email'], $_POST['p'])) {
	
	// Sanitize and validate the data
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error_msg .= 'The email address you entered is not valid.';
	}
 
	$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
	
	// The hashed password should be 128 characters long
	if (strlen($password) != 128) {
		$error_msg .= 'Invalid password configuration. Contact administrator.';
		
		echo "<script>alert('";
		echo $error_msg;
		echo "');</script>";
	}
 
 	// Check if email address already exists
	$query = "SELECT user_id FROM user_account WHERE email = ? LIMIT 1";
	$stmt = $connection->prepare($query);
	
	if ($stmt) {
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows == 1) {
			$error_msg .= 'An account with this email address already exists.';
			
			if ($_POST['page'] == '/edit-profile.php') {
				header('Location: http://play.perfectpickem.com/edit-profile?aemail=6112195');
			} else {
				header('Location: ../?register=duplicate');
			}
		}
	} else {
		$error_msg .= 'Database error. Contact administrator.';
		
		$stmt->close();
		
		echo "<script>alert('";
		echo $error_msg;
		echo "');</script>";
	}
 
 	// Perform password salt encryption
	if (empty($error_msg)) {
	
		$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
		$password = hash('sha512', $password . $random_salt);
		
		// Account already exists. Add email and password to account.
		if (isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != "") {
			$query = "UPDATE user_account SET email = ?, password = ?, salt = ? WHERE user_id = ?";

			$update = $connection->prepare($query);
			$update->bind_param('sssi', $email, $password, $random_salt, $_COOKIE['user_id']);
			
			$update->execute();
			$update->close();
			
			setcookie('email', $email, time()+3600*24*30, '/');
			
			header("Location: ./edit-profile?aemail=2018215");
		} else {
 
			// Insert user into database 
			if ($insert_stmt = $connection->prepare("INSERT INTO user_account (email, password, salt) VALUES (?, ?, ?)")) {
				
				$insert_stmt->bind_param('sss', $email, $password, $random_salt);
				$insert_stmt->execute();
				$insert_stmt->close();
			}
			
			// Get user id from new account
			$query = "SELECT user_id FROM user_account WHERE email = ?";
			
			$stmt = $connection->prepare($query);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			
			$stmt->bind_result($user_id);
			$stmt->fetch();
			$stmt->close();
			
			// Assign email cookie and set expiration time
			setcookie('user_id', $user_id, time()+3600*24*30, '/');
			setcookie('email', $email, time()+3600*24*30, '/');
			
			header('Location: ./register');
		}
	}
}
?>
