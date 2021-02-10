<?php ?>

<div class="HomeWrapper">
	<?php include 'menu.php'; ?>
    <div class="MainContainer right">
        <?php include 'header.php'; ?>
        <div class="cover-container"></div>
        <div class="ContentContainer">
            <div class="GameBlockContainer">
                <span>
                    <span class="next-match-text left">NFL Week 1 Predictions</span>
                    <a href="#" class="next-match" data-action="next_match" data-ajax="false"><img src="<?php bloginfo('template_directory'); ?>/images/play-now.png"/></a>
                    <a href="#" class="ad-block-1 right"><img src="<?php bloginfo('template_directory'); ?>/images/728x90.png"/></a>
                </span>
            </div>
            <div class="SidebarLeftContainer left">
                <div id="LeaderboardContainer">
                    <h1>Pick'em Leaderboard</h1>
                    <ul>
                        <li><a href="#week" data-label="week">Week</a></li>
                        <li><a href="#month" data-label="month">Month</a></li>
                        <li><a href="#all-time" data-label="all_time">All-Time</a></li>
                    </ul>
                    <div id="week">
                        <ol>
                            <a href="#" data-label="player" data-ajax="false"><li>Chief Kickingstallions</li></a>
                            <li>Ferdinand D'Agosto</li>
                            <li>Little Big Horn III</li>
                            <li>Rafferty Hornbottom</li>
                            <li>Nia Short</li>
                            <li>Sanay Chatham</li>
                            <li>Demarelle D. Hammond</li>
                            <?php 
                                $i = 0;
                                while($i <= 42) {
                                    echo "<li>Open</li>";
                                    $i++;
                                }
                                ?>
                        </ol>
                    </div>
                    <div id="month">
                        <ol>
                            <li>Little Big Horn III</li>
                            <li>Rafferty Hornbottom</li>
                        </ol>
                    </div>
                    <div id="all-time">
                        <ol>
                            <li>Nia Short</li>
                            <li>Sanay Chatham</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="StoryContainer left" style="display:none;">
                <div class="FeaturedStoryContainer">
                	<?php $my_query = new WP_Query('category_name=Featured&posts_per_page=1');
						while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
                            <div>
                                <a class="featured-image" href="<?php the_permalink(); ?>" data-action="featured_story" data-label="image" data-ajax="false">
                                    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                    <img src="<?php echo jetpack_photon_url($image[0]); ?>">
                                </a>
                            </div>
                            <div class="featured-text left">
                                <a href="<?php the_permalink(); ?>" data-action="featured_story" data-label="headline" data-ajax="false">
                                    <h1 class="featured-title"><?php echo get_field('teaser_title'); ?></h1>
                                </a>
                                <a href="<?php the_permalink(); ?>" data-action="featured_story" data-label="deck" data-ajax="false">
                                    <h1 class="featured-deck"><?php echo get_field('deck'); ?>&nbsp; <span class="read-more">Read>></span></h1>
                                </a>
                            </div>
                    <?php endwhile; wp_reset_query(); ?>
                </div>
                <div class="LeadStoriesContainer">
                	<?php $args = array('category_name' => 'NFL+Lead', 'posts_per_page' => 1, 'post__not_in' => $excludePostIds);
						$my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
                        <div class="lead-story">
                            <table class="lead-story-content"><tr>
                                <td class="lead-story-image"><span>NFL</span><a href="<?php the_permalink(); ?>" data-action="lead_story_nfl" data-label="image" data-ajax="false">
									<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                    <img src="<?php echo jetpack_photon_url($image[0]); ?>">
                                </a></td>
                                <td>
                                    <table>
                                        <tr><td class="lead-story-text"><a href="<?php the_permalink(); ?>" data-action="lead_story_nfl" data-label="headline" data-ajax="false"><h2><?php echo get_field('teaser_title'); ?></h2></a></td></tr>
                                        <tr><td><p>By <?php the_author(); ?></p></td></tr>
                                        <tr><td><div class="addthis_sharing_toolbox" data-url="<?php the_permalink(); ?>" data-title="<?php echo get_field('teaser_title') . ' | @PerfectPickem'; ?>"></div></td></tr>
                                    </table>
                                </td>
                                </tr>
                            </table>
                        </div>
                    <?php endwhile; wp_reset_query(); ?>
                    <?php $args = array('category_name' => 'NBA+Lead', 'posts_per_page' => 1, 'post__not_in' => $excludePostIds);
						$my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
                        <div class="lead-story">
                            <table class="lead-story-content"><tr>
                                <td class="lead-story-image"><span>NBA</span><a href="<?php the_permalink(); ?>" data-action="lead_story_nba" data-label="image" data-ajax="false">
									<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                    <img src="<?php echo jetpack_photon_url($image[0]); ?>">
                                </a></td>
                                <td>
                                    <table>
                                        <tr><td class="lead-story-text"><a href="<?php the_permalink(); ?>" data-action="lead_story_nba" data-label="headline" data-ajax="false"><h2><?php echo get_field('teaser_title'); ?></h2></a></td></tr>
                                        <tr><td><p>By <?php the_author(); ?></p></td></tr>
                                        <tr><td><div class="addthis_sharing_toolbox" data-url="<?php the_permalink(); ?>" data-title="<?php echo get_field('teaser_title'); ?>"></div></td></tr>
                                    </table>
                                </td>
                                </tr>
                            </table>
                        </div>
                    <?php endwhile; wp_reset_query(); ?>
                    <?php $args = array('category_name' => 'MLB+Lead', 'posts_per_page' => 1, 'post__not_in' => $excludePostIds);
						$my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
                        <div class="lead-story">
                            <table class="lead-story-content"><tr>
                                <td class="lead-story-image"><span>MLB</span><a href="<?php the_permalink(); ?>" data-action="lead_story_mlb" data-label="image" data-ajax="false">
									<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                    <img src="<?php echo jetpack_photon_url($image[0]); ?>">
                                </a></td>
                                <td>
                                    <table>
                                        <tr><td class="lead-story-text"><a href="<?php the_permalink(); ?>" data-action="lead_story_mlb" data-label="headline" data-ajax="false"><h2><?php echo get_field('teaser_title'); ?></h2></a></td></tr>
                                        <tr><td><p>By <?php the_author(); ?></p></td></tr>
                                        <tr><td><div class="addthis_sharing_toolbox" data-url="<?php the_permalink(); ?>" data-title="<?php echo get_field('teaser_title'); ?>"></div></td></tr>
                                    </table>
                                </td>
                                </tr>
                            </table>
                        </div>
                    <?php endwhile; wp_reset_query(); ?>
                    <?php $args = array('category_name' => 'NCAA+Lead', 'posts_per_page' => 1, 'post__not_in' => $excludePostIds);
						$my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
                        <div class="lead-story">
                            <table class="lead-story-content"><tr>
                                <td class="lead-story-image"><span>NCAA</span><a href="<?php the_permalink(); ?>" data-action="lead_story_ncaa" data-label="image" data-ajax="false">
									<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                    <img src="<?php echo jetpack_photon_url($image[0]); ?>">
                                </a></td>
                                <td>
                                    <table>
                                        <tr><td class="lead-story-text"><a href="<?php the_permalink(); ?>" data-action="lead_story_ncaa" data-label="headline" data-ajax="false"><h2><?php echo get_field('teaser_title'); ?></h2></a></td></tr>
                                        <tr><td><p>By <?php the_author(); ?></p></td></tr>
                                        <tr><td><div class="addthis_sharing_toolbox" data-url="<?php the_permalink(); ?>" data-title="<?php echo get_field('teaser_title'); ?>"></div></td></tr>
                                    </table>
                                </td>
                                </tr>
                            </table>
                        </div>
                    <?php endwhile; wp_reset_query(); ?>
                </div>
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
            <div class="TabletAdContainer" style="display:none;">
                <span>
                    <a href="#" class="ad-block-tablet-1 right"><img src="<?php bloginfo('template_directory'); ?>/images/728x90.png"/></a>
                </span>
            </div>
            <div class="StoryListContainer left">
            	<div class="youtube-container">
                    <a class="youtube-channel" href="https://www.youtube.com/channel/UCMfDAQXoQMzGa5bwIsClgRg" target="_blank" data-action="youtube_channel">
                        <img src="<?php bloginfo('template_directory'); ?>/images/youtube-channel.png"/>
                    </a>
               	</div>
                <div class="list-content">
                    <div class="story-list left">
                        <div class="sport-list nfl">
                            <h1>NFL</h1>
                            <?php $args = array('category_name' => 'NFL', 'posts_per_page' => 3, 'post__not_in' => $excludePostIds);
                                $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                    <div class="list-content">
                                        <table><tr>
                                            <td><a href="<?php the_permalink(); ?>" data-action="list_story_nfl" data-label="image" data-ajax="false">
												<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                            	<img src="<?php echo jetpack_photon_url($image[0]); ?>"></a></td>
                                            <td><table>
                                                    <tr><td><a href="<?php the_permalink(); ?>" data-action="list_story_nfl" data-label="headline" data-ajax="false">
                                                        <p><?php echo get_field('teaser_title'); ?></p></a>
                                                    </td></tr>
                                                    <tr><td><p>by <?php the_author(); ?></p></td></tr>
                                                </table>
                                            </td>
                                        </tr></table>
                                    </div>
                            <?php endwhile; wp_reset_query(); ?>
                        </div>
                        <div class="sport-list nba">
                            <h1>NBA</h1>
                            <?php $args = array('category_name' => 'NBA', 'posts_per_page' => 3, 'post__not_in' => $excludePostIds);
                                $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                    <div class="list-content">
                                        <table><tr>
                                            <td><a href="<?php the_permalink(); ?>" data-action="list_story_nba" data-label="image" data-ajax="false">
												<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                            	<img src="<?php echo jetpack_photon_url($image[0]); ?>"></a></td>
                                            <td><table>
                                                    <tr><td><a href="<?php the_permalink(); ?>" data-action="list_story_nba" data-label="headline" data-ajax="false">
                                                        <p><?php echo get_field('teaser_title'); ?></p></a>
                                                    </td></tr>
                                                    <tr><td><p>by <?php the_author(); ?></p></td></tr>
                                                </table>
                                            </td>
                                        </tr></table>
                                    </div>
                            <?php endwhile; wp_reset_query(); ?>
                        </div>
                        <div class="sport-list mlb">
                            <h1>MLB</h1>
                            <?php $args = array('category_name' => 'MLB', 'posts_per_page' => 3, 'post__not_in' => $excludePostIds);
                                $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                    <div class="list-content">
                                        <table><tr>
                                            <td><a href="<?php the_permalink(); ?>" data-action="list_story_mlb" data-label="image" data-ajax="false">
												<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                            	<img src="<?php echo jetpack_photon_url($image[0]); ?>"></a></td>
                                            <td><table>
                                                    <tr><td><a href="<?php the_permalink(); ?>" data-action="list_story_mlb" data-label="headline" data-ajax="false">
                                                        <p><?php echo get_field('teaser_title'); ?></p></a>
                                                    </td></tr>
                                                    <tr><td><p>by <?php the_author(); ?></p></td></tr>
                                                </table>
                                            </td>
                                        </tr></table>
                                    </div>
                            <?php endwhile; wp_reset_query(); ?>
                        </div>
                        <div class="sport-list nhl">
                            <h1>NHL</h1>
                            <?php $args = array('category_name' => 'NHL', 'posts_per_page' => 3, 'post__not_in' => $excludePostIds);
                                $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                    <div class="list-content">
                                        <table><tr>
                                            <td><a href="<?php the_permalink(); ?>" data-action="list_story_nhl" data-label="image" data-ajax="false">
												<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                            	<img src="<?php echo jetpack_photon_url($image[0]); ?>"></a></td>
                                            <td><table>
                                                    <tr><td><a href="<?php the_permalink(); ?>" data-action="list_story_nhl" data-label="headline" data-ajax="false">
                                                        <p><?php echo get_field('teaser_title'); ?></p></a>
                                                    </td></tr>
                                                    <tr><td><p>by <?php the_author(); ?></p></td></tr>
                                                </table>
                                            </td>
                                        </tr></table>
                                    </div>
                            <?php endwhile; wp_reset_query(); ?>
                        </div>
                        <div class="sport-list ncaa">
                            <h1>NCAA</h1>
                            <?php $args = array('category_name' => 'NCAA', 'posts_per_page' => 3, 'post__not_in' => $excludePostIds);
                                $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                    <div class="list-content">
                                        <table><tr>
                                            <td><a href="<?php the_permalink(); ?>" data-action="list_story_ncaa" data-label="image" data-ajax="false">
												<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                            	<img src="<?php echo jetpack_photon_url($image[0]); ?>"></a></td>
                                            <td><table>
                                                    <tr><td><a href="<?php the_permalink(); ?>" data-action="list_story_ncaa" data-label="headline" data-ajax="false">
                                                        <p><?php echo get_field('teaser_title'); ?></p></a>
                                                    </td></tr>
                                                    <tr><td><p>by <?php the_author(); ?></p></td></tr>
                                                </table>
                                            </td>
                                        </tr></table>
                                    </div>
                            <?php endwhile; wp_reset_query(); ?>
                        </div>
                        <div class="sport-list opinion">
                            <h1>Opinion</h1>
                            <?php $args = array('category_name' => 'Opinion', 'posts_per_page' => 3, 'post__not_in' => $excludePostIds);
                                $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                    <div class="list-content">
                                        <table><tr>
                                            <td><a href="<?php the_permalink(); ?>" data-action="list_story_opinion" data-label="image" data-ajax="false">
												<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                            	<img src="<?php echo jetpack_photon_url($image[0]); ?>"></a></td>
                                            <td><table>
                                                    <tr><td><a href="<?php the_permalink(); ?>" data-action="list_story_opinion" data-label="headline" data-ajax="false">
                                                        <p><?php echo get_field('teaser_title'); ?></p></a>
                                                    </td></tr>
                                                    <tr><td><p>by <?php the_author(); ?></p></td></tr>
                                                </table>
                                            </td>
                                        </tr></table>
                                    </div>
                            <?php endwhile; wp_reset_query(); ?>
                        </div>
                    </div>
                    <div class="twitter-widget right">
                        <a class="twitter-timeline" href="https://twitter.com/PerfectPickem" data-widget-id="549782710412402691">Tweets by @PerfectPickem</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</div>
