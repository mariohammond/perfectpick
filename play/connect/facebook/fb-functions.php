<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

require '../db-connect.php';

class User {
	function checkUser($uid) {
		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		
		// Check if user's facebook id is already in db
	   	$query = mysqli_query($connection, "SELECT a.user_id, a.facebook_id, a.email, b.last_name FROM user_account a, user_profile b WHERE facebook_id = '$uid' AND a.user_id = b.user_id");
        $result = mysqli_fetch_array($query);
		
        if (empty($result)) {
			// If not, but user is already in db, add facebook id to account
			if (isset($_COOKIE['user_id']) && $_COOKIE['user_id']) {
				$cookie_id = $_COOKIE['user_id'];
				$query = mysqli_query($connection, "UPDATE user_account SET facebook_id = '$uid' WHERE user_id = $cookie_id");
				$result = mysqli_fetch_array($query);
				
				setcookie('connect_id', $uid, time() + 3600 * 24 * 30, '/');
				header('Location: ../../edit-profile?alink=61352151511');
				
			} else {
				// If not and user not in db, add facebook id to account
				$query = mysqli_query($connection, "SELECT * FROM user_account WHERE facebook_id = '$uid'");
				$result = mysqli_fetch_array($query);
				
				if (empty($result)) {
					// Add new account with new facebook id
					$query = "INSERT INTO user_account (facebook_id) VALUES ('$uid')";
					mysqli_query($connection, $query);
					
					// Return user info from database
					$query = mysqli_query($connection, "SELECT * FROM user_account WHERE facebook_id = '$uid'");
					$result = mysqli_fetch_array($query);
					
					return $result;
				}
			}
		}
		
		return $result;
	}
}
?>
