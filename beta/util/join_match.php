<?php
	include_once 'db_connect.php';
    include_once 'functions.php';
	
    sec_session_start();

	$user_id = intval($_COOKIE['user_id']);	
	$match_id = intval($_GET['match']);
	$question_id = 0;
	$user_answer = "Yes";
	
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
		if ($insert_stmt = $mysqli->prepare("INSERT INTO joined_matches (user_id, match_id) VALUES (?, ?)")) {
			$insert_stmt->bind_param('ii', $user_id, $match_id);
			$insert_stmt->execute();
			
			if ($insert_stmt = $mysqli->prepare("INSERT INTO match_answers (user_id, match_id, question_id, user_answer) VALUES (?, ?, ?, ?)")) {
				$insert_stmt->bind_param('iiis', $user_id, $match_id, $question_id, $user_answer);
				$insert_stmt->execute();
			}
		}
	} else {
		setcookie('match', 'closed', time()+10, '/');
	}
?>
