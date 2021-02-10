<?php

// Redirect for social connect
/*if (array_key_exists("login", $_GET)) {
	$oauth_provider = $_GET['oauth_provider'];
	if ($oauth_provider == 'twitter') {
		header('Location: http://play.perfectpickem.com/connect/twitter/login.php?ref=' . $_SERVER['PHP_SELF'] . '&query=' . $_SERVER['QUERY_STRING']);
	} else if ($oauth_provider == 'facebook') {
		header('Location: http://play.perfectpickem.com/connect/facebook/login.php?ref=' . $_SERVER['PHP_SELF']);
	} else if ($oauth_provider == 'google') {
		header('Location: http://play.perfectpickem.com/connect/google/login.php?ref=' . $_SERVER['PHP_SELF']);
	} 
}

if (!isset($_COOKIE['connect_id'])) {
	include_once 'http://play.perfectpickem.com/connect/google/login.php?ref=' . $_SERVER['PHP_SELF'];
}*/

// Send to register page if name is not set
if (isset($_COOKIE['email']) || isset($_COOKIE['connect_id'])) {
	$signedIn = true;
	
	if (!isset($_COOKIE['name'])) {
		header('Location: http://play.perfectpickem.com/register');
	}
}
?>
