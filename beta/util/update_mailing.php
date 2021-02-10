<?php
	include_once 'db_connect.php';
    include_once 'functions.php';
	
    sec_session_start();

	$user_id = intval($_COOKIE['user_id']);	
	$mailing_list = $_GET['m'];

	if ($insert_stmt = $mysqli->prepare("UPDATE user_profile SET mailing_list = ? WHERE user_id = ?")) {
		$insert_stmt->bind_param('si', $mailing_list, $user_id );
	   
		if (!$insert_stmt->execute()) {
			header ("Location: ../editprofile.php?mlist=6112195");
		} else {
			header ("Location: ../editprofile.php?mlist=2018215");
		}
	}
?>
