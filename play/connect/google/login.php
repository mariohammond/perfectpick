<?php

require '../db-connect.php';
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

class G_login {
	
	function lib_include() {
		require_once 'lib/src/Google_Client.php';
		require 'lib/src/contrib/Google_Oauth2Service.php';
		require_once 'lib/src/contrib/Google_PlusService.php';
	}
	   
	function login() {
		if(!isset($_SESSION)) {
			session_start();
		}
		   
		$this->lib_include();
		
	    $api = new Google_Client();
        $api->setApplicationName("Perfect Pickem");
        $api->setClientId('352375319497-i3d93cgkgnjr626jrrulvees3corkp1v.apps.googleusercontent.com');   // Enter Client ID
        $api->setClientSecret('JJh6cmzM4ASwPbKmfE2C0sX8');    // Enter Client Secret
        $api->setAccessType('online');
        $api->setScopes(array('https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));
        $api->setRedirectUri('http://play.perfectpickem.com/connect/google/login.php');   // Enter redirect URI
		$api->setApprovalPrompt('auto');
		
        $service = new Google_PlusService($api);
        $oauth2 = new Google_Oauth2Service($api);
		
        $api->authenticate();
		
		$_SESSION['token'] = $api->getAccessToken();		
		if (isset($_SESSION['token'])) {
            $set_asess_token = $api->setAccessToken($_SESSION['token']);
		}        
        if ($api->getAccessToken()) {
            $data = $service->people->get('me');
            $user_data = $oauth2->userinfo->get();  
			
			// Get Google ID
			$uid = $user_data['id'];
			
			// Setup DB connection
			$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
			
			// Check if user's google id is already in DB
			$query = mysqli_query($connection, "SELECT a.user_id, b.last_name FROM user_account a, user_profile b WHERE a.google_id = '$uid' AND a.user_id = b.user_id");
			$result = mysqli_fetch_array($query);
	
			 if (empty($result)) {
				 // Check if existing user is adding google id to account
				 if (isset($_COOKIE['user_id'])) {
					$cookie_id = $_COOKIE['user_id'];
					$query = mysqli_query($connection, "UPDATE user_account SET google_id = '$uid' WHERE user_id = $cookie_id");
					$update = mysqli_fetch_array($query);
					
					// Return user info from database
					$query = mysqli_query($connection, "SELECT a.user_id, b.last_name FROM user_account a, user_profile b WHERE a.google_id = '$uid' AND a.user_id = b.user_id");
					$result = mysqli_fetch_array($query);
				} else {
					// Add new account with new google id
					$query = "INSERT INTO user_account (google_id) VALUES ($uid)";
					mysqli_query($connection, $query);
					
					// Return user info from database
					$query = mysqli_query($connection, "SELECT * FROM user_account WHERE google_id = '$uid'");
					$result = mysqli_fetch_array($query);
				}
			}
			
			$user_id = $result['user_id'];
			$last_name = $result['last_name'];
			
			setcookie('connect_id', $uid, time() + 3600 * 24 * 30, '/');
			setcookie('name', $last_name, time() + 3600 * 24 * 30, '/');
			setcookie('user_id', $user_id, time() + 3600 * 24 * 30, '/');
			
			// Redirect back to same address
			$ref = substr($_SESSION['ref'], 0, -4);
			$query = $_SESSION['query'];
			
			if ($ref == '' || $ref == '/index') {
				header("Location: http://play.perfectpickem.com/profile");
			} else  {
				if (strpos($query, 'signin') !== false) {
					header("Location: http://play.perfectpickem.com" . $ref);
				} else {
					header("Location: http://play.perfectpickem.com" . $ref . '?' . $query);
				}
			}
			
		} // end if statement
	} // end login() 
} // end class

$obj= New G_login();
$obj->login();

?>
