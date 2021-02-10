<?php 
	include_once '../connect/db-connect.php';
    include_once 'functions.php';
	
	session_start();
	
	$userId = $_COOKIE['user_id'];
	$matchId = $_GET['matchId'];
	
	$questionsCount = getQuestions($connection, $matchId);
	
	$q1 = filter_input(INPUT_POST, 'q1', FILTER_SANITIZE_STRING); $q2 = filter_input(INPUT_POST, 'q2', FILTER_SANITIZE_STRING);
	$q3 = filter_input(INPUT_POST, 'q3', FILTER_SANITIZE_STRING); $q4 = filter_input(INPUT_POST, 'q4', FILTER_SANITIZE_STRING);
	$q5 = filter_input(INPUT_POST, 'q5', FILTER_SANITIZE_STRING); $q6 = filter_input(INPUT_POST, 'q6', FILTER_SANITIZE_STRING);
	$q7 = filter_input(INPUT_POST, 'q7', FILTER_SANITIZE_STRING); $q8 = filter_input(INPUT_POST, 'q8', FILTER_SANITIZE_STRING);
	$q9 = filter_input(INPUT_POST, 'q9', FILTER_SANITIZE_STRING); $q10 = filter_input(INPUT_POST, 'q10', FILTER_SANITIZE_STRING); 
	$q11 = filter_input(INPUT_POST, 'q11', FILTER_SANITIZE_STRING); $q12 = filter_input(INPUT_POST, 'q12', FILTER_SANITIZE_STRING);
	$q13 = filter_input(INPUT_POST, 'q13', FILTER_SANITIZE_STRING); $q14 = filter_input(INPUT_POST, 'q14', FILTER_SANITIZE_STRING);
	$q15 = filter_input(INPUT_POST, 'q15', FILTER_SANITIZE_STRING); $q16 = filter_input(INPUT_POST, 'q16', FILTER_SANITIZE_STRING);
	$q17 = filter_input(INPUT_POST, 'q17', FILTER_SANITIZE_STRING); $q18 = filter_input(INPUT_POST, 'q18', FILTER_SANITIZE_STRING);
	$q19 = filter_input(INPUT_POST, 'q19', FILTER_SANITIZE_STRING); $q20 = filter_input(INPUT_POST, 'q20', FILTER_SANITIZE_STRING);
	$tb = filter_input(INPUT_POST, 'tiebreaker', FILTER_SANITIZE_STRING);
	
	$qAll = array();
	array_push($qAll, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10, $q11, $q12, $q13, $q14, $q15, $q16, $q17, $q18, $q19, $q20);
	
	// Save answers to database
	for($i = 0; $i < $questionsCount; $i++) {
		$question_id = $i + 1;
		savePicks($connection, $userId, $matchId, $question_id, $qAll[$i]);
	}
	
	// Save tiebreaker to database
	saveTiebreaker($connection, $userId, $matchId, $tb);
	
	// Redirect to match page
	header ("Location: ../match?matchId=" . $matchId);
?>
