<?php
// For Facebook and Twitter login
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'commish_dh');
define('DB_PASSWORD', 'fantasy1');
define('DB_DATABASE', 'voting_proposals');

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
