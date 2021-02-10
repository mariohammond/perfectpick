<div class="HeaderContainer article-share">
	<ul class="header-content">
    	<li class="menu-button left">
            <a data-category="pp-header" data-action="article-share" data-label="menu"><img class="menu" src="<?php echo $directory; ?>/images/menu-blue.png"/></a>
    	</li>
        <li><h2 class="left">Share</h2></li>
        <div class="addthis-share">
            <div id="social-share" class="addthis_toolbox addthis_default_style" addthis:url="<?php the_permalink(); ?>" addthis:title="<?php echo get_field('teaser_title'); ?>">
                <a class="social-icon facebook-share addthis_button_facebook" data-category="pp-header" data-action="share" data-label="facebook"><span class="fa fa-facebook"></span></a>
                <a class="social-icon twitter addthis_button_twitter" data-category="pp-header" data-action="share" data-label="twitter"><span class="fa fa-twitter"></span></a>
                <a class="social-icon google addthis_button_google_plusone_share" data-category="pp-header" data-action="share" data-label="google"><span class="fa fa-google-plus"></span></a>
                <a class="social-icon tumblr addthis_button_tumblr" data-category="pp-header" data-action="share" data-label="tumblr"><span class="fa fa-tumblr"></span></a>
                <a class="social-icon email addthis_button_email" data-category="pp-header" data-action="share" data-label="email"><span class="fa fa-envelope"></span></a>
                <a class="social-icon sms addthis_button_sms" data-category="pp-header" data-action="share" data-label="sms"><span class="fa fa-comment-o"></span></a>
            </div>
            <div class="clear"></div>
        </div>
        <li><a href="http://play.perfectpickem.com/matches" data-category="pp-header" data-action="play" data-label="next-match"><h2 class="next-match right">Next Match: <?php echo $nextMatch; ?></h2></a></li>
    </ul>
</div>
