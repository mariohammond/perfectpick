<?php

require 'facebook.php';
require 'fb-functions.php';

$facebook = new Facebook(array('appId' => '688615697852514', 'secret' => 'b6a0d2bd02e399abf15638b9951c75bd'));

$user = $facebook->getUser();

if ($user) {
	try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}

    if (!empty($user_profile)) {
        // User profile information received
		$uid = $user_profile['id'];
		$user = new User();
        $userdata = $user->checkUser($uid);
 
 		if(!empty($userdata)) {
			session_start();
			
			$_SESSION['id'] = $uid; 
			$user_id = $userdata['user_id'];
			$email = $userdata['email'];
			$last_name = $userdata['last_name'];
			
			setcookie('user_id', $user_id, time() + 3600 * 24 * 30, '/');
			setcookie('email', $email, time() + 3600 * 24 * 30, '/');
			setcookie('connect_id', $uid, time() + 3600 * 24 * 30, '/');
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
	} else {
		// For testing purposes, if there was an error, let's kill the script
		die("There was an error.");
    }
} else {
	// There's no active session, let's generate one
	$login_url = $facebook->getLoginUrl(array( 'scope' => 'email'));
	header("Location: " . $login_url);
}
?>
