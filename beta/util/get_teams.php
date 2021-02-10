<?php
include_once 'register.inc.php';
include_once 'functions.php';

$sport_id = intval($_GET['s']);
$selected_team = intval($_GET['t']);

$query = "SELECT team_id, team_name FROM teams WHERE sport_id = ? ORDER BY team_name";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $sport_id);

$stmt->execute();
$stmt->bind_result($team_id, $team_name);

while ($stmt->fetch()) {
	echo "<option value=\"";
	echo $team_id;
	echo "\">";
	echo $team_name;
	echo "</option>";
}
?>
