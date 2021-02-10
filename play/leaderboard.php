<?php 
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	
	$userId = $_COOKIE['user_id'];
	$allMatchPoints = getRanking($connection, 'All-Time');
?>
<html>
<head>
	<title>Leaderboard | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
</head>
<body>
	<div class="main-container">
    	<?php include 'menu.php'; ?>
    	<?php include 'header.php'; ?>
        <div id="page-leaderboard" class="content">
            <div class="cover-container"></div>
            <div class="leaderboard-content left">
                <div id="region-1">
                	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle leaderboard"
                         style="display:block"
                         data-ad-client="ca-pub-7176350007636201"
                         data-ad-slot="2713462374"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <div id="region-2">
                	 <h1>Pick'em Leaderboard</h1>
                </div>
                <div id="region-3">
                	<div class="time-frame left">
                    	<a class="alltime" data-category="pp-leaderboard" data-action="time-filter" data-label="all-time"><h1>All-Time</h1></a>
                    </div>
                    <div class="time-frame left">
                        <a class="year" data-category="pp-leaderboard" data-action="time-filter" data-label="year"><h1>Year</h1></a>
                    </div>
                    <div class="time-frame left">
                        <a class="month" data-category="pp-leaderboard" data-action="time-filter" data-label="month"><h1>Month</h1></a>
                    </div>
                </div>
                <div id="region-4">
                	<table>
                        <thead>
                            <tr>
                                <td>Rank</td>
                                <td>Name</td>
                                <td>Points</td>
                                <td class="tooltip-cell" onClick="showTip()"><a class="tooltip" data-category="pp-leaderboard" data-action="standings" data-label="tooltip">TB Score<img src="images/tooltip.png"/></a></td>
                            </tr>
                        </thead>
                        <tbody id="leaderboard-content">
                            <?php for ($i = 0; $i < count($allMatchPoints['id']); $i++) : ?>
                            <tr <?php if($userId == $allMatchPoints['id'][$i]) { echo "style='color: #fff; background-color: #fc4349'"; } ?>>
                                <td><?php echo $i + 1; ?></td>
                                <td><a href="/profile?id=<?php echo $allMatchPoints['id'][$i]; ?>" data-category="pp-leaderboard" data-action="standings" data-label="player-profile"><?php echo $allMatchPoints['first_name'][$i] . ' ' . $allMatchPoints['last_name'][$i]; ?></a></td>
                                <td><?php echo floor($allMatchPoints['points'][$i]); ?></td>
                                <td><?php echo number_format(fmod($allMatchPoints['points'][$i], 1), 3); ?></td>
                            </tr>
                            <?php endfor; ?>
                            <?php if (count($allMatchPoints['id']) == 0) : ?>
                            <tr>
                                <td colspan="4">No current matches completed.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="leaderboard-sidebar right">
            	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:600px"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="6724859574"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <!-- Widget: Newsletter Signup -->
                <div id="newsletter-widget" class="widget">
                    <div class="newsletter-title">
                        <h2>Pick'em Newsletter!</h2>
                    </div>
                    <div class="newsletter-form">
                        <img class="right" src="/images/achievements/perfect-picker.png"/>
                        <p id="newsletter-body">Enter your email address to receive the latest news and upcoming matches.</p>
                        <input type="email" name="email" class="newsletter-email" />
                        <a data-category="pp-widget" data-action="newsletter-widget" data-label="submit"><input type="button" value="SUBMIT" class="newsletter-submit" /></a>
                    </div>
                </div>
                <!-- Widget: End -->
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="5108525570"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <div class="footer-ad left">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle leaderboard"
                     style="display:block;"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="5387727178"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
           	</div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
    <script>
	$(".time-frame a").click(function(e) {
		$(".time-frame a h1").css("background-color", "#fff");
		$(".time-frame a h1").css("color", "#2c3e50");
		
    	$(this).find("h1").css("background-color", "#fc4349");
		$(this).find("h1").css("color", "#fff");
    });
	
	function showTip() {
		alert("Tiebreaker Score - The average of each player's tiebreaker points.");	
	}
	</script>
    <span class="wideCheck"></span><span class="desktopCheck"></span><span class="tabletCheck"></span><span class="mobileCheck"></span>
</body>
