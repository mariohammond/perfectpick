<?php
function getNextMatch($connection) {
	$query = "SELECT a.title FROM matches a WHERE a.status = 'open' ORDER BY a.match_id DESC LIMIT 1";

	$stmt = $connection->prepare($query);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($title);
	$stmt->fetch();
	
	if ($stmt->num_rows == 1) {
		return $title;
	} else {
		return "None currently available";
	}
	
	$stmt->close();
	
	return $title;
}

function getRanking($connection, $time_frame) {
	$currentDate = date_parse_from_format("Y-m-d", date("Y-m-d"));
	$currentYear = $currentDate["year"];
	$currentMonth = $currentDate["month"];
	
	$query = "SELECT a.user_id, b.first_name, b.last_name, SUM(a.total_points) as sum FROM match_stats a, user_profile b WHERE a.user_id = b.user_id ";
	if ($time_frame == "Year") {
		$query .= "AND YEAR(a.match_date) = " . $currentYear . " ";
	}
	
	if ($time_frame == "Month") {
		$query .= "AND YEAR(a.match_date) = " . $currentYear . " AND MONTH(a.match_date) = " . $currentMonth . " ";
	}
	
	$query .= "GROUP BY a.user_id ORDER BY sum DESC";
	
	$stmt = $connection->prepare($query);
	$stmt->execute();
	$stmt->bind_result($userId, $firstName, $lastName, $matchPoints);
	
	while($stmt->fetch()) {
		$allIds[] = $userId;
		$allFirsts[] = $firstName;
		$allLasts[] = $lastName;
		$allPoints[] = $matchPoints;
	}
	
	$allMatchPoints['id'] = $allIds;
	$allMatchPoints['first_name'] = $allFirsts;
	$allMatchPoints['last_name'] = $allLasts;
	$allMatchPoints['points'] = $allPoints;
	$stmt->close();
	
	return $allMatchPoints;
}

function getUpcomingMatches($connection) {
	$query = "SELECT match_id, title, deadline FROM matches ORDER BY match_id DESC LIMIT 3";
	
	$stmt = $connection->prepare($query);
	$stmt->execute();
	$stmt->bind_result($matchId, $title, $deadline);
	
	while($stmt->fetch()) {
		$ids[] = $matchId;
		$titles[] = $title;
		
		$deadline = strtotime($deadline);
		$seconds = $deadline - time();
		
		$remainingDays = floor($seconds / 86400);
		$remainingHours = floor(($seconds % 86400) / 3600);
		$remainingMinutes = floor((($seconds % 86400) % 3600) / 60);
		$remainingSeconds = floor((($seconds % 86400) % 3600) % 60);
		
		$remaining = $remainingDays . " Days " . $remainingHours . " Hrs " . $remainingMinutes . " Min " . $remainingSeconds . " Sec ";
		
		$deadlines[] = $remaining;
	}
	
	$matches["id"] = $ids;
	$matches["title"] = $titles;
	$matches["deadline"] = $deadlines;
	
	$stmt->close();
	return $matches;
}

function getRelatedMatch($connection, $category) {
	$query = "SELECT a.match_id, a.title FROM matches a, sports b WHERE a.status = 'open' AND a.sport_id = b.sport_id AND b.sport_name = ? ORDER BY a.deadline LIMIT 1";
		
	$stmt = $connection->prepare($query);
	$stmt->bind_param('s', $category);
	$stmt->execute();
	$stmt->bind_result($matchId, $title);
	$stmt->fetch();
	$stmt->close();
	
	$relatedMatch['match_id'] = $matchId;
	$relatedMatch['title'] = $title;
	
	return $relatedMatch;
}
?>
