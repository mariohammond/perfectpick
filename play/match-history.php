<?php 
	include_once 'connect/connect-info.php';
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	
	// Load user's info by default
	if (!isset($_GET['id']) || $_GET['id'] == '') {
		if (isset($_COOKIE['user_id'])) {
			header('Location: ./match-history?id=' . $_COOKIE['user_id']);
		}
	}
	
	// Get user info and stats
	$user_info = getUserInfo($connection, $_GET['id']);
	$teams = getFavoriteTeams($connection, $_GET['id']);
	$matchStats = getMatchStats($connection, $_GET['id']);
	$currentMatches = getProfileCurrentMatches($connection, $_GET['id']);
	$prevMatches = getPreviousMatches($connection, $_GET['id']);
?>
<html>
<head>
	<title>Match History | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
</head>
<body>
	<div class="PreviousMatchesWrapper">
    	<?php include 'menu.php'; ?>
    	<?php include 'header.php'; ?>
        <div class="ad top">
        	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle leaderboard"
                 style="display:block"
                 data-ad-client="ca-pub-7176350007636201"
                 data-ad-slot="5622693170"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div class="PreviousMatches Main">
        	<h1 style="text-align:center;"><?php echo $user_info['first_name'] . ' ' . $user_info['last_name']; ?></h1>
        	<div class="cover-container"></div>
            <h1 style="float:left; margin-left:5px;">PREVIOUS MATCHES</h1>
            <label class="mainTitle" style="position:relative; top:4px; margin-left:5px;">
            	<a class="back-profile" href="profile?id=<?php echo $_GET['id']; ?>" data-category="pp-history" data-action="return-button" data-label="profile">Back To Profile</a>
           	</label><hr>
            <table style="margin: 0 auto; padding: 0 5px;">
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
                    <?php else : for ($i = 0; $i < count($prevMatches['match_id']); $i++) : ?>
                    <tr>
                        <td class='previous col1'><a href='match?matchId=<?php echo $prevMatches['match_id'][$i]; ?>'><?php echo $prevMatches['title'][$i]; ?></a></td>
                        <td class='previous col2'><?php echo $prevMatches['sport'][$i]; ?></td>
                        <td class='previous col3'><?php echo $prevMatches['players'][$i]; ?></td>
                        <td class='previous col4'><?php echo $prevMatches['points'][$i]; ?></td>
                        <td class='previous col5'><?php echo $prevMatches['rankings'][$i]; ?></td>
                    </tr>
                    <?php endfor; endif; ?>
                </tbody>
            </table>
        </div>
        <div class="ad">
        	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle leaderboard"
                 style="display:block"
                 data-ad-client="ca-pub-7176350007636201"
                 data-ad-slot="5622693170"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <?php include 'footer.php'; ?>
   	</div>
</body>
