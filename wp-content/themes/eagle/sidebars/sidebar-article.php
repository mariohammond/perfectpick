<?php ?>
<!-- Ad: 300x600 -->
<div class="widget ad">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
         style="display:inline-block;width:300px;height:600px;background-color:#ccc;"
         data-ad-client="ca-pub-7176350007636201"
         data-ad-slot="9138222770"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<!-- Widget: Upcoming Matches -->
<div id="matches-widget" class="widget left">
    <h1 class="matches-title">Upcoming Matches</h1>
    <hr>
    <div class="match-list">
        <ul>
            <?php for($i = 0; $i < count($upcomingMatches); $i++) : ?>
            <li>
                <h2><?php echo $upcomingMatches["title"][$i]; ?><h2>
                <p>Deadline: <?php echo $upcomingMatches["deadline"][$i]; ?></p>
            </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
<!-- Ad: 300x250 -->
<div class="widget ad">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
         style="display:inline-block;width:300px;height:250px;background-color:#ccc;"
         data-ad-client="ca-pub-7176350007636201"
         data-ad-slot="4568422379"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<!-- Widget: Newsletter Signup -->
<div id="newsletter-widget" class="widget">
    <div class="newsletter-title">
        <h2>Pick'em Newsletter!</h2>
    </div>
    <div class="newsletter-form">
        <img class="right" src="<?php bloginfo('template_directory'); ?>/images/perfect-picker.png"/>
        <p id="newsletter-body">Enter your email address to receive the latest news and upcoming matches.</p>
        <input type="email" name="email" class="newsletter-email" />
        <a data-category="pp-widget" data-action="newsletter-widget" data-label="submit"><input type="button" value="SUBMIT" class="newsletter-submit" /></a>
    </div>
</div>
<!-- Widget: Poll
<div id="poll-widget" class="widget">
    <div style="max-width: 300px;">
        <a data-width="100%" data-height="auto" id="ld-4141-6371" href="http://lockerdome.com/7790982896828225/7790985681846040">Who will the Minnesota Timberwolves select with the #1 pick in the 2015 NBA Draft?</a><span id="ld-4141-6371-equiv"> in <a href="http://lockerdome.com/7790982896828225">Perfect Pick&#x27;em!</a> on <a href="http://lockerdome.com">LockerDome</a></span><script>(function(d,s,id,elid) {window.ldInit = window.ldInit || []; ldInit.push(elid);if (d.getElementById(id)) return;var js, fjs = d.getElementsByTagName(s)[0];js=d.createElement(s); js.id=id;js.async=true;js.src="//cdn2.lockerdome.com/_js/embed.js";fjs.parentNode.insertBefore(js,fjs);}(document, "script", "lockerdome-wjs", "ld-4141-6371"));</script>
    </div>
</div> -->

<!-- Widget: Leaderboard -->
<div id="leaderboard-widget" class="widget">
    <h1 class="leaderboard-title">Pick'em Leaderboard</h1>
    <ul class="tabs-menu">
        <li class="current"><a data-category="pp-widget" data-action="leaderboard-widget" data-label="all-time-tab" href="#all-time">All-Time</a></li>
        <li><a data-category="pp-widget" data-action="leaderboard-widget" data-label="year-tab" href="#year">Year</a></li>
        <li><a data-category="pp-widget" data-action="leaderboard-widget" data-label="month-tab" href="#month">Month</a></li>
    </ul>
    <div class="tab">
        <div id="all-time" class="tab-content">
            <ol>
            <?php if ($allTimeLeaders['id'][0] == NULL) : echo "<p>No current matches available.</p>";
            else: for ($i = 0; $i < 10; $i++) : ?>
                <li><a href="http://play.perfectpickem.com/profile?id=<?php echo $allTimeLeaders['id'][$i]; ?>" data-category="pp-widget" data-action="leaderboard-widget" data-label="profile-name"><?php echo $allTimeLeaders['first_name'][$i] . " " . $allTimeLeaders['last_name'][$i]; ?></a></li>
            <?php endfor; endif; ?>
            </ol>
        </div>
        <div id="year" class="tab-content">
            <ol>
            <?php if ($yearLeaders['id'][0] == NULL) : echo "<p>No current matches available.</p>";
            else: for ($i = 0; $i < 10; $i++) : ?>
                <li><a href="http://play.perfectpickem.com/profile?id=<?php echo $yearLeaders['id'][$i]; ?>" data-category="pp-widget" data-action="leaderboard-widget" data-label="profile-name"><?php echo $yearLeaders['first_name'][$i] . " " . $yearLeaders['last_name'][$i]; ?></a></li>
            <?php endfor; endif; ?>
            </ol>
        </div>
        <div id="month" class="tab-content">
            <ol>
            <?php if ($monthLeaders['id'][0] == NULL) : echo "<p>No current matches available.</p>";
            else: for ($i = 0; $i < 10; $i++) : ?>
                <li><a href="http://play.perfectpickem.com/profile?id=<?php echo $monthLeaders['id'][$i]; ?>" data-category="pp-widget" data-action="leaderboard-widget" data-label="profile-name"><?php echo $monthLeaders['first_name'][$i] . " " . $monthLeaders['last_name'][$i]; ?></a></li>
            <?php endfor; endif; ?>
            </ol>
        </div>
    </div>
</div>
