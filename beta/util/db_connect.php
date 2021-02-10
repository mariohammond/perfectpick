<?php
include_once 'db_config.php';
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
}
?>
