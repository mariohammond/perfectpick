<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
include_once './connect/db-connect.php';
include_once 'functions.php';

if (isset($_POST['firstname'], $_POST['lastname'])) {

	$first_name = ($_POST['firstname']);
	$last_name = ($_POST['lastname']);
	
	$query = "UPDATE user_profile SET first_name = ?, last_name = ? WHERE user_id = ?";
	
	$update = $connection->prepare($query);
	$update->bind_param('ssi', $first_name, $last_name, $_COOKIE['user_id']);
	
	if($update->execute()) {
		
		$update->close();
		header("Location: ../edit-profile?nchange=2018215");
		
	} else {
		
		$update->close();
		header("Location: ../edit-profile?nchange=6112195");
	}
}
?>
