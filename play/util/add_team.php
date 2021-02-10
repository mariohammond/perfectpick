<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	include_once '../connect/db-connect.php';
    include_once 'functions.php';
	
    sec_session_start();

	$user_id = intval($_COOKIE['user_id']);	
	$sport_id = intval($_GET['s']);
	$team_id = intval($_GET['t']);
	
	$team_exist = $connection->query("SELECT COUNT(team_id) as teamcount FROM user_favorites WHERE user_id = $user_id AND team_id = $team_id")->fetch_object()->teamcount;

	if(!$team_exist) {
		if ($insert_stmt = $connection->prepare("INSERT INTO user_favorites (user_id, sport_id, team_id) VALUES (?, ?, ?)")) {
			$insert_stmt->bind_param('iii', $user_id, $sport_id, $team_id );
		   
			if (!$insert_stmt->execute()) {
				header ("Location: ../edit-profile?ateam=6112195");
			} else {
				header ("Location: ../edit-profile?ateam=2018215");
			}
		}
	}
?>
