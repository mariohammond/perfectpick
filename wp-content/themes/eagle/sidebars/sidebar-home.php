<?php ?>
<!-- Ad: 300x600 -->
<div class="widget ad">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
         style="display:inline-block;width:300px;height:600px;background-color:#ccc;"
         data-ad-client="ca-pub-7176350007636201"
         data-ad-slot="5406027175"></ins>
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
         data-ad-slot="6882760372"></ins>
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
<!-- Widget: Twitter Feed -->
<div id="twitter-widget" class="widget right">
    <a class="twitter-timeline" href="https://twitter.com/PerfectPickem" data-widget-id="552664041249046529" data-category="pp-home" data-action="widget" data-label="twitter">Tweets by @PerfectPickem</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
