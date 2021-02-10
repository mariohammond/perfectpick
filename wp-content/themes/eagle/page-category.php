<div id="region-2" class="topic flex left">
    <?php $args = array('category_name' => $archiveName); $my_query = new WP_Query($args); 
			while ($my_query->have_posts()) : $my_query->the_post(); $excludePostIds[] = get_the_id(); ?>
    <div class="story-list">
        <a class="list-image" href="<?php the_permalink(); ?>" data-category="pp-archive" data-action="topic" data-label="image">
        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '360x225');
		$image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '670x420');
		$image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
		<picture>
			<source srcset="<?php echo $image[0]; ?>" media="(min-width: 1024px)">
			<source srcset="<?php echo $image1[0]; ?>" media="(min-width: 415px)">
			<img srcset="<?php echo jetpack_photon_url($image2[0]); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
		</picture>
        </a>
        <div class="list-headline left">
            <a href="<?php the_permalink(); ?>" data-category="pp-archive" data-action="topic" data-label="headline">
                <h1 class="list-title"><?php echo get_field('teaser_title'); ?></h1>
                <p class="list-summary"><?php echo get_field('summary'); ?></p>
                <?php include 'social-icons.php'; ?>
            </a>
        </div>
    </div>
    <?php endwhile; wp_reset_query(); ?>
</div>
<div id="region-4" class="right">
	<?php include 'sidebars/sidebar-archive.php'; ?>
</div>
