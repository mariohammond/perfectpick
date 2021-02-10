<?php
	include_once '../connect/db-connect.php';

	// Matches Played Achievements
	function checkMatches($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a WHERE a.user_id = ?";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '1')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '11')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '21')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '31')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '41')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
		
		return $count;
	}
	
	function checkWins($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a WHERE a.user_id = ? AND wins = 1";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '2')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '12')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '22')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '32')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '42')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkTop3Finishes($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a WHERE a.user_id = ? AND top_three_finish = 1";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '3')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '13')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '23')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '33')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '43')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkTop5Finishes($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a WHERE a.user_id = ? AND top_five_finish = 1";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '4')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '14')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '24')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '34')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '44')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkTop10Finishes($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a WHERE a.user_id = ? AND top_ten_finish = 1";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '5')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '15')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '25')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '35')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '45')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkNFLWins($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a, matches b, sports c WHERE a.user_id = ? AND a.wins = 1 AND a.match_id = b.match_id AND b.sport_id = c.sport_id AND c.sport_name = 'NFL'";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '6')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '16')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '26')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '36')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '46')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkNBAWins($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a, matches b, sports c WHERE a.user_id = ? AND a.wins = 1 AND a.match_id = b.match_id AND b.sport_id = c.sport_id AND c.sport_name = 'NBA'";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '7')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '17')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '27')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '37')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '47')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkMLBWins($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a, matches b, sports c WHERE a.user_id = ? AND a.wins = 1 AND a.match_id = b.match_id AND b.sport_id = c.sport_id AND c.sport_name = 'MLB'";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '8')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '18')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '28')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '38')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '48')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkNHLWins($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a, matches b, sports c WHERE a.user_id = ? AND a.wins = 1 AND a.match_id = b.match_id AND b.sport_id = c.sport_id AND c.sport_name = 'NHL'";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '9')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '19')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '29')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '39')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '49')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkNCAAWins($connection, $currentId) {
		$query = "SELECT COUNT(*) FROM match_stats a, matches b, sports c WHERE a.user_id = ? AND a.wins = 1 AND a.match_id = b.match_id AND b.sport_id = c.sport_id AND (sport_name = 'NCAAF' OR sport_name = 'NCAAB')";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($count);
        $stmt->fetch();
		$stmt->close();
		
		if ($count == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '10')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 5) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '20')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 10) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '30')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 25) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '40')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($count == 50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '50')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkMatchAccuracy($connection, $matchId, $currentId) {
		$query = "SELECT a.accuracy FROM match_stats a WHERE a.match_id = ? AND user_id = ?";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('ii', $matchId, $currentId);
		$stmt->execute();
		$stmt->bind_result($accuracy);
        $stmt->fetch();
		$stmt->close();
		
		if ($accuracy >= 0.50) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '51')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
		
		if ($accuracy >= 0.60) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '52')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
		
		if ($accuracy >= 0.80) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '53')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
		
		if ($accuracy == 1) {
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '58')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
	
	function checkCareerAccuracy($connection, $currentId) {
		// Check total matches
		$matchCount = checkMatches($connection, $currentId);
		
		if ($matchCount >= 5) {
			// Get total questions answered
			$query = "SELECT COUNT(*) FROM match_answers a, matches b WHERE a.question_id != 0 AND a.user_id = ? AND a.match_id = b.match_id AND b.status = 'closed'";
			
			$stmt = $connection->prepare($query);
			$stmt->bind_param('i', $currentId);
			$stmt->execute();
			$stmt->bind_result($totalCount);
			$stmt->fetch();
			$stmt->close();
			
			// Get total correct answers
			$query = "SELECT SUM(a.number_correct) FROM match_stats a WHERE a.user_id = ?";
			
			$stmt = $connection->prepare($query);
			$stmt->bind_param('i', $currentId);
			$stmt->execute();
			$stmt->bind_result($correctAnswers);
			$stmt->fetch();
			$stmt->close();
			
			$career_accuracy = $correctAnswers / $totalCount;
			
			if ($career_accuracy >= 0.50) {
				$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '54')";
				$insert_stmt = $connection->prepare($query);
				$insert_stmt->bind_param('i', $currentId);
				$insert_stmt->execute();
				$insert_stmt->close();
			}
			
			if ($career_accuracy >= 0.60) {
				$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '55')";
				$insert_stmt = $connection->prepare($query);
				$insert_stmt->bind_param('i', $currentId);
				$insert_stmt->execute();
				$insert_stmt->close();
			}
			
			if ($career_accuracy >= 0.80) {
				$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '56')";
				$insert_stmt = $connection->prepare($query);
				$insert_stmt->bind_param('i', $currentId);
				$insert_stmt->execute();
				$insert_stmt->close();
			}
		}
	}
	
	function checkSkillLevel($connection, $currentId) {
		$query = "SELECT SUM(total_points) FROM match_stats WHERE user_id = ?";
		
		$stmt = $connection->prepare($query);
		$stmt->bind_param('i', $currentId);
		$stmt->execute();
		$stmt->bind_result($skill_points);
        $stmt->fetch();
		$stmt->close();
		
		if ($skill_points >= 200000) {
			$query = "UPDATE user_profile SET skill_level = 'Legend' WHERE user_id = ?";
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('i', $currentId);
			$update_stmt->execute();
			$update_stmt->close();
			
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '69')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($skill_points >= 160000) {
			$query = "UPDATE user_profile SET skill_level = 'Hall Of Famer' WHERE user_id = ?";
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('i', $currentId);
			$update_stmt->execute();
			$update_stmt->close();
			
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '68')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($skill_points >= 126000) {
			$query = "UPDATE user_profile SET skill_level = 'Champion' WHERE user_id = ?";
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('i', $currentId);
			$update_stmt->execute();
			$update_stmt->close();
			
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '67')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($skill_points >= 96000) {
			$query = "UPDATE user_profile SET skill_level = 'MVP' WHERE user_id = ?";
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('i', $currentId);
			$update_stmt->execute();
			$update_stmt->close();
			
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '66')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($skill_points >= 70000) {
			$query = "UPDATE user_profile SET skill_level = 'All-Star' WHERE user_id = ?";
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('i', $currentId);
			$update_stmt->execute();
			$update_stmt->close();
			
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '65')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($skill_points >= 48000) {
			$query = "UPDATE user_profile SET skill_level = 'Captain' WHERE user_id = ?";
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('i', $currentId);
			$update_stmt->execute();
			$update_stmt->close();
			
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '64')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($skill_points >= 30000) {
			$query = "UPDATE user_profile SET skill_level = 'Starter' WHERE user_id = ?";
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('i', $currentId);
			$update_stmt->execute();
			$update_stmt->close();
			
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '63')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($skill_points >= 16000) {
			$query = "UPDATE user_profile SET skill_level = 'Rising Star' WHERE user_id = ?";
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('i', $currentId);
			$update_stmt->execute();
			$update_stmt->close();
			
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '62')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		} else if ($skill_points >= 6000) {
			$query = "UPDATE user_profile SET skill_level = 'Sixth Man' WHERE user_id = ?";
			$update_stmt = $connection->prepare($query);
			$update_stmt->bind_param('i', $currentId);
			$update_stmt->execute();
			$update_stmt->close();
			
			$query = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, '61')";
			$insert_stmt = $connection->prepare($query);
			$insert_stmt->bind_param('i', $currentId);
			$insert_stmt->execute();
			$insert_stmt->close();
		}
	}
?>
