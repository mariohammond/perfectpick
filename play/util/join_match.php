<?php
	include_once '../connect/db-connect.php';
    include_once 'functions.php';

	if (!isset($_COOKIE['user_id'])) {
		header ("Location: ../matches?signin=6112195");	
	} else {
		$user_id = intval($_COOKIE['user_id']);
		$match_id = intval($_GET['matchId']);
		
		// Send notification email to admin
		$subject = "New Match Joined!";
		$txt = "User " . $user_id . " has joined Match " . $match_id . ".";
		$headers = "From: Perfect Pick'em <admin@perfectpickem.com>";
		mail("admin@perfectpickem.com", $subject, $txt, $headers);
					
		$question_id = 0;
		$user_answer = "Yes";
		
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
			$matchJoined = checkMatchJoin($connection, $match_id, $user_id);
			
			if ($matchJoined) {
				header ("Location: ../matches?jmatch=duplicate");
			} else {
		
				if ($insert_stmt = $connection->prepare("INSERT INTO joined_matches (user_id, match_id) VALUES (?, ?)")) {
					$insert_stmt->bind_param('ii', $user_id, $match_id);
					$insert_stmt->execute();
					
					if ($insert_stmt = $connection->prepare("INSERT INTO match_answers (user_id, match_id, question_id, user_answer) VALUES (?, ?, ?, ?)")) {
						$insert_stmt->bind_param('iiis', $user_id, $match_id, $question_id, $user_answer);
						$insert_stmt->execute();
					}
				}
				
				header ("Location: ../match-picks?matchId=" . $match_id);
			}
		} else {
			setcookie('match', 'closed', time() + 10, '/');
			header ("Location: ../matches?jmatch=6112195");
		}
	}
?>
