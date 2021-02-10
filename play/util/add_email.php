<?php
include_once '../connect/db-connect.php';
//include_once 'functions.php';

if(!isset($_SESSION)) {
	session_start();
}

$email = $_GET['email'];
$success = "Thank you for signing up for the Pick'em newsletter! You should receive your first newsletter soon.";
$failure = "There was an error with the newsletter signup. Please try again.";

if (isset($email) && $email != "") {
    $query = "SELECT email_address FROM newsletter_signup WHERE email_address = ?";
	$stmt = $connection->prepare($query);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	
	$stmt->store_result();
	$stmt->bind_result($email);
	$stmt->fetch();
	
	if ($stmt->num_rows == 1) {
		$stmt->close();
		echo $success;
	} else {
		$stmt->close();
		$query = "INSERT INTO newsletter_signup (email_address) VALUES (?)";
		
		$insert_stmt = $connection->prepare($query);
		$insert_stmt->bind_param('s', $email);
		$insert_stmt->execute();
		$insert_stmt->close();
		echo $success;
	}
} else { 
    echo $failure;
}
?>
