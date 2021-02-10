<?php
ob_start();

include_once 'db_config.php';

// Create PHP class to set and retrieve favorite teams
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
 
function sec_session_start() {
	
	// Set session name and settings
    $session_name = 'sec_session_id';
    $secure = SECURE;
    $httponly = true;
	
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../index.php");
        exit();
    }
	
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

function getUserInfo($mysqli, $user_id) {
    $query = "SELECT a.user_id, a.first_name, a.last_name, a.image, a.mailing_list FROM user_profile a WHERE user_id = ?";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $stmt->bind_result($user_id, $first_name, $last_name, $image, $mailing_list);

    $info = array();

    if($stmt->fetch()){
		$info["user_id"] = "$user_id";
        $info["first_name"] = "$first_name";
        $info["last_name"] = "$last_name";
        $info["image"] = "$image";
		$info["mailing_list"] = "$mailing_list";

		$stmt->close();
        return $info;
    }
}

function getSports($mysqli) {
	$query = "SELECT sport_id, sport_name FROM sports";
	
	$stmt = $mysqli->prepare($query);
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

function getAllLogos($mysqli) {
	$query = "SELECT team_name, team_logo FROM teams";
	
	$stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($team_name, $team_logo);
	
	while($stmt->fetch()){
		echo $team_name;
		echo "<br/>";
		echo "<img src='";
		echo $team_logo;
		echo "'/><br/>";
	}
}

function getFavoriteTeams($mysqli, $user_id) {
	$query = "SELECT a.sport_id, b.sport_name, a.team_id, c.team_name, c.team_logo, c.team_url FROM user_favorites a, sports b, teams c ";
	$query .= "WHERE a.user_id = ? AND a.sport_id = b.sport_id AND a.team_id = c.team_id ORDER BY a.fav_id";

    $stmt = $mysqli->prepare($query);
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

function getSkillLevel($mysqli, $user_id) {
	$query = "SELECT a.skill_points FROM match_questions a, match_answers b WHERE user_id = ? ";
	$query .= "AND a.question_id = b.question_id AND a.correct_answer = b.user_answer";
	
	$stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($skill_points);
	
	$skill = array();
	$skill['points'] = 0;
	
	while($stmt->fetch()) {
		$skill['points'] += $skill_points;
	}
	
	if($skill['points'] < 1000) {
		$skill['level'] = 'Rookie';
	} else if($skill['points'] < 3000) {
		$skill['level'] = 'Starter';
	} else if($skill['points'] < 6000) {
		$skill['level'] = 'All-Star';
	} else if($skill['points'] < 10000) {
		$skill['level'] = 'MVP';
	} else if($skill['points'] < 15000) {
		$skill['level'] = 'Champion';
	} else if($skill['points'] < 30000) {
		$skill['level'] = 'Hall of Famer';
	} else {
		$skill['level'] = 'Legend';
	}
	
	$stmt->close();
    return $skill;
}

function getCurrentMatches($mysqli, $user_id) {
	$query = "SELECT a.match_id, a.title FROM matches a, joined_matches b WHERE b.user_id = ? AND a.match_id = b.match_id AND a.status = 'open'";
	
	$stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($match_id, $title);
	
	$matches = "";
	
	while($stmt->fetch()) {
		$matches .= "<a href='match.php?matchId=";
		$matches .= $match_id;
		$matches .= "'>";
		$matches .= "<label class='matchInfo'>";
		$matches .= $title;
		$matches .= "</label></a><br/>";
	}
	
	if($matches == "") {
		echo "<a href='matchlist.php'><label class='matchInfo'>No current matches.</label></a><br/>";
	} else {
		echo $matches;
	}
	
	$stmt->close();
}

function changeImage($mysqli, $image, $userId) {
	$query = "UPDATE user_profile SET image = ? WHERE user_id = ?";

	$update = $mysqli->prepare($query);
	$update->bind_param('si', $image, $userId);
	
	if($update->execute()) {
		
		$update->close();
		header("Location: ../editprofile.php?ichange=2018215");
		
	} else {
		
		$update->close();
		header("Location: ../editprofile.php?ichange=6112195");
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
			
			header("Location: ../editprofile.php?pchange=2018215");
			
		} else {
			header("Location: ../editprofile.php?pchange=6112195");
		}
	
	} else {
		header("Location: ../editprofile.php?pchange=518181518");
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
	b.sport_name, a.category, a.date, a.deadline FROM matches a, sports b WHERE a.status = 'open' AND a.sport_id = b.sport_id AND UTC_TIMESTAMP() < a.deadline";
	
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
		echo "<a href='match.php?matchId=";
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
	$query = "SELECT a.user_id, a.first_name, a.last_name, a.skill_level, (SELECT correct_answer FROM match_tiebreakers) as tiebreaker_answer, 
	(SELECT d.user_answer FROM match_tiebreakers c JOIN match_tiebreaker_answers d ON c.tiebreaker_id = d.tiebreaker_id WHERE d.user_id = a.user_id) 
	AS tiebreaker_guess FROM user_profile a, match_answers b, match_tiebreakers c, match_tiebreaker_answers d 
	WHERE c.match_id = ? AND a.user_id = b.user_id AND c.tiebreaker_id = d.tiebreaker_id GROUP BY a.user_id";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $match_id);
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
		echo "<tr><td>";
		echo $i + 1;
		echo "</td><td><a href='dashboard.php?id=";
		echo $allRankings['id'][$i];
		echo "'>";
		echo $allRankings['first_name'][$i] . " " . $allRankings['last_name'][$i];
		echo "</a></td><td>";
		echo $allRankings['skill_level'][$i];
		echo "</td><td>";
		
		if($allRankings['skill_points'][$i] != null && $allRankings['skill_points'][$i] != "") {
			echo $allRankings['skill_points'][$i];
		} else {
			echo "0";
		}
		echo "</td><td>";
		
		$remaining = getMatchDeadline($mysqli, $match_id);
		if($remaining > 0) { // Before Match Deadline
			if($allRankings['id'][$i] != $_COOKIE['user_id']) {
				echo "<a><label onClick='viewAlert()'>View</label></a>";
			} else {
				echo "<a href='matchpicks.php?matchId=";
			echo $match_id;
			echo "&userId=";
			echo $allRankings['id'][$i];
			echo "'>";
			echo "Edit";
			echo "</a></td></tr>";
			}
		} else { // Match Deadline Passed
			echo "<a href='matchpicks.php?matchId=";
			echo $match_id;
			echo "&userId=";
			echo $allRankings['id'][$i];
			echo "'>";
			echo "View";
			echo "</a></td></tr>";
		}
	}
}

function getMatchTitle($mysqli, $match_id) {
	$query = "SELECT title FROM matches WHERE match_id = ?";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($title);
	$stmt->fetch();
	
	echo $title;
	
	$stmt->close();
}

function getMatchDeadline($mysqli, $match_id) {
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

function checkMatchJoin($mysqli, $match_id, $user_id) {
	$query = "SELECT COUNT(*) FROM joined_matches WHERE match_id = ? AND user_id = ?";
	
	$stmt = $mysqli->prepare($query);
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

function getQuestions($mysqli, $match_id) {
	$query = "SELECT a.question_id, a.question, a.skill_points, b.question FROM match_questions a, match_tiebreakers b 
	WHERE a.match_id = ? AND a.question_id != 0";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $match_id);
	$stmt->execute();
	$stmt->bind_result($question_id, $question, $skill_points, $tiebreaker);
	
	$questions = array();
	$allQuestions = array();
	
	while($stmt->fetch()) {
		$questions['id'] = $question_id;
		$questions['text'] = $question;
		$questions['skill_points'] = $skill_points;
		
		$allQuestions[] = $questions;
	}
	$stmt->close();
	
	for($i = 0; $i < count($allQuestions); $i++) {
		// Display Question
		echo "<tr><td>";
		echo "<label>Question ";
		echo $i+1;
		echo " - ";
		echo $allQuestions[$i]['text'];
		echo "</td><td>";
		echo "</label><label class='value'>Points: ";
		echo $allQuestions[$i]['skill_points'];
		echo "</label></td></tr>";
		
		// Display Options
		echo "<tr><td>";
		echo "<select name='q";
		echo $i+1;
		echo "' id='q";
		echo $i+1;
		echo "'><option value=''>Select Pick</option>";
		
		$allOptions = getOptions($mysqli, $match_id, $allQuestions[$i]['id']);
		$savedPicks = getSavedPicks($mysqli, $match_id, $_GET['userId']);
		
		for($j = 0; $j < count($allOptions); $j++) {
			if($allOptions[$j]['question_id'] == $savedPicks[$i]['question_id'] && $allOptions[$j]['question_option'] == $savedPicks[$i]['answer']) {
				echo "<option selected>";
				echo $allOptions[$j]['question_option'];
				echo "</option>";
			} else {
				echo "<option>";
				echo $allOptions[$j]['question_option'];
				echo "</option>";
			}
		}
		echo "</select></td></tr>";
	}
	
	echo "<tr><td colspan=2>";
	echo "<label>Tiebreaker - ";
	echo $tiebreaker;
	echo "</label></td></tr>";
	echo "<tr><td><input type='text' name='q21' id='q21'/></td></tr>";
}

function getOptions($mysqli, $match_id, $question_id) {
	$query = "SELECT question_id, options FROM match_options WHERE match_id = ? AND question_id = ?";
	
	$stmt = $mysqli->prepare($query);
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

function savePicks($mysqli, $user_id, $match_id, $question_id, $answer) {
	$query = "SELECT result_id FROM match_answers WHERE user_id = ? AND match_id = ? AND question_id = ?";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('iii', $user_id, $match_id, $question_id);
	$stmt->execute();
	$stmt->store_result();
    $stmt->bind_result($result_id);
	$stmt->fetch();
	
	if($stmt->num_rows == 0) {
		$stmt->close();
		$query = "INSERT INTO match_answers (user_id, match_id, question_id, user_answer) VALUES (?, ?, ?, ?)";
		
		$insert_stmt = $mysqli->prepare($query);
		$insert_stmt->bind_param('iiis', $user_id, $match_id, $question_id, $answer);
		$insert_stmt->execute();
		$insert_stmt->close();
	} else {
		$stmt->close();
		$query = "UPDATE match_answers SET user_answer = ? WHERE user_id = ? AND match_id = ? AND question_id = ?";
	
		$update_stmt = $mysqli->prepare($query);
		$update_stmt->bind_param('siii', $answer, $user_id, $match_id, $question_id);
		$update_stmt->execute();
		$update_stmt->close();
	}
	header ("Location: ../match.php?matchId=$match_id&picks=2018215");
}

function saveTiebreaker($mysqli, $user_id, $tiebreaker_id, $answer) {
	$query = "SELECT result_id FROM match_tiebreaker_answers WHERE user_id = ? AND tiebreaker_id = ?";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('ii', $user_id, $tiebreaker_id);
	$stmt->execute();
	$stmt->store_result();
    $stmt->bind_result($result_id);
	$stmt->fetch();
	
	if($stmt->num_rows == 0) {
		$stmt->close();
		$query = "INSERT INTO match_tiebreaker_answers (user_id, tiebreaker_id, user_answer) VALUES (?, ?, ?)";
		
		$insert_stmt = $mysqli->prepare($query);
		$insert_stmt->bind_param('iis', $user_id, $tiebreaker_id, $answer);
		$insert_stmt->execute();
		$insert_stmt->close();
	} else {
		$stmt->close();
		$query = "UPDATE match_tiebreaker_answers SET user_answer = ? WHERE user_id = ? AND tiebreaker_id = ?";
	
		$update_stmt = $mysqli->prepare($query);
		$update_stmt->bind_param('sii', $answer, $user_id, $tiebreaker_id);
		$update_stmt->execute();
		$update_stmt->close();
	}
	//header ("Location: ../match.php?matchId=$match_id&picks=2018215");
}

function getSavedPicks($mysqli, $match_id, $user_id) {
	$query = "SELECT question_id, user_answer FROM match_answers WHERE match_id = ? AND question_id != 0 AND user_id = ?";
	
	$stmt = $mysqli->prepare($query);
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

function getSavedTiebreaker($mysqli, $tiebreaker_id, $user_id) {
	$query = "SELECT user_answer FROM match_tiebreaker_answers WHERE tiebreaker_id = ? AND user_id = ?";
	
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('ii', $tiebreaker_id, $user_id);
	$stmt->execute();
	$stmt->bind_result($user_answer);
	$stmt->fetch();
	$stmt->close();
	
	return $user_answer;
}
?>
