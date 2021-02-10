<?php
ob_start();
require 'config/dbconfig.php';
require 'config/gpconfig.php';
require_once 'google/Google_Client.php';
require_once 'google/contrib/Google_Oauth2Service.php';

if(!isset($_SESSION)) {
		session_start();
	}


$gClient = new Google_Client();
$gClient->setApplicationName('Login to Perfect Pickem');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);
//$gClient->setApprovalPrompt($google_approval_prompt);

$google_oauthV2 = new Google_Oauth2Service($gClient);

// If code is empty, redirect user to google authentication page for code.
// Once we have access token, assign token to session variable and we can redirect user back to page and login.
if (isset($_GET['code'])) { 
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
	return;
}

if (isset($_SESSION['token'])) { 
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	  //For logged in user, get details from google using access token
	  $user 				= $google_oauthV2->userinfo->get();
	  $uid 					= $user['id'];
	  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	  $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	  $profile_url 			= filter_var($user['link'], FILTER_VALIDATE_URL);
	  $profile_image_url 	= filter_var($user['picture'], FILTER_VALIDATE_URL);
	  $personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
	  $_SESSION['token'] 	= $gClient->getAccessToken();
} else {
	//For Guest user, get google login url
	$authUrl = $gClient->createAuthUrl();
}

if(isset($authUrl)) {
	//echo '<a class="login" href="'.$authUrl.'"><img src="images/google-login-button.png" /></a>';
} else {
	// Connect to database using mysqli */
	$mysqli = new mysqli($hostname, $db_username, $db_password, $db_name);
	
	if ($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}
	
	// Look for user account in database
	$user_exist = $mysqli->query("SELECT COUNT(google_id) as usercount FROM user_account WHERE google_id = $uid")->fetch_object()->usercount;
	
	if($user_exist){ // Found. Set cookies and redirect.
	
		$query = mysqli_query($mysqli, "SELECT a.user_id, a.email, b.last_name FROM user_account a, user_profile b WHERE google_id = '$uid' AND a.user_id = b.user_id");
		$result = mysqli_fetch_array($query);
		
		setcookie('user_id', $result['user_id'], time()+3600*24*30, '/');
		setcookie('connect_id', $uid, time()+3600*24*30, '/');
		setcookie('email', $result['email'], time()+3600*24*30, '/');
		setcookie('name', $result['last_name'], time()+3600*24*30, '/');
		
		header('Location: ../home.php');
	} else { // Not found. Create new user, set cookies, and redirect.
	
		if(isset($_COOKIE['user_id']) && $_COOKIE['user_id']) {
			$cookie_id = $_COOKIE['user_id'];
			$mysqli->query("UPDATE user_account SET google_id = '$uid' WHERE user_id = $cookie_id");
			header('Location: ../editprofile.php?alink=720207125');
			
		} else {
	
			$mysqli->query("INSERT INTO user_account (google_id) VALUES ($uid)");
			setcookie('connect_id', $uid, time()+3600*24*30, '/');
			
			$query = mysqli_query($mysqli, "SELECT user_id FROM user_account WHERE google_id = '$uid'");
			$result = mysqli_fetch_array($query);
			setcookie('user_id', $result['user_id'], time()+3600*24*30, '/');
			
			header('Location: ../home.php');
		}
	}

	// Display user Google details
	// echo '<pre>'; 
	// print_r($user);
	// echo '</pre>';
}
?>
