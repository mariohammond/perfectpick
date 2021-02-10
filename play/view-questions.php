<?php 
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	
	session_start();
	$matchId = $_GET['matchId'];
	
	$match = getMatchInfo($connection, $matchId);
	$points = getAvailablePoints($connection, $matchId);
	$allQuestions = getQuestionsOnly($connection, $matchId);
	$tiebreakerInfo = getTiebreakerInfo($connection, $matchId);
	$seconds = getMatchDeadline($connection, $matchId);
	$joined = checkMatchJoin($connection, $matchId, $_COOKIE['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Picks | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
</head>
<body>
	<div class="ViewPicksWrapper">
		<?php include 'menu.php'; ?>
        <?php include 'header.php'; ?>
        <div id="<?php echo $matchId; ?>" class="ViewPicksContainer Main">
            <div class="cover-container"></div>
            <div id="region-1">
            	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle leaderboard"
                     style="display:block"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="2090693573"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <div class="MatchInfoContainer">
            	<div class="title-container">
                    <h1 class="start-title"><?php echo $match['title']; ?></h1>
                    <span><a href="/match?matchId=<?php echo $matchId;?>" data-category="pp-view-questions" data-action="return-button" data-label="standings-top">Back To Standings</a></span>
                </div>
                <h2 class="start-info">Start Date: <?php echo $match['date']; ?></h2>
                <h2 class="start-info">Start Time: <?php echo $match['time']; ?></h2>
                <h2 class="start-info">Available Points: <?php echo $points; ?></h2>
            </div>
            <div class="ViewQuestionsContainer left">
            	<?php for ($i = 0; $i < count($allQuestions); $i++) {
						$j = $i + 1;
						echo "<div id='qc$j' class='question-content'>";
						echo '<strong>Question ' . $j . '</strong> - ' . $allQuestions[$i]['text'] . ' <strong>(' . $allQuestions[$i]['skill_points'] . ' points)</strong>' . '<br><br>';
						if ($seconds <= 0) {
							$allAnswers = getAnswers($connection, $matchId, $allQuestions[$i]['id']);
						}
						echo '</div>';
				} ?>
                <div class="question-content">
                	<strong>Tiebreaker</strong> - <?php echo $tiebreakerInfo['question']; ?><br>
                    <?php if ($tiebreakerInfo['answer'] != 0) { echo "<p style='margin:10px 0; color:#00a550'>Correct Answer : " . $tiebreakerInfo['answer'] . "</p>"; } ?>
                    <?php if ($seconds <= 0) { getTiebreakers($connection, $matchId); } ?>
                </div>
                <div class="action-button">
                	<?php if($joined == false && $seconds > 0) : ?>
                    <a data-category="pp-view-questions" data-action="return-button" data-label="join-match" onClick="joinMatch(<?php echo $matchId; ?>)">Join Match</a>
                    <?php else: ?>
                	<a href="/match?matchId=<?php echo $matchId; ?>" data-category="pp-view-questions" data-action="return-button" data-label="standings-bottom">Back To Standings</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>
