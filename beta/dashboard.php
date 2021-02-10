<?php
	include_once 'util/db_connect.php';
	include_once 'util/functions.php';
	sec_session_start();
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
	
	<!-- Messi Popup: Start -->
	<link rel="stylesheet" href="messi/messi.css" />
	<script src="messi/messi.js"></script>
	<!-- Messi Popup: End -->
	
	<!-- Get User Info: Start -->
	<script> 
	function loadUserInfo() {
		<?php
			$info = getUserInfo($mysqli, $_GET['id']);
			$teams = getFavoriteTeams($mysqli, $_GET['id']);
			$skill = getSkillLevel($mysqli, $_GET['id']);
		?>
	}
	</script>
	<!-- Get User Info: End -->
	
	<!-- CSS: Start -->
	<link rel="stylesheet" href="css/main.css" />
	<!-- CSS: End -->
</head>
<body onLoad="loadUserInfo()">
	<?php include 'header.php'; ?>
	<div id="FullDashboard">
		<div id="ProfileLeftContainer">
			<div id="NameContainer">
				<label class="nameLabel"><?php echo $info["first_name"] ?>&nbsp;<?php echo $info["last_name"] ?></label>
				<?php if($_GET['id'] == $_COOKIE['user_id']) : ?>
				<a class="editLabel" href="editprofile.php">EDIT PROFILE</a>
				<?php endif; ?>
			</div>
			<div id="InfoContainer">
				<div id="ProfileImage">
					<img class="image" src="<?php echo $info["image"] ?>" alt="Profile Image" />
				</div>
				<div id="ProfileInfo">
					<label class="infoLabel">Skill Level: <?php echo $skill['level'] ?></label><br/>
					<label class="infoLabel">Career Skill Points: <?php echo $skill['points'] ?></label><br/>
					<label class="infoLabel">Achievements Earned: 17</label>
				</div>
			</div>
			<div id="ProgressContainer">
				<div id="HistoryContainer">
					<div id="HistoryTitle">
						<label class="historyTitle">Match History</label>
					</div><br/>
					<div id="HistoryInfo">
						<label class="historyInfo"><strong>NFL Predictions I</strong></label><br/>
						<label class="historyInfo">August 1, 2012</label><br/>
						<label class="historyInfo">Ranking: 2nd</label><br/>
						<label class="historyInfo">Score: 220</label><br/>
						<label class="historyInfo">Pick Accuracy: 90%</label>
						<br/><br/>
						<label class="historyInfo"><strong>NFL Predictions I</strong></label><br/>
						<label class="historyInfo">August 1, 2012</label><br/>
						<label class="historyInfo">Ranking: 2nd</label><br/>
						<label class="historyInfo">Score: 220</label><br/>
						<label class="historyInfo">Pick Accuracy: 90%</label>
						<br/><br/>
						<label class="historyInfo"><strong>NFL Predictions I</strong></label><br/>
						<label class="historyInfo">August 1, 2012</label><br/>
						<label class="historyInfo">Ranking: 2nd</label><br/>
						<label class="historyInfo">Score: 220</label><br/>
						<label class="historyInfo">Pick Accuracy: 90%</label>
						<br/><br/>
						<label class="historyInfo"><strong>NFL Predictions I</strong></label><br/>
						<label class="historyInfo">August 1, 2012</label><br/>
						<label class="historyInfo">Ranking: 2nd</label><br/>
						<label class="historyInfo">Score: 220</label><br/>
						<label class="historyInfo">Pick Accuracy: 90%</label>
						<br/><br/>
						<label class="historyInfo"><strong>NFL Predictions I</strong></label><br/>
						<label class="historyInfo">August 1, 2012</label><br/>
						<label class="historyInfo">Ranking: 2nd</label><br/>
						<label class="historyInfo">Score: 220</label><br/>
						<label class="historyInfo">Pick Accuracy: 90%</label>
						<br/><br/>
						<label class="historyInfo"><strong>NFL Predictions I</strong></label><br/>
						<label class="historyInfo">August 1, 2012</label><br/>
						<label class="historyInfo">Ranking: 2nd</label><br/>
						<label class="historyInfo">Score: 220</label><br/>
						<label class="historyInfo">Pick Accuracy: 90%</label>
					</div>
				</div>
				<div id="AchievementContainer">
					<div id="AchievementTitle">
						<label class="achievementTitle">Achievements</label>
					</div><br/>
					<div id="AchievementInfo">
						<label class="achievementInfo"><strong>First Match!</strong></label><br/>
					</div>
				</div>
			</div>
		</div>
		<div id="ProfileRightContainer">
			<div id="FavTitle">
				<label class="favTitle">Favorite Teams</label>
			</div>
			<?php if(!isset($teams[0])) : ?>
				<div id="NoFavInfo">
					<?php if($_GET['id'] == $_COOKIE['user_id']) {
						echo "<a href='editprofile.php'><label class='infoLabel'>No favorite teams.</label></a>";
					} else {
						echo "<label id='infoLabel' class='infoLabel'>No favorite teams.</label>";
						echo "<script>document.getElementById('infoLabel').style.cursor = 'default';</script>";
					} ?>
				</div>
			<?php endif; ?>
			<div id="FavInfo">
				<?php if(isset($teams[0])) : ?>
					<a href="<?php echo $teams[0]->getTeamUrl(); ?>" target="_blank"><img src="<?php echo $teams[0]->getTeamLogo(); ?>" /></a>
				<?php endif; ?>
				<?php if(isset($teams[1])) : ?>
					<a href="<?php echo $teams[1]->getTeamUrl(); ?>" target="_blank"><img src="<?php echo $teams[1]->getTeamLogo(); ?>" /></a>
				<?php endif; ?>
				<?php if(isset($teams[2])) : ?>
					<a href="<?php echo $teams[2]->getTeamUrl(); ?>" target="_blank"><img src="<?php echo $teams[2]->getTeamLogo(); ?>" /></a>
				<?php endif; ?>
				<?php if(isset($teams[3])) : ?>
					<a href="<?php echo $teams[3]->getTeamUrl(); ?>" target="_blank"><img src="<?php echo $teams[3]->getTeamLogo(); ?>" /></a>
				<?php endif; ?>
			</div>
			<div id="MatchTitle">
				<label class="matchTitle">Current Matches</label>
			</div>
			<div id="MatchInfo">
				<?php echo getCurrentMatches($mysqli, $_GET['id']); ?>
			</div>
			<div id="StatsTitle">
				<label class="statsTitle">Match Stats</label>
			</div>
			<div id="StatsInfo">
				<label class="infoLabel">Total Matches: 13</label><br/>
				<label class="infoLabel">Overall Wins: 4</label><br/>
				<label class="infoLabel">Pick Accuracy: 80%</label><br/><br/>
				<label class="infoLabel">Top-3 Finishes: 7</label><br/>
				<label class="infoLabel">Top-5 Finishes: 10</label><br/>
				<label class="infoLabel">Top-10 Finishes: 12</label><br/><br/>
				<label class="infoLabel">Average Score: 112</label><br/>
				<label class="infoLabel">Career-High Score: 180</label>
			</div>
		</div>
	</div>
</body>
</html>
