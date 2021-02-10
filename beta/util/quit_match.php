<?php
	include_once 'db_connect.php';
    include_once 'functions.php';
	
    sec_session_start();

	$user_id = intval($_COOKIE['user_id']);	
	$match_id = intval($_GET['match']);
	
	$query = "SELECT deadline FROM matches WHERE match_id = ?";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $match_id);
    $stmt->execute();
    $stmt->bind_result($deadline);
	$stmt->fetch();
	
	$deadline = strtotime($deadline);
	$remaining = $deadline - time();
		
	$stmt->close();
		
	if($remaining > 0) {
		if ($delete_stmt = $mysqli->prepare("DELETE FROM joined_matches WHERE user_id = ? AND match_id = ?")) {
			$delete_stmt->bind_param('ii', $user_id, $match_id);
			$delete_stmt->execute();
		} if ($delete_stmt = $mysqli->prepare("DELETE FROM match_answers WHERE user_id = ? AND match_id = ?")) {
			$delete_stmt->bind_param('ii', $user_id, $match_id);
			$delete_stmt->execute();
		} if ($delete_stmt = $mysqli->prepare("DELETE FROM match_tiebreaker_answers WHERE user_id = ? AND tiebreaker_id = ?")) {
			$delete_stmt->bind_param('ii', $user_id, $match_id);
			$delete_stmt->execute();
		} else {
			setcookie('match', 'closed', time()+10, '/');
		}
	}
?>
