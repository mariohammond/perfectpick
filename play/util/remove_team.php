<?php
	include_once '../connect/db-connect.php';
    include_once 'functions.php';
	
    sec_session_start();

	$user_id = intval($_COOKIE['user_id']);	
	$team_id = intval($_GET['t']);

	if ($insert_stmt = $connection->prepare("DELETE FROM user_favorites WHERE user_id = ? AND team_id = ?")) {
		$insert_stmt->bind_param('ii', $user_id, $team_id );
	   
		if (!$insert_stmt->execute()) {
			header ("Location: ../edit-profile?rteam=6112195");
		} else {
			header ("Location: ../edit-profile?rteam=2018215");
		}
	}
?>
