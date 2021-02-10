<?php
	include_once '../connect/db-connect.php';
    include_once 'functions.php';

	$user_id = intval($_COOKIE['user_id']);	
	$match_id = intval($_GET['match']);
	
	// Send notification email to admin
	$subject = "Match Quit";
	$txt = "User " . $user_id . " has left Match " . $match_id . ".";
	$headers = "From: Perfect Pick'em <admin@perfectpickem.com>";
	mail("admin@perfectpickem.com", $subject, $txt, $headers);
	
	$query = "SELECT deadline FROM matches WHERE match_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
    $stmt->execute();
    $stmt->bind_result($deadline);
	$stmt->fetch();
	
	$deadline = strtotime($deadline);
	$remaining = $deadline - time();
		
	$stmt->close();
		
	if ($remaining > 0) {
		if ($delete_stmt = $connection->prepare("DELETE FROM joined_matches WHERE user_id = ? AND match_id = ?")) {
			$delete_stmt->bind_param('ii', $user_id, $match_id);
			$delete_stmt->execute();
		}
		
		if ($delete_stmt = $connection->prepare("DELETE FROM match_answers WHERE user_id = ? AND match_id = ?")) {
			$delete_stmt->bind_param('ii', $user_id, $match_id);
			$delete_stmt->execute();
		}
		
		if ($delete_stmt = $connection->prepare("DELETE FROM match_tiebreaker_answers WHERE user_id = ? AND tiebreaker_id = ?")) {
			$delete_stmt->bind_param('ii', $user_id, $match_id);
			$delete_stmt->execute();
		} else {
			setcookie('match', 'closed', time() + 10, '/');
		}
		
		header ("Location: ../matches?qmatch=2018215");
	} else {
		header ("Location: ../matches?qmatch=6112195");
	}
?>
