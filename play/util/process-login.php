<?php
include_once '../connect/db-connect.php';
include_once 'functions.php';

if(!isset($_SESSION)) {
	sec_session_start();
}

if (isset($_POST['email'], $_POST['p'])) {
    
    $email = $_POST['email'];
    $password = $_POST['p'];
		
	$count = checkFailLog($email, $connection);
 		
	// If there have been more than 5 failed logins 
	if ($count > 5) {
		header('Location: ../?login=locked');
	} else {
		if (login($email, $password, $connection) == true) {
			// Login success. Get user id.
			$query = "SELECT user_id FROM user_account WHERE email = ?";
			$stmt = $connection->prepare($query);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			
			$stmt->store_result();
			$stmt->bind_result($user_id);
			$stmt->fetch();
			$stmt->close();
			
			//Get user last name.
			$query = "SELECT last_name FROM user_profile WHERE user_id = ?";
			$stmt = $connection->prepare($query);
			$stmt->bind_param('s', $user_id);
			$stmt->execute();
			
			$stmt->store_result();
			$stmt->bind_result($last_name);
			$stmt->fetch();
			$stmt->close();
			
			//Set user cookies.
			setcookie('email', $email, time() + 3600 * 24 * 30, '/');
			setcookie('user_id', $user_id, time() + 3600 * 24 * 30, '/');
			setcookie('name', $last_name, time() + 3600 * 24 * 30, '/');
			
			header('Location: ../profile');
			
		} else {
			// Login failed
			header('Location: ../?login=false');
		}
	}
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}
?>
