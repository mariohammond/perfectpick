<?php
ob_start();
require 'twitteroauth.php';
require 'tw-functions.php';
session_start();

if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
    // We've got everything we need (including custom app key and secret)
    $twitteroauth = new TwitterOAuth('YNazY4OLAMbVZkh1iK7HyC7JR', 'uXiXuqABKaqNYPzsWrVGl9cPgimWWOh5LipyPejlDoJ75sYdzW', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	// Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
	// Save it in a session var
    $_SESSION['access_token'] = $access_token;
	// Let's get the user's info
    $user_info = $twitteroauth->get('account/verify_credentials');
	
	// Print user's info
    //echo '<pre>';
   	//print_r($user_info);
    //echo '</pre><br/>';
	
    if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: login.php');
    } else {
		$twitter_otoken = $_SESSION['oauth_token'];
		$twitter_otoken_secret = $_SESSION['oauth_token_secret'];
		$email = '';
		$uid = $user_info->id;
		$username = $user_info->name;
		$user = new User();
		$userdata = $user->checkUser($uid);
		
        if(!empty($userdata)) {
			session_start();
			
			$_SESSION['id'] = $uid; 
			$user_id = $userdata['user_id'];
			$email = $userdata['email'];
			$last_name = $userdata['last_name'];
			
			setcookie('user_id', $user_id, time() + 3600 * 24 * 30, '/');
			setcookie('connect_id', $uid, time() + 3600 * 24 * 30, '/');
			setcookie('email', $email, time() + 3600 * 24 * 30, '/');
			setcookie('name', $last_name, time() + 3600 * 24 * 30, '/');
			
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
        }
    }
} else {
    // Something's missing, go back to square 1
    header('Location: login.php');
}
?>
