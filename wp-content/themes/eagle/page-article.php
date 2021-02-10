<?php 
	$categories = array("NFL", "NBA", "MLB", "NHL", "NCAA", "Quiz");
	$postCategory = get_the_category(); 
	
	foreach ($postCategory as $pc) {
		for ($i = 0; $i < count($categories); $i++) {
			if ($pc->name == $categories[$i]) {
				$category = $pc->name;
			}
		}
	}
	
	$relatedMatch = getRelatedMatch($connection, $category);
	$authors = get_coauthors();
?>
<?php include 'article-header.php'; ?>
<div id="page-article" class="content">
	<div id="region-1">
    	<!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <ins class="adsbygoogle lrg-leaderboard"
             style="display:inline-block;"
             data-ad-client="ca-pub-7176350007636201"
             data-ad-slot="8080291976"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>-->
    </div>
    <article id="region-2" class="<?php echo $category; ?> left">
	<?php while (have_posts()) : the_post(); ?>
        <h1 class="title"><?php the_title(); ?></h1>
        <?php include 'social-icons.php'; ?>
        
        
        <?php foreach ($authors as $author) : ?>
			<?php if ($author->type == "guest-author") : ?>
				<p class="author">By <a class="author-link" href="<?php echo $author->website; ?>" target="_blank"><?php echo $author->display_name; ?></a></p>
            <?php else : ?>
            	<p class="author">By <?php the_author(); ?></p>
                <a class="author-twitter" href="http://www.twitter.com/<?php the_author_meta('twitter'); ?>" target="_blank" data-category="pp-article" data-action="author" data-label="twitter"><span class="fa fa-twitter link"></span><span class="twitter-name">@<?php the_author_meta('twitter'); ?></span></a>
		<?php endif; endforeach; ?>
        
        <p class="pubdate"><?php echo get_the_date() . " - " . get_the_time(); ?></p>
        <hr>
        <div class="featured-media">
			<?php if (get_field('youtube_link')) : ?>
                <iframe class="featured-video" src="<?php echo get_field('youtube_link'); ?>" frameborder="0" allowfullscreen></iframe>
                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '1x1'); ?>
                <img src="<?php echo $image[0]; ?>" style="display: none;"/>
            <?php else : ?>
            	<?php if (get_field('show_lead_photo') == 'Yes') : ?>
                <div class="featured-image">
                	<?php if (get_field('image_link')) : ?>
                    <a href="<?php echo get_field('image_link'); ?>" target="_blank" data-category="pp-article" data-action="featured-media" data-label="image">
					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '670x420');
					$image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '780x450');
					$image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
					<picture>
						<source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
						<source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
						<img srcset="<?php echo jetpack_photon_url($image2[0]); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
					</picture>
                    </a>
                    <div class="image-owner">
                    	<a href="<?php echo get_field('image_owner_link'); ?>" target='_blank' data-category="pp-article" data-action="featured-media" data-label="photographer"><?php echo get_field('image_owner'); ?></a>
                    </div>
                    <?php else :
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '670x420');
					$image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '780x450');
					$image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
					<picture>
						<source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
						<source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
						<img srcset="<?php echo jetpack_photon_url($image2[0]); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
					</picture>
                    <?php endif; ?>
                </div>
                <p class="deck"><?php echo get_field('deck'); ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="article-content">
            <p><?php the_content(); ?></p>
            <div class="topics left">
				<p><?php the_tags("<span>Topics</span>", ", ", ""); ?></p>
            </div>
        </div>
    <?php endwhile; ?>
    </article>
    <div id="region-3" class="right">
    	<?php include 'sidebars/sidebar-article.php'; ?>
    </div>
    <div id="region-3a" class="left">
    	<!--<div class="ad">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle article-insert"
                 style="display:inline-block"
                 data-ad-client="ca-pub-7176350007636201"
                 data-ad-slot="9277823575"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>-->
        <?php if ($relatedMatch['match_id'] != NULL && $relatedMatch['match_id'] != "") : ?>
        <div class="related-match">
        	<h1>MATCH AVAILABLE!</h1>
            <h2><?php echo $relatedMatch['title']; ?></h2>
            <a href="http://play.perfectpickem.com/match?matchId=<?php echo $relatedMatch['match_id']; ?>" data-category="pp-article" data-action="related-match" data-label="play-now"><h3>Play Now!</h3></a>
        </div>
        <?php endif; ?>
    </div>
    <div id="region-4" class="left">
    	<div class="related-stories">
            <h2>More <?php echo $category; ?> Stories</h2>
            <div class="related-images flex">
                <?php $args = array('category_name' => $category, 'posts_per_page' => 3, 'post__not_in' => array($post->ID));
                        $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <table>
                    <tr><td>
                        <a href="<?php the_permalink(); ?>" data-category="pp-article" data-action="related-stories" data-label="image">
						<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '230x145');
                        $image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '670x420');
                        $image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
                        <picture>
                            <source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
                            <source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
                            <img srcset="<?php echo $image2[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                        </picture>
                        </a>
                        </td></tr>
                    <tr><td>
                        <a href="<?php the_permalink(); ?>" data-category="pp-article" data-action="related-stories" data-label="headline"><p><?php echo get_field('teaser_title'); ?></p></a>
                    </td></tr>
                </table>
                <?php endwhile; wp_reset_query(); ?>
            </div>
        </div>
    </div>
    <div id="region-5" class="left">
    	<div class="fb-comments" data-href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" data-width="100%" data-numposts="5"></div>
    </div>
    <div id="region-footer-ad" class="left">
    	<div class="ad">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle leaderboard"
                 style="display:inline-block;"
                 data-ad-client="ca-pub-7176350007636201"
                 data-ad-slot="3231289971"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
</div>
