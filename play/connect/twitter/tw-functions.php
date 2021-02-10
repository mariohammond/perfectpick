<?php

require '../db-connect.php';

class User {
	function checkUser($uid) {
		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		
		// Check if user's twitter id is already in db
	   	$query = mysqli_query($connection, "SELECT a.user_id, a.twitter_id, a.email, b.last_name FROM user_account a, user_profile b WHERE twitter_id = '$uid' AND a.user_id = b.user_id");
        $result = mysqli_fetch_array($query);
		
        if (empty($result)) {
			// If not, but user is already in db, add twitter id to account
			if (isset($_COOKIE['user_id']) && $_COOKIE['user_id']) {
				$cookie_id = $_COOKIE['user_id'];
				$query = mysqli_query($connection, "UPDATE user_account SET twitter_id = '$uid' WHERE user_id = $cookie_id");
				$result = mysqli_fetch_array($query);
				
				setcookie('connect_id', $uid, time() + 3600 * 24 * 30, '/');
				header('Location: ../../edit-profile?alink=202392020518');
				
			} else {
				// If not and user not in db, add twitter id to account
				$query = mysqli_query($connection, "SELECT * FROM user_account WHERE twitter_id = '$uid'");
				$result = mysqli_fetch_array($query);
				
				if (empty($result)) {
					// Add new account with new twitter id
					$query = "INSERT INTO user_account (twitter_id) VALUES ('$uid')";
					mysqli_query($connection, $query);
					
					// Return user info from database
					$query = mysqli_query($connection, "SELECT * FROM user_account WHERE twitter_id = '$uid'");
					$result = mysqli_fetch_array($query);
					
					return $result;
				}
			}
		}
		
		return $result;
	}
}
?>
