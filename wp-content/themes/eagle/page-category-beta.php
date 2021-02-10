<div id="region-2" class="category flex">
    <?php $args = array('category_name' => $archiveName, 'posts_per_page' => 1, 'post__not_in' => $excludePostIds);
            $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
    <div class="featured-story large left">
        <a class="featured-image" href="<?php the_permalink(); ?>" data-category="pp-archive" data-action="featured-story-large" data-label="image">
        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '670x420');
		$image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '780x450');
		$image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
		<picture>
			<source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
			<source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
			<img srcset="<?php echo jetpack_photon_url($image2[0]); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
		</picture>
        </a>
        <div class="featured-text-large left">
            <a href="<?php the_permalink(); ?>" data-category="pp-archive" data-action="featured-story-large" data-label="headline">
                <h1 class="featured-title"><?php echo get_field('teaser_title'); ?></h1>
            </a>
        </div>
    </div>
    <?php endwhile; wp_reset_query(); ?>
    <div class="featured-small-container">
    <?php $args = array('category_name' => $archiveName, 'posts_per_page' => 2, 'post__not_in' => $excludePostIds);
            $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
            <div class="featured-story small right">
                <a class="featured-image" href="<?php the_permalink(); ?>" data-category="pp-archive" data-action="featured-story-small" data-label="image">
                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '360x225');
				$image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '670x420');
				$image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
				<picture>
					<source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
					<source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
					<img srcset="<?php echo jetpack_photon_url($image2[0]); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
				</picture>
              	</a>
                <a class="featured-title-small" href="<?php the_permalink(); ?>" data-category="pp-archive" data-action="featured-story-small" data-label="headline"><h2><?php echo get_field('teaser_title'); ?></h2>
                </a>
            </div>
    <?php endwhile; wp_reset_query(); ?>
    </div>
</div>
<!--<div id="region-2a" class="ad left">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle leaderboard"
         style="display:inline-block;"
         data-ad-client="ca-pub-7176350007636201"
         data-ad-slot="5266426370"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>-->
<div id="region-3" class="category left">
    <?php for($i = 0; $i < 2; $i++) : ?>
    <div class="category-list-group">
        <!--<div style="float: left; width: 980px; height: 90px; background-color: orange; margin-bottom:10px;"></div>-->
        <div class="category-content flex left">
            <?php $args = array('category_name' => $archiveName, 'posts_per_page' => 6, 'post__not_in' => $excludePostIds);
                    $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
                    <div class="category-list">
                        <a class="category-image" href="<?php the_permalink(); ?>" data-category="pp-archive" data-action="category-list" data-label="image">
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '230x145');
						$image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '670x420');
						$image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
						<picture>
							<source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
							<source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
							<img srcset="<?php echo jetpack_photon_url($image2[0]); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
						</picture>
                       	</a>
                        <a class="category-image" href="<?php the_permalink(); ?>" data-category="pp-archive" data-action="category-list" data-label="headline"><h2><?php echo get_field('teaser_title'); ?></h2></a>
                        <p class="pubdate"><?php echo get_the_date("M j, Y - g:i A"); ?></p>
                        <?php include 'social-icons.php'; ?>
                    </div>
            <?php endwhile; wp_reset_query(); ?>
        </div>
        <div class="sidebar-content right">
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
        	<div class="widget ad">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                     style="display:inline-block;width:300px;height:250px"
                     data-ad-client="ca-pub-7176350007636201"
                     data-ad-slot="8219892775"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
        <div style="display:none;" class="load-more left"><a data-category="pp-archive" data-action="load-more" data-label="button"><h1>Load More &#62;</h1></a></div>
    </div>
    <?php endfor; ?>
</div>
