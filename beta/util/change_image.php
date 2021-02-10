<?php
include_once 'db_connect.php';
include_once 'db_config.php';
include_once 'functions.php';

if(!isset($_SESSION)) {
	sec_session_start();
}

if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
	$uploadDir = 'uploads/';

	$fileName = time() . $_FILES['photo']['name'];
	$tmpName = $_FILES['photo']['tmp_name'];
	$fileSize = $_FILES['photo']['size'];
	$fileType = $_FILES['photo']['type'];

	$filePath = $uploadDir . $fileName;

	$result = move_uploaded_file($tmpName, $filePath);
	changeImage($mysqli, $filePath, $_COOKIE['user_id']);
}
?>
