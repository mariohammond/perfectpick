<?php
	include_once 'util/db_connect.php';
	include_once 'util/functions.php';
	sec_session_start();
	
	$seconds = getMatchDeadline($mysqli, $_GET['matchId']);
	$joined = checkMatchJoin($mysqli, $_GET['matchId'], $_COOKIE['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfect Pick'em</title>
	<link rel="icon" type="image/png" href="images/favicon.png" 
	
	<!-- JQuery: Start -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<!-- JQuery: End -->
	
	<!-- Vex Dialog Box: Start -->
	<script src="vex/js/vex.combined.min.js"></script>
	<script>vex.defaultOptions.className = 'vex-theme-os';</script>
	<link rel="stylesheet" href="vex/css/vex.css" />
	<link rel="stylesheet" href="vex/css/vex-theme-os.css" />
	<!-- Vex Dialog Box: End -->
	
	<!-- Join Match: Start -->
	<script>
	function joinMatch(matchId) {
		vex.dialog.confirm({
		  message: 'Join this match?',
		  callback: function(value) {
			if(value == true) {
				document.getElementById("MatchMenuContainer").innerHTML = "";
		
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("MatchMenuContainer").innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET", "util/join_match.php?match=" + matchId, true); 
				xmlhttp.send();
				setInterval(function(){window.location.replace('matchpicks.php?matchId=' + matchId + "&userId=" + <?php echo $_COOKIE['user_id'] ?>)}, 500);
			} else {
				window.location.replace('<?php echo $_SERVER['REQUEST_URI']; ?>');
			}
		  }
		});
	}
	</script>
	<!-- Join Match: End -->
	
	<!-- Quit Match: Start -->
	<script>
	function quitMatch(matchId) {
		vex.dialog.confirm({
		  message: 'Leave match? All saved picks will be erased.',
		  callback: function(value) {
			if(value == true) {
				document.getElementById("MatchMenuContainer").innerHTML = "";
		
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("MatchMenuContainer").innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET", "util/quit_match.php?match=" + matchId, true); 
				xmlhttp.send();
				setInterval(function(){window.location.replace('<?php echo $_SERVER['REQUEST_URI']; ?>')}, 500);
			} else {
				window.location.replace('<?php echo $_SERVER['REQUEST_URI']; ?>');
			}
		  }
		});
	}
	</script>
	<!-- Quit Match: End -->
	
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
				window.location.replace('<?php echo $_SERVER['REQUEST_URI']; ?>');
			}
		} else {
			document.getElementById('countdown').style.display = "none";
		}
	}
	var countdownTimer = setInterval('secondPassed()', 1000);
	</script>
	<!-- Countdown Timer: End -->
	
	<!-- Messi Popup: Start -->
	<link rel="stylesheet" href="messi/messi.css" />
	<script src="messi/messi.js"></script>
	<!-- Messi Popup: End -->
	
	<!-- View Alert: Start -->
	<script>
	function viewAlert() {
		new Messi("Opponent views will be available once match closes.", {title: 'View Picks', modal: true, width: 'auto'});
	}
	</script>
	<!-- View Alert: End -->
	
	<!-- CSS: Start -->
	<link rel="stylesheet" href="css/main.css" />
	<!-- CSS: End -->
</head>
<body>
	<?php include 'header.php'; ?>
	<div id="FullMatch">
		<div id="MatchMessage">
			<?php if(isset($_GET['picks']) && $_GET['picks'] == '2018215') : ?>
				<label>Picks Saved!</label>
			<?php endif; ?>
		</div>
		<?php if($seconds > 0) : ?>
		<div id="MatchMenuContainer">
			<?php if($joined == false) : ?>
			<div id="JoinMatchContainer" onClick="joinMatch(<?php echo $_GET['matchId'] ?>)" >
				<label>Join Match</label>
			</div>
			<div id="ViewQuestionsContainer" onClick="location.href='matchpicks.php?matchId=<?php echo $_GET['matchId']; ?>';">
				<label>View Questions</label>
			</div>
			<?php endif; ?>
			<?php if($joined == true) : ?>
			<div id="JoinMatchContainer" onClick="quitMatch(<?php echo $_GET['matchId'] ?>)" >
				<label>Quit Match</label>
			</div>
			<div id="ViewQuestionsContainer" onClick="location.href='matchpicks.php?matchId=<?php echo $_GET['matchId']; ?>&userId=<?php echo $_COOKIE['user_id']; ?>';">
				<label>Edit Picks</label>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div id="MatchTitleContainer">
			<label class='mainTitle'><?php getMatchTitle($mysqli, $_GET['matchId']); ?></label>
			<span id='countdown'></span>
		</div>
		<div id="StandingsContainer">
			<table>
				<thead>
					<tr>
						<th colspan='5' class='title'><label>Standings</label></th>
					</tr>
					<tr>
						<th>Rank</th>
						<th>Name</th>
						<th>Skill Level</th>
						<th>Score</th>
						<th>Picks</th>
					</tr>
				</thead>
				<tbody>
					<?php getStandings($mysqli, $_GET['matchId']); ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
