<?php
// For Facebook and Twitter login
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'pickem_user');
define('DB_PASSWORD', 'Pickem#1');
define('DB_DATABASE', 'perfect_pickem_db');

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
