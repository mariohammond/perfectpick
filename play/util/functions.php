<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

ob_start();

include_once '../connect/db-connect.php';

/******* Global Functions: Start *******/
function sec_session_start() {
	
	// Set session name and settings
    $session_name = 'sec_session_id';
    $secure = SECURE;
    $httponly = true;
	
    // Forces sessions to only use cookies.
    /*if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../index.php");
        exit();
    }*/
	
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure,  $httponly);
	
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // Regenerate the session, delete the old one.
}

function login($email, $password, $mysqli) {
    if ($stmt = $mysqli->prepare("SELECT password, salt FROM user_account WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
		
        $stmt->store_result();
        $stmt->bind_result($db_password, $salt);
        $stmt->fetch();
 
        // Hash password with appended salt
        $password = hash('sha512', $password . $salt);
		
        if ($stmt->num_rows == 1) {
			if ($db_password == $password) {
				return true;
			} else {
				// Record failed attempt in database
				$now = time();
				if ($insert_stmt = $mysqli->prepare("INSERT INTO login_attempts (email, time) VALUES (?, ?)")) {
					$insert_stmt->bind_param('ss', $email, $now);
					$insert_stmt->execute();
					$insert_stmt->close();
				}	
				return false;
			}
		} else {
			// User does not exist
			return false;
        }
    }
}

function checkFailLog($email, $mysqli) {
    // Check failed attempts from past 15 minutes
    $now = time();
    $attempt_timeframe = $now - (60*15);
 
    if ($stmt = $mysqli->prepare("SELECT COUNT(*) FROM login_attempts WHERE email = ? AND time > ?")) {
        $stmt->bind_param('si', $email, $attempt_timeframe); 
        $stmt->execute();
        $stmt->bind_result($count);
		$stmt->fetch();
 
        // If there have been more than 5 failed logins 
        if ($count > 5) {
			$stmt->close();
        } else {
			$stmt->close();
        }
    }
	return $count;
}

function esc_url($url) {
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}

function checkEmail($mysqli, $email) {
	$query = "SELECT count(*) FROM user_account WHERE email = ?";

	$stmt=$mysqli->prepare($query);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->bind_result($count);
	
	if ($stmt->fetch()) {
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	$stmt->close();
}

/* returns the shortened url */
function shortenURL($url, $login='perfectpickem', $appkey='R_95e4921f3c9c4b889cfb59e3fa77709c', $format='txt') {
	$connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
	return curl_get_result($connectURL);
}

/* returns a result form url */
function curl_get_result($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
/******* Global Functions: End *******/

/******* Profile Page: Start *******/

function getUserInfo($connection, $user_id) {
    $query = "SELECT a.user_id, a.first_name, a.last_name, a.image, a.skill_level FROM user_profile a WHERE user_id = ?";

    $stmt = $connection->prepare($query);
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $stmt->bind_result($user_id, $first_name, $last_name, $image, $skill_level);

    $info = array();

    if($stmt->fetch()){
		$info["user_id"] = "$user_id";
        $info["first_name"] = "$first_name";
        $info["last_name"] = "$last_name";
        $info["image"] = "$image";
		$info["skill_level"] = "$skill_level";

		$stmt->close();
        return $info;
    }
}

function getAchievementCount($connection, $user_id) {
	// Get earned count
	$query = "SELECT COUNT(*) FROM user_achievements WHERE user_id = ?";
	
	$stmt = $connection->prepare($query);
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $stmt->bind_result($earned_count);
	$stmt->fetch();
	$stmt->close();
	
	$earned_count = $earned_count + 1; // Add Rookie badge
	
	// Get total count
	$query = "SELECT COUNT(*) FROM achievements";
	
	$stmt = $connection->prepare($query);
    $stmt->execute();
    $stmt->bind_result($total_count);
	$stmt->fetch();
	$stmt->close();
	
	$total_count = $total_count + 1;
	
	return $earned_count . " / " . $total_count;
}

class favTeams {
	var $sportId;
	var $sportName;
	var $teamId;
	var $teamName;
	var $teamLogo;
	var $teamUrl;
	
	function setSportId($newSportId) { 
		$this->sportId = $newSportId;  
	}
	
	function setSportName($newSportName) { 
		$this->sportName = $newSportName;  
	}
	
	function setTeamId($newTeamId) { 
		$this->teamId = $newTeamId;  
	}
	
	function setTeamName($newTeamName) { 
		$this->teamName = $newTeamName;  
	}
	
	function setTeamLogo($newTeamLogo) { 
		$this->teamLogo = $newTeamLogo;  
	}
	
	function setTeamUrl($newTeamUrl) { 
		$this->teamUrl = $newTeamUrl;  
	}

	function getSportId() {
		return $this->sportId;
	}
	
	function getSportName() {
		return $this->sportName;
	}
	
	function getTeamId() {
		return $this->teamId;
	}
	
	function getTeamName() {
		return $this->teamName;
	}
	
	function getTeamLogo() {
		return $this->teamLogo;
	}
	
	function getTeamUrl() {
		return $this->teamUrl;
	}
}

function getFavoriteTeams($connection, $user_id) {
	$query = "SELECT a.sport_id, b.sport_name, a.team_id, c.team_name, c.team_logo, c.team_url FROM user_favorites a, sports b, teams c ";
	$query .= "WHERE a.user_id = ? AND a.sport_id = b.sport_id AND a.team_id = c.team_id ORDER BY a.fav_id";

    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($sport_id, $sport_name, $team_id, $team_name, $team_logo, $team_url);

    while($stmt->fetch()) {
		$favs = new favTeams();
		$favs->setSportId($sport_id);
		$favs->setSportName($sport_name);
		$favs->setTeamId($team_id);
		$favs->setTeamName($team_name);
		$favs->setTeamLogo($team_logo);
		$favs->setTeamUrl($team_url);
		
		$teams[] = $favs;
    }
	
	$stmt->close();
    return $teams;
}

function getMatchStats($connection, $user_id) {
	$query = "SELECT COUNT(*), SUM(total_points), MAX(total_points), SUM(wins), SUM(top_three_finish), SUM(top_five_finish), SUM(top_ten_finish) FROM match_stats WHERE user_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($totalMatches, $totalPoints, $highScore, $wins, $topThree, $topFive, $topTen);
	
	$matchStats = array();
	while ($stmt->fetch()) {
		$matchStats['totalMatches'] = $totalMatches;
		$matchStats['totalPoints'] = $totalPoints;
		$matchStats['avgScore'] = $totalPoints / $totalMatches;
		$matchStats['highScore'] = $highScore;
		$matchStats['wins'] = $wins;
		$matchStats['topThree'] = $topThree;
		$matchStats['topFive'] = $topFive;
		$matchStats['topTen'] = $topTen;
	}
	
	$stmt->close();
	return $matchStats;
}

function getProfileCurrentMatches($connection, $user_id) {
	$query = "SELECT a.match_id, a.title, c.sport_name FROM matches a, joined_matches b, sports c WHERE b.user_id = ? AND a.match_id = b.match_id AND a.sport_id = c.sport_id AND a.status = 'open'";
	
	$stmt = $connection->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($match_id, $title, $sport_name);
	
	$currentIds = array();
	$currentTitles = array();
	$currentSports = array();
	$currentPlayers = array();
	$currentMaxPoints = array();
	
	while ($stmt->fetch()) {
		$currentIds[] = $match_id;
		$currentTitles[] = $title;
		$currentSports[] = $sport_name;
	}
	$stmt->close();
	
	for ($i = 0; $i < count($currentIds); $i++) {
		$currentPlayers[] = getCurrentPlayers($connection, $currentIds[$i]);
		$currentMaxPoints[] = getAvailablePoints($connection, $currentIds[$i]);
	}
		
	$currentMatches = array();
	$currentMatches['match_id'] = $currentIds;
	$currentMatches['title'] = $currentTitles;
	$currentMatches['sport'] = $currentSports;
	$currentMatches['players'] = $currentPlayers;
	$currentMatches['max_points'] = $currentMaxPoints;
	
	$stmt->close();
	return $currentMatches;
}

function getPreviousMatches($connection, $user_id) {
	$query = "SELECT a.match_id, b.title, c.sport_name FROM joined_matches a, matches b, sports c WHERE a.user_id = ? AND a.match_id = b.match_id AND b.sport_id = c.sport_id AND b.status = 'closed'";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($match_id, $title, $sport_name);
	
	$prevMatchIds = array();
	$prevTitles = array();
	$prevSports = array();
	
	while ($stmt->fetch()) {
		$prevMatchIds[] = $match_id;
		$prevTitles[] = $title;
		$prevSports[] = $sport_name;
	}
	$stmt->close();
	
	$prevMatches = array();
	$prevMatches['match_id'] = $prevMatchIds;
	$prevMatches['title'] = $prevTitles;
	$prevMatches['sport'] = $prevSports;
	
	$totalPlayers = array();
	$totalPoints = array();
	for ($i = 0; $i < count($prevMatchIds); $i++) {
		// Get total number of players from match
		$query = "SELECT COUNT(*) FROM match_stats WHERE match_id = ?";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $prevMatchIds[$i]);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		
		$totalPlayers[] = $count;
		$stmt->close();
		
		// Get player score from match
		$query = "SELECT total_points FROM match_stats WHERE user_id = ? AND match_id = ?";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('ii', $user_id, $prevMatchIds[$i]);
		$stmt->execute();
		$stmt->bind_result($points);
		$stmt->fetch();
		
		$totalPoints[] = $points;
		$stmt->close();
		
		// Get player rank from match
		$query = "SELECT ranking FROM match_stats WHERE user_id = ? AND match_id = ?";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('ii', $user_id, $prevMatchIds[$i]);
		$stmt->execute();
		$stmt->bind_result($ranking);
		$stmt->fetch();
		
		$totalRankings[] = '#' . $ranking;
		$stmt->close();	
	}
	
	$prevMatches['players'] = $totalPlayers;
	$prevMatches['points'] = $totalPoints;
	$prevMatches['rankings'] = $totalRankings;
	
	return $prevMatches;
}
/******* Profile Page: End *******/

/******* Edit Profile Page: Start *******/
function changeImage($connection, $image, $userId) {
	$query = "UPDATE user_profile SET image = ? WHERE user_id = ?";

	$update = $connection->prepare($query);
	$update->bind_param('si', $image, $userId);
	
	if($update->execute()) {
		
		$update->close();
		header("Location: ../edit-profile?ichange=2018215");
		
	} else {
		
		$update->close();
		header("Location: ../edit-profile?ichange=6112195");
	}
}

function changePassword($mysqli, $oldPassword, $newPassword) { 
	if ($stmt = $mysqli->prepare("SELECT password, salt FROM user_account WHERE user_id = ? LIMIT 1")) {
		$stmt->bind_param('s', $_COOKIE['user_id']);
		$stmt->execute();
		$stmt->store_result();

		$stmt->bind_result($db_password, $salt);
		$stmt->fetch();
		
		// Hash passwords with salt
		$oldPassword = hash('sha512', $oldPassword . $salt);
		$newPassword = hash('sha512', $newPassword . $salt);
		
		$stmt->close();
			
		if ($db_password == $oldPassword) {
			$query = "UPDATE user_account SET password = ? WHERE user_id = ?";
			
			$update = $mysqli->prepare($query);
			$update->bind_param('ss', $newPassword, $_COOKIE['user_id']);
			$update->execute();
			$update->close();
			
			header("Location: ../edit-profile?pchange=2018215");
			
		} else {
			header("Location: ../edit-profile?pchange=6112195");
		}
	
	} else {
		header("Location: ../edit-profile?pchange=518181518");
	}
}

function getSports($connection) {
	$query = "SELECT sport_id, sport_name FROM sports";
	
	$stmt = $connection->prepare($query);
    $stmt->execute();
    $stmt->bind_result($sport_id, $sport_name);
	
	while($stmt->fetch()){
		echo "<option value='";
		echo $sport_id;
		echo "'>";
		echo $sport_name;
		echo "</option>";
	}
}
/******* Edit Profile Page: End *******/

/******* Matches Page: Start *******/
function getMatches($connection, $user_id) {
	$query = "SELECT a.match_id, a.title, b.sport_name, a.category, a.start_date, a.start_time, (SELECT COUNT(*) FROM joined_matches WHERE match_id = a.match_id AND user_id = ?) FROM matches a, sports b WHERE a.sport_id = b.sport_id AND a.deadline > CURRENT_TIMESTAMP ORDER BY a.deadline";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($match_id, $title, $sport, $category, $date, $time, $joined);
		
	while($stmt->fetch()) {
		$match['match_id'] = "$match_id";
		$match['title'] = "$title";
		$match['sport'] = "$sport";
		$match['category'] = "$category";
		$match['date'] = "$date";
		$match['time'] = "$time";
		$match['joined'] = "$joined";
	
		$matches[] = $match;
	}
	$stmt->close();
	
	return $matches;
}
/******* Matches Page: End *******/

function getMatchTitles($mysqli) {
	$query = "SELECT team_name FROM teams";
	
	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$stmt->bind_result($title);
	
	$titles = array();
	
	while($stmt->fetch()) {
		$titles[] = $title;	
	}
	
	$stmt->close();
	
	for($i = 0; $i < count($titles); $i++) {
		echo "<div><label class='upcomingContent'>Upcoming Match: ";
		echo $titles[$i];
		echo "</label></div>";
	}
}

function getMatchInfo($connection, $match_id) {
	$query = "SELECT a.match_id, a.title, a.start_date, a.start_time, a.deadline_text, COUNT(*) FROM matches a, joined_matches b WHERE a.match_id = ? AND a.match_id = b.match_id";
	
	$stmt = $connection->prepare($query);
    $stmt->bind_param('i', $match_id);
    $stmt->execute();
    $stmt->bind_result($match_id, $title, $date, $time, $deadline, $count);
	$stmt->fetch();
	$stmt->close();
	
	$match = array();
	
	$match['match_id'] = $match_id;
	$match['title'] = $title;
	$match['date'] = $date;
	$match['time'] = $time;
	$match['deadline'] = $deadline;
	$match['players'] = $count;
	
	return $match;
}

function getCurrentPlayers($connection, $match_id) {
	$query = "SELECT COUNT(*) FROM joined_matches WHERE match_id = ?";	
	
	$stmt = $connection->prepare($query);
    $stmt->bind_param('i', $match_id);
    $stmt->execute();
    $stmt->bind_result($players);
	$stmt->fetch();
	$stmt->close();
	
	return $players;
}

function getQuestionCount($connection, $match_id) {
	$query = "SELECT COUNT(*) FROM match_questions a WHERE a.match_id = ? AND a.question_id != 0 AND a.multiple_correct = 'No'";	
	
	$stmt = $connection->prepare($query);
    $stmt->bind_param('i', $match_id);
    $stmt->execute();
    $stmt->bind_result($questions);
	$stmt->fetch();
	$stmt->close();
	
	return $questions;
}

function getAvailablePoints($connection, $match_id) {
	$query = "SELECT SUM(a.skill_points) FROM match_questions a WHERE a.match_id = ? AND a.multiple_correct = 'No'";
	
	$stmt = $connection->prepare($query);
    $stmt->bind_param('i', $match_id);
    $stmt->execute();
    $stmt->bind_result($points);
	$stmt->fetch();
	$stmt->close();
	
	return $points;
}

function getPickAccuracy($connection, $user_id) {
	// Get total questions answered
	$query = "SELECT COUNT(*) FROM match_answers a, matches b WHERE a.question_id != 0 AND a.user_id = ? AND a.match_id = b.match_id AND b.status = 'closed'";
	
	$stmt = $connection->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($totalCount);
	$stmt->fetch();
	$stmt->close();
	
	// Get total correct answers
	$query = "SELECT SUM(a.number_correct) FROM match_stats a WHERE a.user_id = ?";
	
	$stmt = $connection->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($correctAnswers);
	$stmt->fetch();
	$stmt->close();
	
	$accuracy = $correctAnswers / $totalCount;
	$accuracy = round((float)$accuracy * 100 ) . '%';
	echo $accuracy;
}

function checkMatchClosed($connection, $match_id) {
	$query = "SELECT status FROM matches WHERE match_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->store_result();
    $stmt->bind_result($status);
	$stmt->fetch();
	$stmt->close();
	
	if ($status == 'closed') {
		return true;
	} else {
		return false;
	}
}

function getSeconds($mysqli) {
	$whereClause = "";
	$query = "SELECT deadline FROM matches WHERE status = 'open'";
	
	if (isset($_GET['title']) && $_GET['title'] != "") {
		$title = $_GET['title'];
		$whereClause .= " AND title LIKE '%" . $title . "%'";
	}
	
	if (isset($_GET['sport']) && $_GET['sport'] != "") {
		$sport = $_GET['sport'];
		$whereClause .= " AND sport_id = " . $sport;
	}
	
	if (isset($_GET['category']) && $_GET['category'] != "") {
		$category = $_GET['category'];
		$whereClause .= " AND category = '" . $category . "'";
	}
	
	$query .= $whereClause;
	
	$stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($deadline);
	
	echo "var seconds = [];";
	
	while($stmt->fetch()) {
	
		$deadline = strtotime($deadline);
		$remaining = $deadline - time();
		
		echo "seconds.push('";
		echo $remaining;
		echo "');";
	}
	$stmt->close();
}

function getMatchList($mysqli) {
	$user_id = $_COOKIE['user_id'];
	$whereClause = "";

	$query = "SELECT (SELECT COUNT(*) FROM joined_matches WHERE match_id = a.match_id AND user_id = $user_id) as match_count, a.match_id, a.title, 
	b.sport_name, a.category, a.start_date, a.deadline FROM matches a, sports b WHERE a.status = 'open' AND a.sport_id = b.sport_id AND UTC_TIMESTAMP() < a.deadline";
	
	if (isset($_GET['title']) && $_GET['title'] != "") {
		$title = $_GET['title'];
		$whereClause .= " AND a.title LIKE '%" . $title . "%'";
	}
	
	if (isset($_GET['sport']) && $_GET['sport'] != "") {
		$sport = $_GET['sport'];
		$whereClause .= " AND a.sport_id = " . $sport;
	}
	
	if (isset($_GET['category']) && $_GET['category'] != "") {
		$category = $_GET['category'];
		$whereClause .= " AND a.category = '" . $category . "'";
	}
	
	$query .= $whereClause;
	
	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$stmt->bind_result($match_count, $match_id, $title, $sport_name, $category, $date, $deadline);
	
	$match = array();
	$allmatches = array();
	
	while($stmt->fetch()) {
		$match['match_count'] = "$match_count";
		$match['match_id'] = "$match_id";
		$match['title'] = "$title";
		$match['sport_name'] = "$sport_name";
		$match['category'] = "$category";
		$match['date'] = "$date";
		$match['deadline'] = "$deadline";
		
		$allmatches[] = $match;
	}
	
	$stmt->close();
	
	for($i = 0; $i < count($allmatches); $i++) {
		echo "<tr><td class='title'>";
		
		$deadline = strtotime($allmatches[$i]['deadline']);
		$remaining = $deadline - time();
		
		if($remaining <= 0) {
			echo "<img src='images/closed.png' title='Match Closed' />";
		} else if($allmatches[$i]['match_count'] == 1) {
			echo "<img src='images/remove.png' class='remove' title='Leave Match' ";
			echo "onClick='quitMatch(";
			echo $allmatches[$i]['match_id'];
			echo ")'/>";
		} else {
			echo "<input type='checkbox' id='check$i' value='";
			echo $allmatches[$i]['match_id'];
			echo "' onClick='joinMatch(";
			echo $allmatches[$i]['match_id'];
			echo ")'/>";
		}
		echo "<a href='match?matchId=";
		echo $allmatches[$i]['match_id'];
		echo "'>";
		echo $allmatches[$i]['title'];
		echo "</a></td><td>";
		echo $allmatches[$i]['sport_name'];
		echo "</td><td>";
		echo $allmatches[$i]['category'];
		echo "</td><td>";
		echo $allmatches[$i]['date'];
		echo "</td><td>";
		echo "<span id='countdown$i'></span>";	
		echo "</td></tr>";
	}
}

function getStandings($mysqli, $match_id) {
	$remaining = getMatchDeadline($mysqli, $match_id);
	
	$query = "SELECT a.user_id, a.first_name, a.last_name, a.skill_level, (SELECT correct_answer FROM match_tiebreakers WHERE match_id = ?) as tiebreaker_answer, 
	(SELECT d.user_answer FROM match_tiebreakers c JOIN match_tiebreaker_answers d ON c.tiebreaker_id = d.tiebreaker_id WHERE d.user_id = a.user_id AND c.match_id = ?) 
	AS tiebreaker_guess FROM user_profile a, match_answers b, match_tiebreakers c, match_tiebreaker_answers d 
	WHERE c.match_id = ? AND b.match_id = c.match_id AND a.user_id = b.user_id AND c.tiebreaker_id = d.tiebreaker_id GROUP BY a.user_id ORDER BY a.user_id";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('iii', $match_id, $match_id, $match_id);
	$stmt->execute();
	$stmt->bind_result($user_id, $first_name, $last_name, $skill_level, $tiebreaker_answer, $tiebreaker_guess);

	$allRankings = array();
	$allIds = array();
	$allFirstNames = array();
	$allLastNames = array();
	$allSkillLevels = array();
	$allSkillPoints = array();
	$allTotalPoints = array();
	
	while($stmt->fetch()) {
		$allIds[] = $user_id;
		$allFirstNames[] = $first_name;
		$allLastNames[] = $last_name;
		$allSkillLevels[] = $skill_level;

		if($tiebreaker_answer > $tiebreaker_guess) {
			$tiebreaker_points = $tiebreaker_guess / $tiebreaker_answer;
		} else {
			$tiebreaker_points = $tiebreaker_answer / $tiebreaker_guess;
		}
		
		$allTotalPoints[] = $tiebreaker_points;
	}
	$stmt->close();
	
	$query = "SELECT DISTINCT b.user_id, b.question_id, SUM(a.skill_points) FROM match_questions a, match_answers b WHERE a.match_id = ? 
	AND a.match_id = b.match_id AND a.question_id = b.question_id AND a.correct_answer = b.user_answer GROUP BY b.user_id";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($user_id, $question_id, $skill_points);
	
	while($stmt->fetch()) {
		$allSkillPoints[] = $skill_points;
	}
	
	for($i = 0; $i < count($allTotalPoints); $i++) {
		$allTotalPoints[$i] += $allSkillPoints[$i];
	}
	
	array_multisort($allTotalPoints, SORT_DESC, $allIds, $allFirstNames, $allLastNames, $allSkillLevels, $allSkillPoints);
	
	$allRankings['id'] = $allIds;
	$allRankings['first_name'] = $allFirstNames;
	$allRankings['last_name'] = $allLastNames;
	$allRankings['skill_level'] = $allSkillLevels;
	$allRankings['skill_points'] = $allSkillPoints;
	$allRankings['total_points'] = $allTotalPoints;
	
	for($i = 0; $i < count($allIds); $i++) {
		// Highlight current user
		if($allRankings['id'][$i] == $_COOKIE['user_id']) {
			echo "<tr><td class='highlight-user'>";
			echo $i + 1;
			echo "</td><td class='highlight-user' style='text-align:left'><a href='profile?id=";
			echo $allRankings['id'][$i];
			echo "'>";
			echo $allRankings['first_name'][$i] . " " . $allRankings['last_name'][$i];
			echo "</a></td><td class='highlight-user'>";
			
			if($allRankings['skill_points'][$i] != null && $allRankings['skill_points'][$i] != "") {
				echo $allRankings['skill_points'][$i];
			} else {
				echo "0";
			}
			echo "</td><td class='highlight-user'>";
			
			if($remaining > 0) { // Before Match Deadline
				echo "<a href='match-picks?matchId=" . $match_id . "'>";
				echo "Edit";
				echo "</a>";
				echo "</td></tr>";
			} else { // Match Deadline Passed
				echo "<a href='view-picks?matchId=" . $match_id . "&userId=" . $allRankings['id'][$i] . "'>";
				echo "View";
				echo "</a>";
				echo "</td></tr>";
			}
		// Display other users
		} else {
			echo "<tr><td>";
			echo $i + 1;
			echo "</td><td style='text-align:left'><a href='profile?id=";
			echo $allRankings['id'][$i];
			echo "'>";
			echo $allRankings['first_name'][$i] . " " . $allRankings['last_name'][$i];
			echo "</a></td><td>";
			
			if($allRankings['skill_points'][$i] != null && $allRankings['skill_points'][$i] != "") {
				echo $allRankings['skill_points'][$i];
			} else {
				echo "0";
			}
			echo "</td><td>";
			
			if($remaining > 0) { // Before Match Deadline
				echo "<a><label onClick='viewAlert()'>View</label></a>";
			} else { // Match Deadline Passed
				echo "<a href='view-picks?matchId=" . $match_id . "&userId=" . $allRankings['id'][$i] . "'>";
				echo "View";
				echo "</a>";
				echo "</td></tr>";
			}
		}
	}
	
	return $allRankings['id'];
}

function getMatchTitle($mysqli, $match_id) {
	$query = "SELECT title FROM matches WHERE match_id = ?";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($title);
	$stmt->fetch();
	$stmt->close();
	
	return $title;
}

function getMatchDeadline($mysqli, $match_id) {
	date_default_timezone_set('America/Los_Angeles');
	$query = "SELECT deadline FROM matches WHERE match_id = ?";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($deadline);
	$stmt->fetch();
	
	$deadline = strtotime($deadline);
	$remaining = $deadline - time();
	
	$stmt->close();
	return $remaining;
}

function checkMatchJoin($connection, $match_id, $user_id) {
	$query = "SELECT COUNT(*) FROM joined_matches WHERE match_id = ? AND user_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('ii', $match_id, $user_id);
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	
	if($count > 0) {
		return true;
	} else {
		return false;
	}
}

function getQuestions($connection, $match_id) {
	// Get Questions
	$query = "SELECT a.question_id, a.question, a.skill_points FROM match_questions a WHERE a.match_id = ? AND a.question_id != 0 AND a.multiple_correct = 'No'";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($question_id, $question, $skill_points);
	
	$questions = array();
	$allQuestions = array();
	
	while($stmt->fetch()) {
		$questions['id'] = $question_id;
		$questions['text'] = $question;
		$questions['skill_points'] = $skill_points;
		
		$allQuestions[] = $questions;
	}
	$stmt->close();
	
	// Get Tiebreaker
	$query = "SELECT a.question FROM match_tiebreakers a WHERE a.match_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($tiebreaker);
	$stmt->fetch();
	$stmt->close();
	
	// Display Q&A
	$tiebreakerCount = 1;
	$savedPicks = getSavedPicks($connection, $match_id, $_COOKIE['user_id']);
	$savedTiebreaker = getSavedTiebreaker($connection, $match_id, $_COOKIE['user_id']);
	
	for ($i = 0; $i < count($allQuestions); $i++) {
		
		$j = $i + 1; 
		$tiebreakerCount++;
		$selectedAnswer = $savedPicks[$i]['answer'];
		$allOptions = getOptions($connection, $match_id, $allQuestions[$i]['id']);
		
		// Display Questions
		echo "<div id='q$j' class='QuestionContent'>";
		echo "<p class='question'><strong>Question $j: </strong>";
		echo $allQuestions[$i]['text'];
		echo "<strong> (" . $allQuestions[$i]['skill_points'] . " Points)</strong></p>";
		
		for ($k = 0; $k < count($allOptions); $k++) {
			if ($allOptions[$k]['question_option'] == $selectedAnswer) {
				echo "<div id='answer$j' class='answer-choice' style='background-color:#00a550;'>";
			} else {
				echo "<div class='answer-choice'>";
			}
			
			echo "<a class='answer' data-category='pp-match-picks' data-action='match-question' data-label='answer-choice'>";
			echo "<p>";
			echo $allOptions[$k]['question_option'];
			echo "</p></a></div>";
		}
		
		echo "<div class='nav-buttons'><a data-category='pp-match-picks' data-action='match-questions' data-label='back'><div class='back-button left'><p>&#60;&#60; Back</p></div></a>";
		echo "<a data-category='pp-match-picks' data-action='match-questions' data-label='next'><div class='next-button right'><p>Next &#62;&#62;</p></div></a></div></div>";
	}
	
	// Display Tiebreaker
	echo "<div id='q$tiebreakerCount' class='QuestionContent'>";
	echo "<p class='question'><strong>Tiebreaker: </strong>";
	echo $tiebreaker;
	echo "</p><input type='text' id='q$tiebreakerCount' class='tiebreaker-answer' value='$savedTiebreaker' onchange='submitTiebreaker();' />";
	echo "<div class='nav-buttons'><div class='back-button left'><p>&#60;&#60; Back</p></div>";
	echo "<div class='next-button right'><p>Next &#62;&#62;</p></div></div></div>";
	
	return count($allQuestions);
}

function getQuestionsOnly($connection, $match_id) {
	// Get Questions
	$query = "SELECT a.question_id, a.question, a.skill_points FROM match_questions a WHERE a.match_id = ? AND a.question_id != 0 AND a.multiple_correct = 'No'";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($question_id, $question, $skill_points);
	
	$questions = array();
	$allQuestions = array();
	
	while($stmt->fetch()) {
		$questions['id'] = $question_id;
		$questions['text'] = $question;
		$questions['skill_points'] = $skill_points;
		
		$allQuestions[] = $questions;
	}
	$stmt->close();
	return $allQuestions;
}

function getOptions($connection, $match_id, $question_id) {
	$query = "SELECT question_id, options FROM match_options WHERE match_id = ? AND question_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('ii', $match_id, $question_id);
	$stmt->execute();
	$stmt->bind_result($question_id, $question_option);
	
	$option = array();
	$allOptions = array();
	
	while($stmt->fetch()) {
		$option['question_id'] = $question_id;
		$option['question_option'] = $question_option;
		
		$allOptions[] = $option;
	}
	$stmt->close();
	return $allOptions;
}

function getAnswers($connection, $match_id, $question_id) {
	// Get correct answer
	$query = "SELECT a.correct_answer FROM match_questions a WHERE a.match_id = ? AND a.question_id = ? AND a.multiple_correct = 'No'";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('ii', $match_id, $question_id);
	$stmt->execute();
	$stmt->bind_result($correct_answer);
	$stmt->fetch();
	$stmt->close();
	
	// Get user answers
	$query = "SELECT a.user_id, b.first_name, b.last_name, a.user_answer FROM match_answers a, user_profile b WHERE a.match_id = ? AND a.question_id = ? AND a.user_id = b.user_id";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('ii', $match_id, $question_id);
	$stmt->execute();
	$stmt->bind_result($user_id, $first_name, $last_name, $answer);
	
	while($stmt->fetch()) {
		$answerInfo['user_id'] = $user_id;
		$answerInfo['first_name'] = $first_name;
		$answerInfo['last_name'] = $last_name;
		$answerInfo['answer'] = $answer;
		$allAnswers[] = $answerInfo;
	}
	$stmt->close();
	
	// Check for multiple correct answers
	$query = "SELECT a.question_id, a.correct_answer FROM match_questions a WHERE a.multiple_correct = 'Yes' AND a.match_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($question_id, $multiple_answer);
	$stmt->fetch();
	$stmt->close();
	
	for ($i = 0; $i < count($allAnswers); $i++) {
		$j = $i + 1;
		echo '<a href="/profile?id=' . $allAnswers[$i]['user_id'] . '">' . $allAnswers[$i]['first_name'] . ' ' . $allAnswers[$i]['last_name'] . '</a> - ';
		if ($allAnswers[$i]['answer'] == $correct_answer || $allAnswers[$i]['answer'] == $multiple_answer) {
			echo "<span id='" . $allAnswers[$i]['user_id'] . "' style='color:#00a550'>" . $allAnswers[$i]["answer"] . "</span><br>";
		} else if ($correct_answer != 'TBA') {
			echo "<span id='" . $allAnswers[$i]['user_id'] . "' style='color:#fc4349'>" . $allAnswers[$i]["answer"] . "</span><br>";
		} else {
			echo "<span id='" . $allAnswers[$i]['user_id'] . "' style='color:#000000'>" . $allAnswers[$i]["answer"] . "</span><br>";
		}
	}
	
	/*echo "<script>$('#qc$question_id').css('background-color','black');</script>";*/
	
}

function getTiebreakerInfo($connection, $match_id) {
	// Get correct tiebreaker
	$query = "SELECT question, correct_answer FROM match_tiebreakers WHERE match_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($question, $correct_answer);
	$stmt->fetch();
	
	$tiebreakerInfo['question'] = $question;
	$tiebreakerInfo['answer'] = $correct_answer;
	
	$stmt->close();
	
	return $tiebreakerInfo;
}

function getTiebreakers($connection, $match_id) {
	// Get user answers
	$query = "SELECT a.user_id, b.first_name, b.last_name, a.user_answer FROM match_tiebreaker_answers a, user_profile b WHERE a.tiebreaker_id = ? AND a.user_id = b.user_id";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($user_id, $first_name, $last_name, $tb_answer);
	
	while($stmt->fetch()) {
		echo '<a data-category="pp-view-questions" data-action="answers" data-label="user-profile" href="/profile?id=' . $user_id . '">' . $first_name . ' ' . $last_name . '</a> - ';
		echo '<span style="color:#000">' . $tb_answer . '</span><br>';
	}
	
	$stmt->close();
}

function savePicks($connection, $user_id, $match_id, $question_id, $answer) {
	$query = "SELECT result_id FROM match_answers WHERE user_id = ? AND match_id = ? AND question_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('iii', $user_id, $match_id, $question_id);
	$stmt->execute();
	$stmt->store_result();
    $stmt->bind_result($result_id);
	$stmt->fetch();
	
	// Check for apostrophe in names
	$answer = str_replace("&#39;", "'", $answer);
	
	if ($stmt->num_rows == 0) {
		$stmt->close();
		$query = "INSERT INTO match_answers (user_id, match_id, question_id, user_answer) VALUES (?, ?, ?, ?)";
		
		$insert_stmt = $connection->prepare($query);
		$insert_stmt->bind_param('iiis', $user_id, $match_id, $question_id, $answer);
		$insert_stmt->execute();
		$insert_stmt->close();
	} else {
		$stmt->close();
		$query = "UPDATE match_answers SET user_answer = ? WHERE user_id = ? AND match_id = ? AND question_id = ?";
	
		if (isset($answer) && $answer != '' && $answer != NULL) {
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('siii', $answer, $user_id, $match_id, $question_id);
			$update_stmt->execute();
			$update_stmt->close();
		}
		
	}
}

function saveTiebreaker($connection, $user_id, $tiebreaker_id, $answer) {
	$query = "SELECT result_id FROM match_tiebreaker_answers WHERE user_id = ? AND tiebreaker_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('ii', $user_id, $tiebreaker_id);
	$stmt->execute();
	$stmt->store_result();
    $stmt->bind_result($result_id);
	$stmt->fetch();
	
	if ($stmt->num_rows == 0) {
		$stmt->close();
		$query = "INSERT INTO match_tiebreaker_answers (user_id, tiebreaker_id, user_answer) VALUES (?, ?, ?)";
		
		$insert_stmt = $connection->prepare($query);
		$insert_stmt->bind_param('iis', $user_id, $tiebreaker_id, $answer);
		$insert_stmt->execute();
		$insert_stmt->close();
	} else {
		$stmt->close();
		$query = "UPDATE match_tiebreaker_answers SET user_answer = ? WHERE user_id = ? AND tiebreaker_id = ?";
		
		if (isset($answer) && $answer != '' && $answer != NULL) {
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('sii', $answer, $user_id, $tiebreaker_id);
			$update_stmt->execute();
			$update_stmt->close();
		}
	}
}

function getSavedPicks($connection, $match_id, $user_id) {
	$query = "SELECT question_id, user_answer FROM match_answers WHERE match_id = ? AND question_id != 0 AND user_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('ii', $match_id, $user_id);
	$stmt->execute();
	$stmt->bind_result($question_id, $user_answer);
	
	$picks = array();
	$allPicks = array();
	
	while($stmt->fetch()) {
		$picks['question_id'] = $question_id;
		$picks['answer'] = $user_answer;
		
		$allPicks[] = $picks;
	}
	$stmt->close();
	return $allPicks;
}

function getSavedTiebreaker($connection, $tiebreaker_id, $user_id) {
	$query = "SELECT user_answer FROM match_tiebreaker_answers WHERE tiebreaker_id = ? AND user_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('ii', $tiebreaker_id, $user_id);
	$stmt->execute();
	$stmt->bind_result($user_answer);
	$stmt->fetch();
	$stmt->close();
	
	return $user_answer;
}

function viewPicks($connection, $match_id, $user_id) {
	// Get Questions
	$query = "SELECT a.question_id, a.question, a.correct_answer, a.skill_points FROM match_questions a WHERE a.match_id = ? AND a.question_id != 0 AND a.multiple_correct = 'No'";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($question_id, $question, $correct_answer, $skill_points);
	
	$questions = array();
	$allQuestions = array();
	
	while($stmt->fetch()) {
		$questions['id'] = $question_id;
		$questions['text'] = $question;
		$questions['correct_answer'] = $correct_answer;
		$questions['skill_points'] = $skill_points;
		
		$allQuestions[] = $questions;
	}
	$stmt->close();
	
	// Get Tiebreaker
	$query = "SELECT a.question, a.correct_answer FROM match_tiebreakers a WHERE a.match_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($tb_question, $tb_answer);
	$stmt->fetch();
	$stmt->close();
	
	// Display Q&A
	$tiebreakerCount = 1;
	$savedPicks = getSavedPicks($connection, $match_id, $user_id);
	$savedTiebreaker = getSavedTiebreaker($connection, $match_id, $user_id);
	
	for ($i = 0; $i < count($allQuestions); $i++) {
		
		$j = $i + 1; 
		$tiebreakerCount++;
		$selectedAnswer = $savedPicks[$i]['answer'];
		$allOptions = getOptions($connection, $match_id, $allQuestions[$i]['id']);
		
		// Display Questions
		echo "<div id='q$j' class='QuestionContent'>";
		echo "<p class='question'><strong>Question $j: </strong>";
		echo $allQuestions[$i]['text'];
		echo "<span class='result-icon'><strong> (" . $allQuestions[$i]['skill_points'] . " Points)</strong>";
		echo "<img class='correct-icon' src='images/correct.png'/><img class='incorrect-icon' src='images/incorrect.png'/></span></p>";
		
		// Display All Options
		for ($k = 0; $k < count($allOptions); $k++) {
			if ($allOptions[$k]['question_option'] == $selectedAnswer) { // If answer is selected
				if (($selectedAnswer != $allQuestions[$i]['correct_answer']) && ($allQuestions[$i]['correct_answer'] != 'TBA')) { // If answer is incorrect
					echo "<div id='answer$j' class='answer-choice' style='background-color:#fc4349;'>";
					echo "<script>$('#q$j .incorrect-icon').show();</script>";
				} else { // If answer is correct
					echo "<div id='answer$j' class='answer-choice' style='background-color:#00a550;'>";
					if ($selectedAnswer == $allQuestions[$i]['correct_answer']) {
						echo "<script>$('#q$j .correct-icon').show();</script>";
					}
				}
			} else {
				if ($allOptions[$k]['question_option'] == $allQuestions[$i]['correct_answer']) {
					echo "<div class='answer-choice' style='background-color:#00a550;'>";
				} else {
					echo "<div class='answer-choice'>";
				}
			}
			
			echo "<a class='answer'>";
			echo "<p>";
			echo $allOptions[$k]['question_option'];
			echo "</p></a></div>";
		}
		
		echo "</div>";
	}
	
	// Check for multiple correct answers
	$query = "SELECT a.question_id, a.correct_answer FROM match_questions a WHERE a.multiple_correct = 'Yes' AND a.match_id = ?";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($question_id, $multiple_answer);
	$stmt->fetch();
	$stmt->close();
	
	// Change to correct icon if user answer correct
	$query = "SELECT a.question_id, a.user_answer FROM match_answers a WHERE a.match_id = ? AND a.question_id = ? AND a.user_id = ?";

	$stmt = $connection->prepare($query);
	$stmt->bind_param('iii', $match_id, $question_id, $user_id);
	$stmt->execute();
	$stmt->bind_result($question_id, $user_answer);
	$stmt->fetch();
	$stmt->close();
	
	if ($multiple_answer == $user_answer) {
		echo "<script>$('#answer$question_id').css('background-color','#00a550');</script>";
		echo "<script>$('#q$question_id .correct-icon').show();</script>";
		echo "<script>$('#q$question_id .incorrect-icon').hide();</script>";
	}
	
	// Display Tiebreaker
	echo "<div id='q$tiebreakerCount' class='QuestionContent'>";
	echo "<p class='question'><strong>Tiebreaker: </strong>";
	echo $tb_question;
	echo "</p>";
	if ($tb_answer != 0) {
		echo "<p style='font-weight:700; color:#00a550'>Correct answer : " . $tb_answer . "</p>";	
	}
	echo "<input type='text' id='q$tiebreakerCount' class='tiebreaker-answer' value='$savedTiebreaker' onchange='submitTiebreaker();' />";
	echo "</div>";
}

function getTiebreakerScore($connection, $user_id) {
	// Get user tiebreakers
	$query = "SELECT a.tiebreaker_id, a.user_answer FROM match_tiebreaker_answers a, matches b WHERE a.user_id = ? AND a.tiebreaker_id = b.match_id AND b.status = 'closed'";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $user_id);
	$stmt->execute();
	$stmt->bind_result($match_id, $tiebreaker_answer);
	
	while($stmt->fetch()) {
		$user_matchIds[] = $match_id;
		$user_answers[] = $tiebreaker_answer;
	}
	$user_tiebreakers['match_id'] = $user_matchIds;
	$user_tiebreakers['answer'] = $user_answers;
	$stmt->close();
	
	// Get correct tiebreaker for each user match
	for ($i = 0; $i < count($user_tiebreakers['match_id']); $i++) {
		$query = "SELECT a.correct_answer FROM match_tiebreakers a WHERE a.match_id = ?";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $user_tiebreakers['match_id'][$i]);
		$stmt->execute();
		$stmt->bind_result($correct_tiebreaker);
		
		while($stmt->fetch()) {
			// Get user's total tb points
			$user_tiebreaker = $user_tiebreakers['answer'][$i];
			
			if ($user_tiebreaker > $correct_tiebreaker) {
				$tb_points = $correct_tiebreaker / $user_tiebreaker; 
			} else {
				$tb_points = $user_tiebreaker / $correct_tiebreaker;
			}
			
			$total_tb_points[] = $tb_points;
		}
		$stmt->close();
	}
	
	$tb_score = array_sum($total_tb_points) / count($total_tb_points);
	
	return $tb_score;
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
	
	// Add tiebreaker points to score
	for($i = 0; $i < count($allMatchPoints['id']); $i++) {
		$tb_score = getTiebreakerScore($connection, $allMatchPoints['id'][$i]);
		$allMatchPoints['points'][$i] += $tb_score;
	}
	
	array_multisort($allMatchPoints['points'], SORT_DESC, $allMatchPoints['id'], $allMatchPoints['first_name'], $allMatchPoints['last_name']);
	
	return $allMatchPoints;
}

