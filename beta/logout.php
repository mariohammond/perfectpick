<?php
include_once 'util/functions.php';
sec_session_start();
 
// Unset all session values 
$_SESSION = array();
 
// Get session parameters 
$params = session_get_cookie_params();
 
// Delete cookies 
setcookie(session_name(),
        '', time() - 42000, 
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]);

setcookie("PHPSESSID", "", time()-3600, "/");
setcookie("user_id", "", time()-3600, "/");
setcookie("connect_id", "", time()-3600, "/");
setcookie("email", "", time()-3600, "/");
setcookie("name", "", time()-3600, "/");
 
// Destroy session 
session_destroy();
header('Location: ../index.php?logout=true');
?>
