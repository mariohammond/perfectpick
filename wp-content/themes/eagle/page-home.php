<div id="page-home" class="content">
    <div id="region-1">
        <div class="next-match left">
            <a data-category="pp-home" data-action="next-match" data-label="title" href="http://play.perfectpickem.com/matches"><h1>Next Pick'em Match:</h1></a>
            <hr>
            <a data-category="pp-home" data-action="next-match" data-label="match" href="http://play.perfectpickem.com/matches"><p><?php echo $nextMatch; ?></p></a>
        </div>
        <div class="ad right">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle leaderboard"
                 style="display:inline-block;"
                 data-ad-client="ca-pub-7176350007636201"
                 data-ad-slot="7022361170"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
    <div id="region-2" class="flex">
    	<?php $my_query = new WP_Query('category_name=Featured&posts_per_page=1');
		while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
		<div class="featured-story large left">
			<a class="featured-image" href="<?php the_permalink(); ?>" data-category="pp-home" data-action="featured-story-large" data-label="image">
			<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '780x450');
            $image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '670x420');
            $image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
            <picture>
                <source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
                <source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
                <img srcset="<?php echo jetpack_photon_url($image2[0]); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
            </picture>
			</a>
			<div class="featured-text-large left">
				<a href="<?php the_permalink(); ?>" data-category="pp-home" data-action="featured-story-large" data-label="headline">
					<h1 class="featured-title"><?php echo get_field('teaser_title'); ?></h1>
				</a>
				<a href="<?php the_permalink(); ?>" data-category="pp-home" data-action="featured-story-large" data-label="deck">
					<h1 class="featured-deck"><?php echo get_field('deck'); ?>&nbsp; <span class="read-more">Read>></span></h1>
				</a>
			</div>
		</div>
		<?php endwhile; wp_reset_query(); ?>
		<div class="featured-small-container">
		<?php $args = array('category_name' => 'Featured', 'posts_per_page' => 2, 'post__not_in' => $excludePostIds);
				$my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
				<div class="featured-story small right">
					<a class="featured-image" href="<?php the_permalink(); ?>" data-category="pp-home" data-action="featured-story-small" data-label="image">
                    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260');
					$image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260');
					$image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
					<picture>
						<source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
						<source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
						<img srcset="<?php echo jetpack_photon_url($image2[0]); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
					</picture>
                    </a>
					<a class="featured-title-small" href="<?php the_permalink(); ?>" data-category="pp-home" data-action="featured-story-small" data-label="headline"><h2><?php echo get_field('teaser_title'); ?></h2>
					</a>
				</div>
		<?php endwhile; wp_reset_query(); ?>
		</div>
    </div>
    <div id="region-3" class="flex left">
    	<?php for ($i = 0; $i < count($categoryList); $i++) : $categoryLower = strtolower($categoryList[$i]); ?>
    	<?php $args = array('category_name' => "$categoryList[$i]+Lead", 'posts_per_page' => 1, 'post__not_in' => $excludePostIds);
			$my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
			<div class="lead-story">
				<div class="lead-story-image">
					<span><?php echo $categoryList[$i]; ?></span>
					<a href="<?php the_permalink(); ?>" data-category="pp-home" data-action="lead-story-<?php echo $categoryLower; ?>" data-label="image">
                    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260');
					$image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260');
					$image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
					<picture>
						<source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
						<source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
						<img srcset="<?php echo jetpack_photon_url($image2[0]); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
					</picture>
					</a>
				</div>
				<div class="lead-story-content">
					<a href="<?php the_permalink(); ?>" data-category="pp-home" data-action="lead-story-nfl" data-label="headline"><h2><?php echo get_field('teaser_title'); ?></h2></a>
					<p><?php echo get_field('summary') ?></p>
					<?php include 'social-icons.php'; ?>
				</div>
			</div>
		<?php endwhile; wp_reset_query(); endfor; ?>
    </div>
    <div id="region-4" class="right">
    	<?php include 'sidebars/sidebar-home.php'; ?>
    </div>
    <!--<div id="region-4a" class="ad left">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle leaderboard"
             style="display:block"
             data-ad-client="ca-pub-7176350007636201"
             data-ad-slot="9975827570"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>-->
    <div id="region-5" class="flex left">
    	<?php for ($i = 0; $i < count($categoryList); $i++) : $categoryLower = strtolower($categoryList[$i]); ?>
    	<div class="flex sport-list <?php echo $categoryLower; ?>">
            <h1><?php echo $categoryList[$i]; ?></h1>
            <?php $args = array('category_name' => "$categoryList[$i]", 'posts_per_page' => 3, 'post__not_in' => $excludePostIds);
                $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                    <div class="list-content">
                        <table><tr>
                            <td><a href="<?php the_permalink(); ?>" data-category="pp-home" data-action="list-story-<?php echo $categoryLower; ?>" data-label="image">
                                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '64x64'); ?>
								<picture><img srcset="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/></picture></a>
                            <td><table>
                                    <tr><td><a href="<?php the_permalink(); ?>" data-category="pp-home" data-action="list-story-<?php echo $categoryLower; ?>" data-label="headline">
                                        <p class="headline"><?php echo get_field('teaser_title'); ?></p></a>
                                    </td></tr>
                                    <tr><td><p class="pubdate"><?php echo get_the_date("M j, Y - g:i A"); ?></p></td></tr>
                                </table>
                            </td>
                        </tr></table>
                    </div>
            <?php endwhile; wp_reset_query(); ?>
        </div>
        <?php endfor; ?>
    </div>
    <div id="region-footer-ad" class="left">
    	<div class="ad">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle leaderboard"
                 style="display:block"
                 data-ad-client="ca-pub-7176350007636201"
                 data-ad-slot="2452560773"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
</div>
