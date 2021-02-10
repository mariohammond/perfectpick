<?php 
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	
	session_start();
	
	$seconds = getMatchDeadline($connection, $_GET['matchId']);
	$match = getMatchInfo($connection, $_GET['matchId']);
	
	// Redirect if match id not set
	if (!isset($_GET['matchId'])) {
		header("Location: matches");	
	}
	
	// Redirect if match still open
	if ($seconds > 0) {
		header("Location: matches");	
	}
	
	// Set variable if user id not set
	if (isset($_GET['userId'])) {
		$userId = $_GET['userId'];
	} else {
		$userId = $_COOKIE['user_id'];
	}
	
	$user_info = getUserInfo($connection, $userId);
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Picks | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
</head>
<body>
	<div class="ViewWrapper">
		<?php include 'menu.php'; ?>
        <?php include 'header.php'; ?>
        <div class="MatchContainer Main">
            <div class="cover-container"></div>
            <?php if ($seconds <= 0) : ?>
            <div class="view-only-container"></div>
            <?php endif; ?>
            <div class="QuestionContainer">
                <div class="MatchTitle">
                    <h1><?php echo $match['title']; ?></h1>
                    <h2 style="text-align:center; font-weight:400;"><?php echo $user_info['first_name'] . ' ' . $user_info['last_name']; ?></h2>
                </div>
                <div id="<?php echo $_GET['matchId']; ?>" class="MatchQuestions" style="display: block; height: auto;">
                <?php $questionsCount = viewPicks($connection, $_GET['matchId'], $userId); ?>
                </div>
            </div>
		</div>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
