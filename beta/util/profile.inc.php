<?php
include_once 'db_connect.php';
include_once 'db_config.php';
include_once 'functions.php';

if(!isset($_SESSION)) {
	sec_session_start();
}

if (isset($_POST['firstname'], $_POST['lastname'])) {

	// Sanitize and validate submitted data
	$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
	$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
	$sport_id = filter_input(INPUT_POST, 'favsport', FILTER_SANITIZE_STRING);
	$team_id = filter_input(INPUT_POST, 'favteam', FILTER_SANITIZE_STRING);
	
	// Upload submitted photo
	if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
		$uploadDir = 'uploads/';
	
		$fileName = time() . $_FILES['photo']['name'];
		$tmpName = $_FILES['photo']['tmp_name'];
		$fileSize = $_FILES['photo']['size'];
		$fileType = $_FILES['photo']['type'];
	
		$filePath = $uploadDir . $fileName;
	
		$result = move_uploaded_file($tmpName, $filePath);
			
	} else {
		$filePath = "uploads/no_image.png";
	}
	
	// Set default skill level
	$skill_level = "Rookie";
	
	// Insert new profile into database
	if ($insert_stmt = $mysqli->prepare("INSERT INTO user_profile (user_id, first_name, last_name, image, skill_level) VALUES (?, ?, ?, ?, ?)")) {
			$insert_stmt->bind_param('issss', $_COOKIE['user_id'], $firstname, $lastname, $filePath, $skill_level);
			if (!$insert_stmt->execute()) {
				echo "Database error.";
		}
		
		$insert_stmt->close();
	}
	
	if (isset($_POST['favsport']) && $_POST['favsport'] != "") {
		// Insert favorite sport/team into database
		if ($insert_stmt = $mysqli->prepare("INSERT INTO user_favorites (user_id, sport_id, team_id) VALUES (?, ?, ?)")) {
				$insert_stmt->bind_param('iss', $_COOKIE['user_id'], $sport_id, $team_id);
				if (!$insert_stmt->execute()) {
					echo "Database error.";
			}
			
			$insert_stmt->close();
		}
	}
	setcookie('name', $lastname, time()+3600*24*30, '/');
	header('Location: ./home.php');
}
?>
