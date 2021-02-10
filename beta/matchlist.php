<?php
	include_once 'util/db_connect.php';
	include_once 'util/functions.php';
	sec_session_start();
	
	if (isset($_POST['title']) || isset($_POST['sport']) || isset($_POST['category'])) {
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
		$sport = filter_input(INPUT_POST, 'sport', FILTER_SANITIZE_STRING);
		$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
	
		$parameters = "title=" . $title . "&sport=" . $sport . "&category=" . $category;
		header('Location: ./matchlist.php?' . $parameters);
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
	
	<!-- Vex Dialog Box: Start -->
	<script src="vex/js/vex.combined.min.js"></script>
	<script>vex.defaultOptions.className = 'vex-theme-os';</script>
	<link rel="stylesheet" href="vex/css/vex.css" />
	<link rel="stylesheet" href="vex/css/vex-theme-os.css" />
	<!-- Vex Dialog Box: End -->
	
	<!-- Data Table: Start -->
	<link rel="stylesheet" href="css/dataTables.css" />
	<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
	<script>
		$(function() {
			$("#MatchList").dataTable();
	  	})
	</script>
	<!-- Data Table: End -->
	
	<!-- Countdown Timer: Start -->
	<script>
	<?php getSeconds($mysqli); ?>
	function secondPassed() {
		for(var i = 0; i < seconds.length; i++) {
			var remainingDays = Math.floor(seconds[i] / 86400);
			var remainingHours = Math.floor((seconds[i] % 86400) / 3600);
			var remainingMinutes = Math.floor(((seconds[i] % 86400) % 3600) / 60);
			var remainingSeconds = Math.floor(((seconds[i] % 86400) % 3600) % 60);
			
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
			
			var newCountdown = 'countdown' + i;
			document.getElementById(newCountdown).innerHTML = 
				remainingDays + dayTitle + remainingHours + hourTitle + remainingMinutes + minuteTitle + remainingSeconds + secondTitle;
				
			seconds[i]--;
		
			if (seconds[i] == 0) {
				window.location.replace('<?php echo $_SERVER['REQUEST_URI']; ?>');
			}
			
			if (seconds[i] < 0) {
				document.getElementById(newCountdown).innerHTML = 'CLOSED';
			}
		}
	}
	var countdownTimer = setInterval('secondPassed()', 1000);
	</script>
	<!-- Countdown Timer: End -->
	
	<!-- Join Match: Start -->
	<script>
	function joinMatch(matchId) {
		vex.dialog.confirm({
		  message: 'Join this match?',
		  callback: function(value) {
			if(value == true) {
				document.getElementById("MatchListContainer").innerHTML = "";
		
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("MatchListContainer").innerHTML = xmlhttp.responseText;
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
				document.getElementById("MatchListContainer").innerHTML = "";
		
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("MatchListContainer").innerHTML = xmlhttp.responseText;
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
	
	<!-- Search Popup Box: Start -->
	<script>
		$(function() {
			$("#SearchMatchContainer").dialog ({
				autoOpen: false,
				height: 240,
				width: 365,
				modal: true,
				close: function() {}
			});
				
			$("#advSearch").click(function() {
				$("#SearchMatchContainer").dialog("open");
			});
		});
	</script>
  	<!-- Search Popup Box: End -->

	<!-- CSS: Start -->
	<link rel="stylesheet" href="css/main.css" />
	<!-- CSS: End -->
</head>
<body>
	<?php include 'header.php'; ?>
	<div id="FullMatchList">
		<div id="MatchListContainer">
			<div id="MatchListTitle">
				<label class="matchListTitle">Match List</label>
			</div>
			<table id="MatchList">
				<thead>
				 	<tr>
						<th>Title</th>
						<th>Sport</th>
						<th>Category</th>
						<th>Match Date</th>
						<th>Submission Deadline</th>
					</tr>
				</thead>
				<tbody>
				  	<?php getMatchList($mysqli); ?>
				</tbody>
			</table>
			<input type='button' id='advSearch' value='Advanced Search' />
		</div>
		<div id="SearchMatchContainer" title="Advanced Search">
			<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="search_form">
				<table>
					<tr>
						<td><label for="title">Title:</label></td>
						<td><input type="title" name="title" id="title" 
							onKeyDown="if (event.keyCode == 13) document.getElementById('searchButton').click()"/></td>
					</tr>
					<tr>
						<td><label for="sport">Sport:</label></td>
						<td><select name="sport" id="sport">
							<option value="">Select Sport</option>
							<?php getSports($mysqli) ?>
						</select>
					</td>
					</tr>
					<tr>
						<td><label for="category">Category:&nbsp;&nbsp;</label></td>
						<td><select name="category" id="category">
							<option value="">Select Category</option>
							<option value="Game">Game</option>
							<option value="Series">Series</option>
							<option value="Season">Season</option>
						</select>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center">
							<input type="submit" id="searchButton" value="Search Matches" />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>
