<?php 
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';
	
	$userId = $_GET['userId'];
	
	// Load user's info by default
	if (!isset($userId) || $userId == '') {
		$userId = $_COOKIE['user_id'];
	}
	
	$user_info = getUserInfo($connection, $userId);
	$earnedAchievements = getEarnedAchievements($connection, $userId);
	$unearnedAchievements = getUnearnedAchievements($connection, $userId);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Achievements | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
    <meta property="og:title" content="Achievement Earned! | Perfect Pick'em" />
    <meta property="og:site_name" content="Perfect Pick'em"/>
    <meta property="og:url" content="http://play.perfectpickem.com/achievements" />
    <meta property="og:description" content="Check out my latest Pick'em achievement on Perfect Pick'em!" />
    <meta property="fb:app_id" content="688615697852514" />
    <meta property="og:image" content="http://play.perfectpickem.com/images/bg-trophy.jpg" />
</head>
<body>
	<?php if($_COOKIE['user_id'] == $userId) : ?>
	<script>
	$(function() {
		$("#achievement-message").dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				/*Share: function() {
					window.open("https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fplay.perfectpickem.com%2Fachievements?userId=<?php //echo $userId; ?>", "Facebook", "width=640, height=332");
					$(this).dialog("close");
				},*/
				Tweet: function() {
					<?php $short_url = shortenURL("http://play.perfectpickem.com/achievements?userId=$userId"); ?>
					$title = $("#achievement-message").data("title");
					window.open("http://twitter.com/share?text=Achievement Earned - " + $title + " at @PerfectPickem. Check it out!&url=<?php echo trim($short_url); ?>", "Twitter", "width=640, height=253");
					$(this).dialog("close");
				},
				Close: function() {
					$(this).dialog("close");
				}
			}
		});
		
		$(".achievement-badge").click(function(e) {
			$acvImage = $(this).find("img").attr("src");
			$acvTitle = $(this).find("h1").text();
		
			$("#achievement-message .acv-image").attr("src", $acvImage);
			$("#achievement-message .acv-title h1").text($acvTitle);
			
			e.preventDefault();
			$("#achievement-message").data('title', $acvTitle).dialog("open");
		});
	});
	</script>
    <div id="achievement-message" title="Achievement Earned" style="display:none;">
        <span class="left"><img class="acv-image" src=""></span>
        <div class="acv-title">
            <h1>Perfect Pick'em</h1>
            <p>Share your achievement with friends!</p>
        </div>
    </div>
    <script>
	$(function() {
		$("#unearned-message").dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				Close: function() {
					$(this).dialog("close");
				}
			}
		});
		
		$(".unearned-badge").click(function(e) {
			$acvImage = $(this).find("img").attr("src");
			$acvTitle = $(this).find("figcaption").text();
			$acvDesc = $(this).find("p").text();
		
			$("#unearned-message .acv-image").attr("src", $acvImage);
			$("#unearned-message .acv-title h1").text($acvTitle);
			$("#unearned-message .acv-title p").text($acvDesc);
			
			e.preventDefault();
			$("#unearned-message").dialog("open");
		});
	});
	</script>
    <div id="unearned-message" title="Unearned Achievement" style="display:none;">
        <span class="left"><img class="acv-image" src=""></span>
        <div class="acv-title">
            <h1>Perfect Pick'em</h1>
            <p>Share your achievement with friends!</p>
        </div>
    </div>
    <?php endif; ?>
    
	<div class="main-container">
    	<?php include 'menu.php'; ?>
    	<?php include 'header.php'; ?>
        <div id="page-achievements" class="content">
            <div class="cover-container"></div>
            <div class="achievements-content left">
                <div id="region-1">
                	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle leaderboard"
                         style="display:block"
                         data-ad-client="ca-pub-7176350007636201"
                         data-ad-slot="8053488778"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
    			</div>
                <div id="region-2">
                	<h1>
						<?php if ($user_info != NULL) : echo $user_info['first_name'] . "'s Achievements"; ?>
                        <span><a data-category="pp-achievements" data-action="return-button" data-label="profile" href="/profile?id=<?php echo $userId; ?>">View Profile</a></span>
                        <?php endif; ?>
                    </h1>
    			</div>
                <div id="region-3">
                	<h1 class="earned-title left">Earned Achievements&nbsp;</h1><hr class="earned-hr left">
                    <div class="clear"></div>
                    
                    <div class="earned-achievements">
                        <?php if ($user_info != NULL) : ?>
                        <a class="achievement-badge" data-category="pp-achievements" data-action="achievement" data-label="image"><img class="left" src="images/achievements/skill-level-1.png"/>
                        <h1 class="earned">Skill Level: Rookie</h1></a>
                        <p class="earned">The start of something special. Here's your first of many achievements.</p>
                        <div class="clear"></div>
                        <?php else: ?>
                        <h1 class="earned">Please sign in to view achievements.</h1>
                        <?php endif; ?>
                        
                        <?php for($i = 0; $i < count($earnedAchievements["id"]); $i++) : ?>
                        <a class="achievement-badge" data-category="pp-achievements" data-action="achievement" data-label="earned"><img class="lazy-load left" data-original="<?php echo $earnedAchievements["image"][$i]; ?>"/>
                        <h1 class="earned"><?php echo $earnedAchievements["title"][$i]; ?></h1></a>
                        <p class="earned"><?php echo $earnedAchievements["caption"][$i]; ?></p>
                        <div class="clear"></div>
                        <?php endfor; ?>
                    </div>
                    
                    <h1 class="unearned-title left">Unearned Achievements&nbsp;</h1><hr class="unearned-hr">
                    <div class="clear"></div>
                    
                    <div class="unearned-achievements flex">
                        <?php for($i = 0; $i < count($unearnedAchievements["id"]); $i++) : ?>
                            <figure>
                            <a class="unearned-badge" data-category="pp-achievements" data-action="achievement" data-label="unearned"><img class="lazy-load" data-original="<?php echo $unearnedAchievements["image"][$i]; ?>">
                            <figcaption><?php echo $unearnedAchievements["title"][$i]; ?></figcaption>
                            <p style="display:none;"><?php echo $unearnedAchievements["caption"][$i]; ?></p></a>
                            </figure>
                        <?php endfor; ?>
                    </div>
    			</div>
            </div>
            <div class="achievements-sidebar right">
            	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:600px"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="7634686375"></ins>
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
                     data-ad-slot="9111419574"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
            <div class="footer-ad left">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle leaderboard"
                     style="display:block"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="6157953177"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
           	</div>
        </div>
        <?php include 'footer.php'; ?>
        <script>
		$(document).ready(function(e) {
			$(function() {
    			$("img.lazy-load").lazyload({
    				effect: "fadeIn",
					threshold: 100
				});
			});
			
			<?php if($_COOKIE['user_id'] == $userId) : ?>
			$(".achievement-badge, .unearned-badge").css("cursor", "pointer");
			<?php endif; ?>
			$(".ui-dialog-buttonset .ui-button-text:eq(0)").css("background-color", "#4099ff");
			$(".ui-dialog-buttonset .ui-button-text:eq(0)").css("color", "#fff");
        });
		</script>
    </div>
</body>
