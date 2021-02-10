<?php
	include_once 'util/db_connect.php';
	include_once 'util/functions.php';
	sec_session_start();
		
	if(!isset($_GET['matchId']) || $_GET['matchId'] == "") {
		header('Location: matchlist.php');
	}
	
	$seconds = getMatchDeadline($mysqli, $_GET['matchId']);
	$tiebreaker = getSavedTiebreaker($mysqli, $_GET['matchId'], $_GET['userId']);
	
	if(isset($_POST['q1'])) {
		$q1 = filter_input(INPUT_POST, 'q1', FILTER_SANITIZE_STRING); $q2 = filter_input(INPUT_POST, 'q2', FILTER_SANITIZE_STRING);
		$q3 = filter_input(INPUT_POST, 'q3', FILTER_SANITIZE_STRING); $q4 = filter_input(INPUT_POST, 'q4', FILTER_SANITIZE_STRING);
		$q5 = filter_input(INPUT_POST, 'q5', FILTER_SANITIZE_STRING); $q6 = filter_input(INPUT_POST, 'q6', FILTER_SANITIZE_STRING);
		$q7 = filter_input(INPUT_POST, 'q7', FILTER_SANITIZE_STRING); $q8 = filter_input(INPUT_POST, 'q8', FILTER_SANITIZE_STRING);
		$q9 = filter_input(INPUT_POST, 'q9', FILTER_SANITIZE_STRING); $q10 = filter_input(INPUT_POST, 'q10', FILTER_SANITIZE_STRING);
		$q11 = filter_input(INPUT_POST, 'q11', FILTER_SANITIZE_STRING);	$q12 = filter_input(INPUT_POST, 'q12', FILTER_SANITIZE_STRING);
		$q13 = filter_input(INPUT_POST, 'q13', FILTER_SANITIZE_STRING);	$q14 = filter_input(INPUT_POST, 'q14', FILTER_SANITIZE_STRING);
		$q15 = filter_input(INPUT_POST, 'q15', FILTER_SANITIZE_STRING);	$q16 = filter_input(INPUT_POST, 'q16', FILTER_SANITIZE_STRING);
		$q17 = filter_input(INPUT_POST, 'q17', FILTER_SANITIZE_STRING);	$q18 = filter_input(INPUT_POST, 'q18', FILTER_SANITIZE_STRING);
		$q19 = filter_input(INPUT_POST, 'q19', FILTER_SANITIZE_STRING);	$q20 = filter_input(INPUT_POST, 'q20', FILTER_SANITIZE_STRING);
		$q21 = filter_input(INPUT_POST, 'q21', FILTER_SANITIZE_STRING);
		
		$qAll = array();
		
		array_push($qAll, $q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10, $q11, $q12, $q13, $q14, $q15, $q16, $q17, $q18, $q19, $q20, $q21);
		
		saveTiebreaker($mysqli, $_GET['userId'], $_GET['matchId'], $q21);
		for($i = 0; $i < count($qAll); $i++) {
			$question_id = $i + 1;
			savePicks($mysqli, $_GET['userId'], $_GET['matchId'], $question_id, $qAll[$i]);
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfect Pick'em</title>
	<link rel="icon" type="image/png" href="images/favicon.png" />
	
	<!-- JQuery: Start -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<!-- JQuery: End -->
	
	<!-- Countdown Timer: Start -->
	<script>
	var seconds = <?php echo $seconds; ?>;
	function secondPassed() {
		if (seconds > 0) {
			var remainingDays = Math.floor(seconds / 86400);
			var remainingHours = Math.floor((seconds % 86400) / 3600);
			var remainingMinutes = Math.floor(((seconds % 86400) % 3600) / 60);
			var remainingSeconds = Math.floor(((seconds % 86400) % 3600) % 60);
			
			var dayTitle  = ' Days ';
			var hourTitle = ' Hours ';
			var minuteTitle = ' Minutes ';
			var secondTitle = ' Seconds';
			
			if(remainingDays == 0) { remainingDays = ''; dayTitle = ''; }
			if(remainingHours == 0) { remainingHours = ''; hourTitle = ''; }
			if(remainingMinutes == 0) { remainingMinutes = ''; minuteTitle = ''; }
			if(remainingSeconds == 0) { remainingSeconds = ''; secondTitle = ''; }
			
			if(remainingDays == 1) { dayTitle = ' Day '; }
			if(remainingHours == 1) { hourTitle = ' Hour '; }
			if(remainingMinutes == 1) { minuteTitle = ' Minute '; }
			if(remainingSeconds == 1) { secondTitle = ' Second'; }
			
			document.getElementById('countdown').style.backgroundColor = "#ffffff";
			document.getElementById('countdown').innerHTML = "Match closes in: " +
				remainingDays + dayTitle + remainingHours + hourTitle + remainingMinutes + minuteTitle + remainingSeconds + secondTitle;
			
			seconds--;
			
			if (seconds == 0) {
				clearInterval(countdownTimer);
				window.location.replace("match.php?matchId=<?php echo $_GET['matchId']; ?>");
			}
		} else {
			document.getElementById('countdown').style.display = "none";
		}
	}
	var countdownTimer = setInterval('secondPassed()', 1000);
	</script>
	<!-- Countdown Timer: End -->
	
	<!-- Check Match Deadline: Start -->
	<script>
	function checkDeadline() {
		document.getElementById('q21').value = '<?php echo $tiebreaker; ?>';
		
		var deadline = <?php echo $seconds; ?>;
		if(deadline < 0) {
			document.getElementById('q21').disabled = true;
			for (i = 0; i < 20; i++) {
				var id = i + 1;
				var question_id = "q" + id.toString();
				document.getElementById(question_id).disabled = true;
			}
		}
	}
	</script>
	<!-- Check Match Deadline: End -->
	
	<!-- Match Home: Start -->
	<script>
	function matchHome() {
		window.location.replace("match.php?matchId=<?php echo $_GET['matchId']; ?>");
	}
	</script>
	<!-- Match Home: End -->
	
	<!-- CSS: Start -->
	<link rel="stylesheet" href="css/main.css" />
	<!-- CSS: End -->
</head>
<body onLoad=checkDeadline()>
	<?php include 'header.php'; ?>
	<div id="FullMatchPicks">
		<div id="MatchMenuContainer">
			<div id="MatchHomeContainer" onClick="matchHome()" >
				<label>Match Home</label>
			</div>
		</div>
		<div id="PicksTitleContainer">
			<label class='mainTitle'><?php getMatchTitle($mysqli, $_GET['matchId']); ?></label>
			<span id='countdown'></span>
		</div>
		<div id="PicksContainer">
			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="search_form">
				<table>
					<?php getQuestions($mysqli, $_GET['matchId']); ?>
				</table>
				<?php if($seconds > 0) : ?>
					<input type='submit' id='save' value='Save Picks' />
					<input type='button' id='cancel' value='Cancel' onClick='matchHome()'/>
				<?php endif; ?>
			</form>
		</div>
	</div>
</body>
</html>
