<?php

require 'facebook/facebook.php';
require 'config/fbconfig.php';
require 'config/fbfunctions.php';

$facebook = new Facebook(array('appId' => APP_ID, 'secret' => APP_SECRET));

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
			
			setcookie('user_id', $user_id, time()+3600*24*30, '/');
			setcookie('email', $email, time()+3600*24*30, '/');
			setcookie('connect_id', $uid, time()+3600*24*30, '/');
			setcookie('name', $last_name, time()+3600*24*30, '/');
			
			header("Location: ../home.php");
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
