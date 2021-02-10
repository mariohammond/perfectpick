<?php 
	require_once 'lib/src/Google_Client.php';
	require 'lib/src/contrib/Google_Oauth2Service.php';
	require_once 'lib/src/contrib/Google_PlusService.php';
	   
	session_start();	   
	$api = new Google_Client();
	$api->setApplicationName("Perfect Pickem");     // Enter Appication Name
	$api->setClientId('352375319497-i3d93cgkgnjr626jrrulvees3corkp1v.apps.googleusercontent.com');   // Enter Client ID
	$api->setClientSecret('JJh6cmzM4ASwPbKmfE2C0sX8');    // Enter Client Secret
	$api->setAccessType('online');
	$api->setScopes(array('https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/plus.me', 'https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));
	$api->setRedirectUri('http://www.perfectpickem.com');   // Enter redirect URI
	$service = new Google_PlusService($api);
	$URI = $api->createAuthUrl();
	
	//$user_id = $user_data['user_id'];
	$email = $user_data['email']; echo '<script>alert(' . $email . ')</script>';
	$name = $user_data['name'];
	
	//setcookie('user_id', $user_id, time() + 3600 * 24 * 30, '/');
	setcookie('email', $email, time() + 3600 * 24 * 30, '/');
	//setcookie('connect_id', $uid, time() + 3600 * 24 * 30, '/');
	setcookie('name', $last_name, time() + 3600 * 24 * 30, '/');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login with Google Plus Oauth - InfoTuts</title>
    <link rel="stylesheet" type="text/css" media="all" href="style.css">
</head>
<body>
<div id="mhead">
	<h2>Login with Google Plus Oauth - InfoTuts </h2>
</div>
<div id="gplus" onclick="login()">
	<img src="InfoTuts-google-login-oauth.png" alt="Login with google" />
</div>
</body>
 
<script>
function login() {
	var w_left = (screen.width);
	var w_top = (screen.height);
	window.open('<?php echo $URI; ?>','targetWindow');
 }
</script>
