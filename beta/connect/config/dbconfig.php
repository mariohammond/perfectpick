<?php
// For Facebook and Twitter login
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'pickem_user');
define('DB_PASSWORD', 'Pickem#1');
define('DB_DATABASE', 'perfect_pickem_db');

$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());

// For Google Plus login
$db_username = "pickem_user";
$db_password = "Pickem#1";
$hostname = "localhost";
$db_name = 'perfect_pickem_db';
?>
