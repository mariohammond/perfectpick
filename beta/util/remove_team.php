<?php
	include_once 'db_connect.php';
    include_once 'functions.php';
	
    sec_session_start();

	$user_id = intval($_COOKIE['user_id']);	
	$team_id = intval($_GET['t']);

	if ($insert_stmt = $mysqli->prepare("DELETE FROM user_favorites WHERE user_id = ? AND team_id = ?")) {
		$insert_stmt->bind_param('ii', $user_id, $team_id );
	   
		if (!$insert_stmt->execute()) {
			header ("Location: ../editprofile.php?rteam=6112195");
		} else {
			header ("Location: ../editprofile.php?rteam=2018215");
		}
	}
?>
