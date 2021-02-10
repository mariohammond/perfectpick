<?php
include_once 'functions.php';

if (isset($_POST['firstname'], $_POST['lastname'])) {

	$first_name = ($_POST['firstname']);
	$last_name = ($_POST['lastname']);
	
	$query = "UPDATE user_profile SET first_name = ?, last_name = ? WHERE user_id = ?";
	
	$update = $mysqli->prepare($query);
	$update->bind_param('ssi', $first_name, $last_name, $_COOKIE['user_id']);
	
	if($update->execute()) {
		
		$update->close();
		header("Location: ../editprofile.php?nchange=2018215");
		
	} else {
		
		$update->close();
		header("Location: ../editprofile.php?nchange=6112195");
	}
}
?>
