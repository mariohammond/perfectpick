<?php
	include_once 'connect/connect-info.php';
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	
	$userId = $_GET['id'];
	
	// Load user's info by default
	if (!isset($userId) || $userId == '') {
		if (isset($_COOKIE['user_id'])) {
			header('Location: ./profile?id=' . $_COOKIE['user_id']);
		}
	}
	
	// Get user info and stats
	$user_info = getUserInfo($connection, $userId);
	$teams = getFavoriteTeams($connection, $userId);
	$matchStats = getMatchStats($connection, $userId);
	$currentMatches = getProfileCurrentMatches($connection, $userId);
	$prevMatches = getPreviousMatches($connection, $userId);
	$acvCount = getAchievementCount($connection, $userId);
	
	// Get world ranking
	$allMatchPoints = getRanking($connection, $userId, 'all-time');
	
	for ($i = 0; $i < count($allMatchPoints['id']); $i++) {
		$j = $i + 1;
		
		if ($userId == $allMatchPoints['id'][$i]) {
			$ranking = $j;
		}
	}
	
	if (isset($ranking) && $ranking != '') {
		$ranking = '#' . $ranking;
	} else {
		$ranking = 'N/A';
	}
?>
<html>
<head>
	<title>Pick'em Profile | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
</head>
<body>
	<div class="main-container">
    	<?php include 'menu.php'; ?>
    	<?php include 'header.php'; ?>
        <div id="page-profile" class="content">
            <div class="cover-container"></div>
            <div class="profile-content left">
                <div id="region-1">
                    <?php if (isset($_COOKIE['user_id']) && $_COOKIE['user_id'] == $userId) : ?>
                    <span class="flex right">
                        <a class="tweet-profile" data-category="pp-profile" data-action="profile-link" data-label="tweet-profile"><img src="images/tw_link.png"/></a>
                        <a class="edit-icon" href="/edit-profile" data-category="pp-profile" data-action="profile-link" data-label="edit-profile"><img src="images/edit-profile.png" title="Edit Profile"/></a>
                    </span>
                    <script>
                    $(".tweet-profile").click(function() {
                        <?php $short_url = shortenURL("http://play.perfectpickem.com/profile?userId=$userId"); ?>
                        window.open("http://twitter.com/share?text=Check out all my player stats and achievements at @PerfectPickem!&url=<?php echo trim($short_url); ?>", "Twitter", "width=640, height=253");
                    });
                    </script>
                    <?php endif; ?>
                    <h1 class="profile-name mobile">
                        <?php echo $user_info['first_name'] . ' ' . $user_info['last_name']; ?>
                    </h1>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <?php if (isset($user_info)) : ?>
                            <td><img class="profile-image" src="<?php echo $user_info['image']; ?>"/></td>
                            <?php else : ?>
                            <td><img class="profile-image" src="images/logo.png"/></td>
                            <?php endif; ?>
                            <td>
                                <?php if (isset($user_info)) : ?>
                                <table>
                                    <tr><td>
                                        <h1 class="profile-name">
                                            <?php echo $user_info['first_name'] . ' ' . $user_info['last_name']; ?>
                                        </h1>
                                    </td></tr>
                                    <tr><td><a data-category="pp-profile" data-action="profile-link" data-label="leaderboard" href="/leaderboard"><p class="main-info">World Ranking: <?php echo $ranking; ?></p></a></td></tr>
                                    <tr><td><p class="main-info">Skill Level: <?php echo $user_info['skill_level']; ?></p></td></tr>
                                    <tr><td><p class="main-info">Achievements: <?php echo $acvCount; ?></p></td></tr>
                                </table>
                                <?php else : ?>
                                <h1>Sign In To View Profile</h1>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="region-2">
                    <a href="/achievements?userId=<?php echo $_GET['id']; ?>"><p>VIEW ALL ACHIEVEMENTS</p></a>
                </div>
                <div id="region-3">
                    <h1>CURRENT MATCHES</h1><hr>
                    <table style="margin: 0 auto;">
                        <thead>
                            <tr>
                                <td class="current col1">NAME</td>
                                <td class="current col2">SPORT</td>
                                <td class="current col3">PLAYERS</td>
                                <td class="current col4">MAX POINTS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($currentMatches['match_id']) == 0) : ?>
                            <tr>
                                <?php if (isset($userId) && $userId == $_COOKIE['user_id']) : ?>
                                <td colspan="4"><a href="matches" data-category="pp-profile" data-action="profile-link" data-label="find-match">No current matches. Join one now!</a></td>
                                <?php else : ?>
                                <td colspan="4">No current matches joined.</td>
                                <?php endif; ?>
                            </tr>
                            <?php else : for ($i = 0; $i < count($currentMatches['match_id']); $i++) : ?>
                            <tr>
                                <td class='current col1'><a href="match?matchId=<?php echo $currentMatches['match_id'][$i]; ?>" data-category="pp-profile" data-action="profile-link" data-label="current-match"><?php echo $currentMatches['title'][$i]; ?></a></td>
                                <td class='current col2'><?php echo $currentMatches['sport'][$i]; ?></td>
                                <td class='current col3'><?php echo $currentMatches['players'][$i]; ?></td>
                                <td class='current col4'><?php echo $currentMatches['max_points'][$i]; ?></td>
                            </tr>
                            <?php endfor; endif; ?>
                        </tbody>
                    </table>
                </div>
                <div id="region-4">
                    <div class="match-tabs left">
                        <p>Total Matches</p>
                        <h1><?php echo number_format($matchStats['totalMatches']); ?></h1>
                    </div>
                    <div class="match-tabs right">
                        <p>Total Points</p>
                        <h1><?php echo number_format($matchStats['totalPoints']); ?></h1>
                    </div>
                    <div class="match-tabs left">
                        <p>Avg Match Score</p>
                        <h1><?php echo number_format($matchStats['avgScore']); ?></h1>
                    </div>
                    <div class="match-tabs right">
                        <p>High Match Score</p>
                        <h1><?php echo number_format($matchStats['highScore']); ?></h1>
                    </div>
                    <div class="match-tabs left">
                        <p>Total Wins</p>
                        <h1><?php echo number_format($matchStats['wins']); ?></h1>
                    </div>
                    <div class="match-tabs right">
                        <p>Top 3 Finishes</p>
                        <h1><?php echo number_format($matchStats['topThree']); ?></h1>
                    </div>
                    <div class="match-tabs left">
                        <p>Top 5 Finishes</p>
                        <h1><?php echo number_format($matchStats['topFive']); ?></h1>
                    </div>
                    <div class="match-tabs right">
                        <p>Top 10 Finishes</p>
                        <h1><?php echo number_format($matchStats['topTen']); ?></h1>
                    </div>
                </div>
                <div id="region-5">
                    <h1>Pick Accuracy</h1>
                    <div class="pick-accuracy" data-percent="<?php getPickAccuracy($connection, $userId); ?>"></div>
                    <script>$('.pick-accuracy').diagram();</script>
                </div>
                <div id="region-6">
                    <h1>PREVIOUS MATCHES</h1><hr>
                    <table style="margin: 0 auto;">
                        <thead>
                            <tr>
                                <td class="previous col1">NAME</td>
                                <td class="previous col2">SPORT</td>
                                <td class="previous col3">PLAYERS</td>
                                <td class="previous col4">POINTS</td>
                                <td class="previous col5">RANK</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($prevMatches['match_id']) == 0) : ?>
                            <tr>
                                <td colspan="5">No previous matches.</td>
                            </tr>
                            <?php else : for ($i = 0; $i < 3; $i++) : ?>
                            <?php if ($prevMatches['match_id'][$i] != "") : ?>
                            <tr>
                                <td class='previous col1'><a href="match?matchId=<?php echo $prevMatches['match_id'][$i]; ?>" data-category="pp-profile" data-action="profile-link" data-label="prev-matches"><?php echo $prevMatches['title'][$i]; ?></a></td>
                                <td class='previous col2'><?php echo $prevMatches['sport'][$i]; ?></td>
                                <td class='previous col3'><?php echo $prevMatches['players'][$i]; ?></td>
                                <td class='previous col4'><?php echo $prevMatches['points'][$i]; ?></td>
                                <td class='previous col5'><?php echo $prevMatches['rankings'][$i]; ?></td>
                            </tr>
                            <?php endif; endfor; endif; ?>
                            <?php if (count($prevMatches['match_id']) > 3) : ?>
                            <tr>
                                <td><a href="/match-history" data-category="pp-profile" data-action="profile-button" data-label="view-prev"><p class="view-previous">View All Matches &#62;&#62;</p></a></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="profile-sidebar right">
                <div class="fav-teams">
                	<h1>Favorite Teams</h1>
                    <?php if(isset($teams[0])) : ?>
                        <a href="<?php echo $teams[0]->getTeamUrl(); ?>" target="_blank" data-category="pp-profile" data-action="profile-link" data-label="fav-team"><img src="<?php echo $teams[0]->getTeamLogo(); ?>" /></a>
                    <?php else: ?>
                        <?php if (isset($userId) && $userId == $_COOKIE['user_id']) : ?>
                            <a href="edit-profile#fav-teams" data-category="pp-profile" data-action="profile-link" data-label="add-fav-team"><h3>No favorite teams. Add one now!</h3></a>
                        <?php else: ?>
                            <h3>No favorite teams selected.</h3>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(isset($teams[1])) : ?>
                        <a href="<?php echo $teams[1]->getTeamUrl(); ?>" target="_blank" data-category="pp-profile" data-action="profile-link" data-label="fav-team"><img src="<?php echo $teams[1]->getTeamLogo(); ?>" /></a>
                    <?php endif; ?>
                    <?php if(isset($teams[2])) : ?>
                        <a href="<?php echo $teams[2]->getTeamUrl(); ?>" target="_blank" data-category="pp-profile" data-action="profile-link" data-label="fav-team"><img src="<?php echo $teams[2]->getTeamLogo(); ?>" /></a>
                    <?php endif; ?>
                    <?php if(isset($teams[3])) : ?>
                        <a href="<?php echo $teams[3]->getTeamUrl(); ?>" target="_blank" data-category="pp-profile" data-action="profile-link" data-label="fav-team"><img src="<?php echo $teams[3]->getTeamLogo(); ?>" /></a>
                    <?php endif; ?>
                </div>
                <div class="ad">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle"
                         style="display:inline-block;width:300px;height:600px"
                         data-ad-client="ca-pub-7176350007636201"
                         data-ad-slot="4285560775"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
            <div class="footer-ad left">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle leaderboard"
                     style="display:block"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="5762293979"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
           	</div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
    <span class="wideCheck"></span><span class="desktopCheck"></span><span class="tabletCheck"></span><span class="mobileCheck"></span>
</body>
</html>
