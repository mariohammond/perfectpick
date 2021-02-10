<?php ?>

<div class="LandingPageWrapper">
    <?php include 'menu.php'; ?>
    <div class="MainContainer right">
        <?php include 'header.php'; ?>
        <div class="ContentContainer">
        	<div class="GameBlockContainer">
                <span>
                    <a href="#" class="ad-block-1 right"><img src="<?php bloginfo('template_directory'); ?>/images/728x90.png"/></a>
                </span>
            </div>
            <div class="SidebarLeftContainer left">
                <div id="LeaderboardContainer">
                    <h1>Upcoming Matches</h1>
                    <ul>
                        <li><a href="#game" data-label="game">Game</a></li>
                        <li><a href="#series" data-label="series">Series</a></li>
                        <li><a href="#season" data-label="season">Season</a></li>
                    </ul>
                    <div id="game">
                        <ol>
                            <li>Chiefs vs Chargers</li>
                            <li>Packers vs Bears</li>
                        </ol>
                    </div>
                    <div id="series">
                        <ol>
                            <li>NFL Week 1</li>
                            <li>NFL Week 2</li>
                        </ol>
                    </div>
                    <div id="season">
                        <ol>
                            <li>NFL Division Winners</li>
                            <li>NFL League Leaders</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="StoryContainer left" style="display:none;">
                <div class="category-banner">
                	<h1><?php echo $category; ?></h1>
                </div>
                <?php $args = array('category_name' => $category);
						$my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                        <div class="category-list">
                            <table class="category-list-content"><tr>
                                <td class="category-list-image"><a href="<?php the_permalink(); ?>" data-action="list_story_<?php echo strtolower($category); ?>" data-label="image" data-ajax="false"><?php the_post_thumbnail(); ?></a></td>
                                <td>
                                    <table>
                                        <tr><td class="category-list-text"><a href="<?php the_permalink(); ?>" data-action="list_story_<?php echo $category; ?>" data-label="headline" data-ajax="false"><h2><?php echo get_field('teaser_title'); ?></h2></a></td></tr>
                                        <tr><td class="category-list-summary"><p><?php echo get_field('summary'); ?></p></td></tr>
                                        <!--<tr><td class="category-list-byline"><p>By <?php //the_author(); ?><span class="post-time"><?php //the_time('F j, Y - g:i a'); ?></span></p></td></tr>-->
                                        <tr><td class="category-list-social"><div class="addthis_sharing_toolbox" data-url="<?php the_permalink(); ?>" data-title="<?php echo get_field('teaser_title'); ?>"></td></tr>
                                    </table>
                                </td>
                                </tr>
                            </table>
                        </div>
              	<?php endwhile; wp_reset_query(); ?>
            </div>
            <div class="SidebarRightContainer right">
                <div class="ad-block-3">
                    <a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/300x600.png"/></a>
                </div>
                <div class="newsletter-widget">
                    <a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/newsletter1.png" height="168"/></a>
                </div>
                <div class="ad-block-4">
                    <a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/300x250.png"/></a>
                </div>
            </div>
            <div class="TabletAdContainer right" style="display:none;">
                <span>
                    <a href="#" class="ad-block-tablet-1 right"><img src="<?php bloginfo('template_directory'); ?>/images/728x90.png"/></a>
                </span>
            </div>
        </div>
        	<?php include 'footer.php'; ?>
    	</div>
	</div>
</div>
