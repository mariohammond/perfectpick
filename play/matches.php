<?php 
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	
	$matches = getMatches($connection, $_COOKIE['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Current Matches | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
    
    <!-- Data Table: Start -->
    <link rel="stylesheet" type="text/css" href="js/data-tables/jquery.dataTables.css">
	<script type="text/javascript" language="javascript" src="js/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript">
	$(document).ready(function() {
		$('#match-list').dataTable( {
			"paging":   false,
			"ordering": false,
			"info":     false,
			"filter":	false
		});
	});
	</script>
    <!-- Data Table: End -->
</head>
<body>
	<div class="main-container">
    	<?php include 'menu.php'; ?>
    	<?php include 'header.php'; ?>
        <div id="page-matches" class="content">
            <div class="cover-container"></div>
            <div class="matches-content">
            	<div id="region-0">
                	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle leaderboard"
                         style="display:block"
                         data-ad-client="ca-pub-7176350007636201"
                         data-ad-slot="8525140377"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            	<div id="region-1">
                	<?php if(isset($_GET['qmatch']) && $_GET['qmatch'] == '2018215') : ?>
                        <label class="editMessage">Successfully quit match.</label>
                    <?php endif; ?>
                    <?php if(isset($_GET['qmatch']) && $_GET['qmatch'] == '6112195') : ?>
                        <label class="editMessage">Unable to quit match. Please try again.</label>
                    <?php endif; ?>
                    <?php if(isset($_GET['jmatch']) && $_GET['jmatch'] == 'duplicate') : ?>
                        <label class="editMessage">Match already joined.</label>
                    <?php endif; ?>
                    <?php if(isset($_GET['jmatch']) && $_GET['jmatch'] == '6112195') : ?>
                        <label class="editMessage">Unable to join match. Please try again.</label>
                    <?php endif; ?>
                    <?php if(isset($_GET['signin']) && $_GET['signin'] == '6112195') : ?>
                        <label class="editMessage">Please sign in to join match.</label>
                    <?php endif; ?>
                </div>
                <div id="region-2">
                	<div class="top-bar">
                        <h2 class="left">Current Matches</h2>
                        <h3 class="right">Available Matches: <?php echo count($matches); ?></h3>
                    </div>
                    <div id="allMatches" class="matches-list right">
                        <table id="match-list" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Sport</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>Start Time (EST)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i = 0; $i < count($matches); $i++): ?>
                                <tr>
                                    <td style="font-weight:700"><?php echo '<a class="track" href="match?matchId=' . $matches[$i]['match_id'] . '" data-category="pp-matches" data-action="match-list" data-label="title">' . $matches[$i]['title'] . '</a>'; ?></td>
                                    <td><?php echo $matches[$i]['sport']; ?></td>
                                    <td><?php echo $matches[$i]['category']; ?></td>
                                    <td><?php echo $matches[$i]['date']; ?></td>
                                    <td>
                                        <span class="match-time"><?php echo $matches[$i]['time']; ?></span>
                                        <?php if ($matches[$i]['joined']) : ?>
                                        <a class="track" onClick="quitMatch(<?php echo $matches[$i]['match_id']; ?>)" data-category="pp-matches" data-action="match-list" data-label="quit"><div class="view-match quit-match right">Quit</div></a>
                                        <?php else : ?>
                                        <a class="track" onClick="joinMatch(<?php echo $matches[$i]['match_id']; ?>)" data-category="pp-matches" data-action="match-list" data-label="join"><div class="view-match right">Join</div></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                        <?php if (count($matches) == 0) : ?>
                        <div class="match-list-mobile left" style="display:none; width: 100%;">
                            <p>No current matches available.</p>
                        </div>
                        <?php endif; ?>
                        <?php for($i = 0; $i < count($matches); $i++): ?>
                        <div class="match-list-mobile left" style="display:none;">
                            <p class="match-title" style="font-weight:700"><?php echo '<a class="track" href="match?matchId=' . $matches[$i]['match_id'] . '" data-category="pp-matches" data-action="match-list" data-label="title">' . $matches[$i]['title'] . '</a>'; ?></p>
                            <p class="match-type"><?php echo $matches[$i]['sport']; ?> - <?php echo $matches[$i]['category']; ?></p>
                            <p class="match-date"><?php echo $matches[$i]['date']; ?> - <?php echo $matches[$i]['time']; ?></p>
                        </div>
                        <div id="match-list" class="match-view-mobile right" style="display:none;">
                            <?php if ($matches[$i]['joined']) : ?>
                            <a class="track" onClick="quitMatch(<?php echo $matches[$i]['match_id']; ?>)" data-category="pp-matches" data-action="match-list" data-label="quit"><div class="view-match quit-match right">Quit</div></a>
                            <?php else : ?>
                            <a class="track" onClick="joinMatch(<?php echo $matches[$i]['match_id']; ?>)" data-category="pp-matches" data-action="match-list" data-label="join"><div class="view-match right">Join</div></a>
                            <?php endif; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <div class="matches-sidebar left">
                        <div class="match-filter">
                            <p class="sports-header">Sports</p>
                            <a class="sports-filter nfl track" data-category="pp-matches" data-action="category-filter" data-label="nfl"><p class="sports-category left">NFL</p></a>
                            <a class="sports-filter nba track" data-category="pp-matches" data-action="category-filter" data-label="nba"><p class="sports-category right">NBA</p></a>
                            <a class="sports-filter mlb track" data-category="pp-matches" data-action="category-filter" data-label="mlb"><p class="sports-category left">MLB</p></a>
                            <a class="sports-filter nhl track" data-category="pp-matches" data-action="category-filter" data-label="nhl"><p class="sports-category right">NHL</p></a>
                            <a class="sports-filter ncaaf track" data-category="pp-matches" data-action="category-filter" data-label="ncaaf"><p class="sports-category left">NCAAF</p></a>
                            <a class="sports-filter ncaab track" data-category="pp-matches" data-action="category-filter" data-label="ncaab"><p class="sports-category right">NCAAB</p></a>
                        </div>
                        <div class="match-filter">
                            <p class="sports-header">Match Type</p>
                            <a class="type-filter game track" data-category="pp-matches" data-action="category-filter" data-label="game"><p class="type-category">Game</p></a>
                            <a class="type-filter series track" data-category="pp-matches" data-action="category-filter" data-label="series"><p class="type-category">Series</p></a>
                            <a class="type-filter season track" data-category="pp-matches" data-action="category-filter" data-label="season"><p class="type-category">Season</p></a>
                        </div>
                        <div class="clear-filter">
                            <a class="clear-filter track" data-category="pp-matches" data-action="category-filter" data-label="clear"><p class="sports-header clear">Clear Filter</p></a>
                        </div>
                        <div class="ad-block">
                        	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <ins class="adsbygoogle"
                                 style="display:inline-block;width:180px;height:150px;margin:0 auto;"
                                 data-ad-client="ca-pub-7176350007636201"
                                 data-ad-slot="4374142373"></ins>
                            <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-ad left">
            	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle leaderboard"
                     style="display:block"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="8804341977"></ins>
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
