<?php
require 'dbconfig.php';

class User {

   function checkUser($uid) {
        $query = mysql_query("SELECT a.user_id, a.facebook_id, a.email, b.last_name FROM user_account a, user_profile b WHERE facebook_id = '$uid' AND a.user_id = b.user_id") or die(mysql_error());
        $result = mysql_fetch_array($query);
		
        if (!empty($result)) {
            // User already in database
        } else {
		
			if(isset($_COOKIE['user_id']) && $_COOKIE['user_id']) {
				$cookie_id = $_COOKIE['user_id'];
				$query = mysql_query("UPDATE user_account SET facebook_id = '$uid' WHERE user_id = $cookie_id") or die(mysql_error());
				$result = mysql_fetch_array($query);
				
				setcookie('connect_id', $uid, time()+3600*24*30, '/');
				header('Location: ../editprofile.php?alink=61352151511');
				
			} else {
			
				$query = mysql_query("SELECT * FROM user_account WHERE facebook_id = '$uid'") or die(mysql_error());
				$result = mysql_fetch_array($query);
				if (!empty($result)) {
				// User already in database
				} else {
					// Add new user to database
					$query = mysql_query("INSERT INTO user_account (facebook_id) VALUES ('$uid')") or die(mysql_error());
					
					// Return user info from database
					$query = mysql_query("SELECT * FROM user_account WHERE facebook_id = '$uid'") or die(mysql_error());
					$result = mysql_fetch_array($query);
					
					return $result;
				}
			}
		}
		
		return $result;
    }
}
?>
