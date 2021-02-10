<?php
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	
	session_start();
	
	$matchId = $_GET['matchId'];
	
	$seconds = getMatchDeadline($connection, $matchId);
	$joined = checkMatchJoin($connection, $matchId, $_COOKIE['user_id']);
	$closed = checkMatchClosed($connection, $matchId);
	$match = getMatchInfo($connection, $matchId);
	//$points = getAvailablePoints($connection, $matchId);
	$matchTitle = getMatchTitle($connection, $matchId);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Match Standings | Perfect Pick'em</title>
	<link rel="icon" type="image/png" href="images/favicon.png">
	<?php include 'head-info.php'; ?>
	
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
			var hourTitle = ' Hrs ';
			var minuteTitle = ' Min ';
			var secondTitle = ' Sec';
			
			if(remainingDays == 0) { remainingDays = ''; dayTitle = ''; }
			if(remainingHours == 0) { remainingHours = ''; hourTitle = ''; }
			if(remainingMinutes == 0) { remainingMinutes = ''; minuteTitle = ''; }
			if(remainingSeconds == 0) { remainingSeconds = ''; secondTitle = ''; }
			
			if(remainingDays == 1) { dayTitle = ' Day '; }
			if(remainingHours == 1) { hourTitle = ' Hr '; }
			if(remainingMinutes == 1) { minuteTitle = ' Min '; }
			if(remainingSeconds == 1) { secondTitle = ' Sec'; }
			
			document.getElementById('countdown').innerHTML = "&nbsp;Closes in: " +
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
	
	<!-- View Alert: Start -->
	<script>
	function viewAlert() {
		alert("Opponent picks will be available once match closes.");
	}
	</script>
	<!-- View Alert: End -->
</head>
<body>
	<!-- FB Comments: Start -->
	<div id="fb-root"></div>
	<script>
	(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=688615697852514";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- FB Comments: End -->
    
    <div class="main-container">
    	<?php include 'menu.php'; ?>
    	<?php include 'header.php'; ?>
        <div id="page-match" class="content">
            <div class="cover-container"></div>
            <div class="match-content left">
            	<div id="region-1">
                	<?php if(isset($_GET['picks']) && $_GET['picks'] == '2018215') : ?>
                        <h1>Picks Saved!</h1>
                    <?php endif; ?>
                </div>
                <div id="region-2">
                	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle leaderboard"
                         style="display:block"
                         data-ad-client="ca-pub-7176350007636201"
                         data-ad-slot="2439750779"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <div id="region-3">
                	<h1 class="mainTitle"><?php echo $matchTitle; ?></h1>
                </div>
                <div id="region-4">
                	<div id="countdown"></div>
                    <div class="match-menu">
						<?php if($seconds <= 0) : ?>
                        <div class="match-option view-all left">
                            <a href="view-questions?matchId=<?php echo $matchId; ?>" data-category="pp-match" data-action="match-option" data-label="view-all-picks"><h1>View All Picks</h1></a>
                        </div>
                        <?php else : ?>
                            <?php if($joined == false) : ?>
                            <div class="match-option join-match left">
                                <a href="#" onClick="joinMatch(<?php echo $matchId ?>)" data-category="pp-match" data-action="match-option" data-label="join-match"><h1>Join Match</h1></a>
                            </div>
                            <div class="match-option view-questions left">
                                <a href="view-questions?matchId=<?php echo $matchId; ?>" data-category="pp-match" data-action="match-option" data-label="view-questions"><h1>View Questions</h1></a>
                            </div>
                            <?php endif; ?>
                            <?php if($joined == true) : ?>
                            <div class="match-option quit-match left">
                                <a href="#" onClick="quitMatch(<?php echo $matchId ?>)" data-category="pp-match" data-action="match-option" data-label="quit-match"><h1>Quit Match</h1></a>
                            </div>
                            <div class="match-option edit-picks left">
                                <a href="match-picks?matchId=<?php echo $matchId; ?>" data-category="pp-match" data-action="match-option" data-label="edit-picks"><h1>Edit Picks</h1></a>
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div id="region-5">
                	<div class="match-standings left">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan='5' class='title'>
                                        <h1 class="left"><?php if ($closed) { echo 'Final '; } ?>Standings</h1>
                                        <?php if ($joined) : ?><a class="tweet-match" data-category="pp-match" data-action="match-link" data-label="tweet-match"><img src="images/tw_link.png"/></a><?php endif; ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>Score</th>
                                    <th>Picks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Display standings and return rankings by id
                                $idRank = getStandings($connection, $matchId); 
                                
                                // Get rank of user by id
                                $userRank = array_search($_COOKIE['user_id'], $idRank);
                                $userRank += 1;
                                
                                if (substr($userRank, -1) == '1' && $userRank != '11') {
                                    $userRank .= 'st';
                                } else if (substr($userRank, -1) == '2' && $userRank != '12') {
                                    $userRank .= 'nd';
                                } else if (substr($userRank, -1) == '3' && $userRank != '13') {
                                    $userRank .= 'rd';
                                } else {
                                    $userRank .= 'th';
                                }
                                ?>
                            </tbody>
                        </table>
                        <script>
                        <?php if ($seconds > 0) $tweetStatus = "Just signed up for the";
                            else if ($closed) $tweetStatus = "I finished in " . $userRank . " place in the";
                            else $tweetStatus = "I am currently in " . $userRank . " place in the"; ?>
                        $(".tweet-match").click(function() {
                            <?php $short_url = shortenURL("http://play.perfectpickem.com/match?matchId=$matchId"); ?>
                            window.open("http://twitter.com/share?text=<?php echo $tweetStatus . " " . $matchTitle; ?> match at @PerfectPickem. Check it out now!&url=<?php echo trim($short_url); ?>", "Twitter", "width=640, height=253");
                        });
                        </script>
                    </div>
                </div>
                <div id="region-6">
                	<div id="facebook_comments" class="left">
                        <hr>
                        <div class="fb-comments" data-href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" data-width="100%" data-numposts="5"></div>
                    </div>
                </div>
                <div id="region-7" class="left">
                	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle leaderboard"
                         style="display:block"
                         data-ad-client="ca-pub-7176350007636201"
                         data-ad-slot="3916483973"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
            <div class="match-sidebar right">
            	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:600px"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="6869950378"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="3776883172"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <?php if ($closed) : ?>
        <script>
		$(document).ready(function(e) {
            $winner = $("tbody tr:first");
			$winner.find("td").css("font-weight", "700");
        });
		</script>
        <? endif; ?>
    </div>
</body>
</html>
