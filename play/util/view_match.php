<?php
	include_once '../connect/db-connect.php';
	include_once 'functions.php';
	
	$match = getMatchInfo($connection, $_GET['match_id']);
	$points = getAvailablePoints($connection, $_GET['match_id']);
	$questions = getQuestionCount($connection, $_GET['match_id']);
	
	echo "<h1>" . $match['title'] . "</h1>";
	echo "<h2>" . $match['date'] . " - " . $match['time'] . " EST</h2>";
	echo "<p>Total Questions: " . $questions . "</p>";
	echo "<p>Points Available: " . $points . "</p>";
	echo "<p>Current Players: " . $match['players'] . "</p>";
	echo "<p>Deadline: " . $match['deadline'] . "</p>";
?>