function getEarnedAchievements($connection, $userId) {
	$query = "SELECT a.achievement_id, a.title, a.caption, a.image FROM achievements a, user_achievements b WHERE b.user_id = ? AND a.achievement_id = b.achievement_id ORDER BY a.achievement_id";
	
	$stmt = $connection->prepare($query);
	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->bind_result($id, $title, $caption, $image);
	
	while($stmt->fetch()) {
		$allIds[] = $id;
		$allTitles[] = $title;
		$allCaptions[] = $caption;
		$allImages[] = $image;
	}
	
	$earnedAchievements['id'] = $allIds;
	$earnedAchievements['title'] = $allTitles;
	$earnedAchievements['caption'] = $allCaptions;
	$earnedAchievements['image'] = $allImages;
	$stmt->close();
	
	return $earnedAchievements;
}

function getUnearnedAchievements($connection, $userId) {
	$earnedAchievements = getEarnedAchievements($connection, $userId);
	
	$excludeList = "";
	$idCount = count($earnedAchievements['id']);
	
	for($i = 0; $i < $idCount; $i++) {
		$excludeList .= $earnedAchievements['id'][$i]; // add id to list
		if ($i != $idCount - 1) {
			$excludeList .= ","; // add comma if not last element
		}
	}
	
	$query = "SELECT a.achievement_id, a.title, a.caption, a.image FROM achievements a WHERE a.achievement_id";
	
	if($earnedAchievements['id'] != NULL) {
		$query .= " NOT IN($excludeList)";
	}
	
	$stmt = $connection->prepare($query);
	$stmt->execute();
	$stmt->bind_result($id, $title, $caption, $image);
	
	while($stmt->fetch()) {
		$allIds[] = $id;
		$allTitles[] = $title;
		$allCaptions[] = $caption;
		$allImages[] = $image;
	}
	
	$unearnedAchievements['id'] = $allIds;
	$unearnedAchievements['title'] = $allTitles;
	$unearnedAchievements['caption'] = $allCaptions;
	$unearnedAchievements['image'] = $allImages;
	$stmt->close();
	
	return $unearnedAchievements;
}
?>
