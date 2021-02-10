<?php
	include_once '../connect/db-connect.php';
	include_once '../util/functions.php';
	include_once 'admin-functions.php';
	
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	
	$password = '1';
	$match_stats = array();
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex,nofollow"/>
    <title>Admin Page</title>
</head>
<body>
	<?php if (!isset($_POST['password']) || $_POST['password'] != $password) : ?>
	<form method="post">
    	<input type="password" name="password" />
        <input type="submit" /><br/>
    </form>
    <?php endif; ?>
    
    <?php if (isset($_POST['password']) && $_POST['password'] == $password) : ?>
    <form method="post">
    	<label>Enter match ID: </label>
        <input type="text" name="matchId"/>
    	<input type="submit" name="close-match" value="Close Match"/>
    <?php endif; ?>
	</form>
    
    <?php
		// Get match id
		$match_id = $_POST['matchId'];
			
		// Get total score of all participants
		$query = "SELECT DISTINCT b.user_id, SUM(a.skill_points) FROM match_questions a, match_answers b WHERE a.match_id = ? AND a.match_id = b.match_id AND a.question_id = b.question_id AND a.correct_answer = b.user_answer GROUP BY b.user_id ORDER BY b.user_id";
	
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $match_id);
		$stmt->execute();
		$stmt->bind_result($user_id, $matchPoints);
		
		$allIds = array();
		$allPoints = array();
		while($stmt->fetch()) {
			$allIds[] = $user_id;
			$allPoints[] = $matchPoints;
		}
		
		$allMatchPoints = array();
		$allMatchPoints['id'] = $allIds;
		$allMatchPoints['points'] = $allPoints;
		$stmt->close();
		
		// Get tiebreaker answer
		$query = "SELECT correct_answer FROM match_tiebreakers WHERE match_id = ?";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $match_id);
		$stmt->execute();
		$stmt->bind_result($tiebreaker_answer);
		$stmt->fetch();
		$stmt->close();
		
		// Get tiebreaker guess of all participants
		$query = "SELECT user_answer FROM match_tiebreaker_answers WHERE tiebreaker_id = ? ORDER BY user_id";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $match_id);
		$stmt->execute();
		$stmt->bind_result($tiebreakers);
		
		$allTiebreakers = array();
		while($stmt->fetch()) {
			$allTiebreakers[] = $tiebreakers;
		}
		$stmt->close();
		
		// Add tiebreaker points to total and sort
		for ($i = 0; $i < count($allTiebreakers); $i++) {
			if ($tiebreaker_answer > $allTiebreakers[$i]) {
				$tiebreaker_points = $allTiebreakers[$i] / $tiebreaker_answer;
			} else {
				$tiebreaker_points = $tiebreaker_answer / $allTiebreakers[$i];
			}
			
			$allMatchPoints['points'][$i] += $tiebreaker_points;
		}
		
		array_multisort($allMatchPoints['points'], SORT_DESC, $allMatchPoints['id']);
		
		// Get match winner
		$winnerId = $allMatchPoints['id'][0];
		
		// Get Top 3
		$topThreeIds = array();
		for ($i = 0; $i < 3; $i++) {
			$topThreeIds[] = $allMatchPoints['id'][$i];
		}
		
		// Get Top 5
		$topFiveIds = array();
		for ($i = 0; $i < 5; $i++) {
			$topFiveIds[] = $allMatchPoints['id'][$i];
		}
		
		// Get Top 10
		$topTenIds = array();
		for ($i = 0; $i < 10; $i++) {
			$topTenIds[] = $allMatchPoints['id'][$i];
		}
 		
		// Get all match participants
		$query = "SELECT user_id FROM joined_matches WHERE match_id = ? ORDER BY user_id";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $_POST['matchId']);
		$stmt->execute();
		$stmt->bind_result($id);
		
		$ids = array();
		while($stmt->fetch()) {
			$ids[] = $id;	
		}
		$stmt->close();
		
		foreach ($ids as $currentId) {
			// Get match date
			$match_date = date("Y-m-d");
			
			// Get total match points
			$query = "SELECT DISTINCT SUM(a.skill_points) FROM match_questions a, match_answers b WHERE a.match_id = ? AND b.user_id = ? AND a.match_id = b.match_id AND a.question_id = b.question_id AND a.correct_answer = b.user_answer";
		
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ii', $match_id, $currentId);
			$stmt->execute();
			$stmt->bind_result($totalPoints);
			$stmt->fetch();
			$stmt->close();
			
			// Get total questions answered
			$query = "SELECT COUNT(*) FROM match_answers a, matches b WHERE a.question_id != 0 AND a.user_id = ? AND a.match_id = ? AND a.match_id = b.match_id";
	
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ii', $currentId, $match_id);
			$stmt->execute();
			$stmt->bind_result($totalCount);
			$stmt->fetch();
			$stmt->close();
			
			// Get correct number of answers
			$query = "SELECT DISTINCT COUNT(a.skill_points) FROM match_questions a, match_answers b WHERE b.user_id = ? AND a.match_id = ? AND a.match_id = b.match_id AND a.question_id = b.question_id AND a.correct_answer = b.user_answer AND a.question_id != 0 GROUP BY b.user_id ORDER BY b.user_id";
	
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ii', $currentId, $match_id);
			$stmt->execute();
			$stmt->bind_result($numberCorrect);
			$stmt->fetch();
			$stmt->close();
			
			if (!isset($numberCorrect)) {
				$numberCorrect = 0;	
			}
			
			// Get pick accuracy for match
			$accuracy = $numberCorrect / $totalCount;
			
			// Get user ranking
			$key = array_search($currentId, $allMatchPoints['id']);
			$ranking = $key + 1;
			
			// Check if user won match
			if ($winnerId == $currentId) {
				// Update current win streak
				$query = "SELECT current_win_streak FROM user_profile WHERE user_id = ?";
				
				$stmt = $connection->prepare($query);
				$stmt->bind_param('i', $currentId);
				$stmt->execute();
				$stmt->bind_result($currentStreak);
				$stmt->fetch();
				$stmt->close();
				
				$newStreak = $currentStreak + 1;
				
				$query = "UPDATE user_profile SET current_win_streak = $newStreak WHERE user_id = ?";
	
				$stmt = $connection->prepare($query);
				$stmt->bind_param('i', $currentId);
				$stmt->execute();
				$stmt->close();
				
				// Give user winner token
				$winToken = 1;
			} else {
				// Update current win streak
				$query = "UPDATE user_profile SET current_win_streak = 0 WHERE user_id = ?";
	
				$stmt = $connection->prepare($query);
				$stmt->bind_param('i', $currentId);
				$stmt->execute();
				$stmt->close();
				
				// Give user non-winner token
				$winToken = 0;
			}
			
			// Check if user is in top 3
			foreach ($topThreeIds as $top3) {
				if ($top3 == $currentId) {
					$topThreeToken = 1;
					break;
				} else {
					$topThreeToken = 0;
				}
			}
			
			// Check if user is in top 5
			foreach ($topFiveIds as $top5) {
				if ($top5 == $currentId) {
					$topFiveToken = 1;
					break;
				} else {
					$topFiveToken = 0;
				}
			}
			
			// Check if user is in top 10
			foreach ($topTenIds as $top10) {
				if ($top10 == $currentId) {
					$topTenToken = 1;
					break;
				} else {
					$topTenToken = 0;
				}
			}
			
			/*echo "id: " . $currentId . "<br>";
			echo "match: " . $match_id . "<br>";
			echo "date: " . $match_date . "<br>";
			echo "numCorrect: " . $numberCorrect . "<br>";
			echo "acc: " . $accuracy . "<br>";
			echo "totalPts: " . $totalPoints . "<br>";
			echo "rank: " . $ranking . "<br>";
			echo "tokens: " . $winToken . $topThreeToken . $topFiveToken . $topTenToken;*/
			
			// Add user stats into db
			$query = "INSERT INTO match_stats (user_id, match_id, match_date, number_correct, accuracy, total_points, ranking, wins, top_three_finish, top_five_finish, top_ten_finish) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
			$stmt = $connection->prepare($query);
			$stmt->bind_param('iisidiiiiii', $currentId, $match_id, $match_date, $numberCorrect, $accuracy, $totalPoints, $ranking, $winToken, $topThreeToken, $topFiveToken, $topTenToken);
			$stmt->execute();
			$stmt->close();
			
			// Add new achievements into db
			checkMatches($connection, $currentId);
			checkWins($connection, $currentId);
			checkTop3Finishes($connection, $currentId);
			checkTop5Finishes($connection, $currentId);
			checkTop10Finishes($connection, $currentId);
			checkNFLWins($connection, $currentId);
			checkNBAWins($connection, $currentId);
			checkMLBWins($connection, $currentId);
			checkNHLWins($connection, $currentId);
			checkNCAAWins($connection, $currentId);
			checkMatchAccuracy($connection, $match_id, $currentId);
			checkCareerAccuracy($connection, $currentId);
			checkSkillLevel($connection, $currentId);
		}
		
		// Close match
		$query = "UPDATE matches SET status = 'closed' WHERE match_id = ?";
	
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $match_id);
		$stmt->execute();
		$stmt->close();
	?>
</body>
</html>
