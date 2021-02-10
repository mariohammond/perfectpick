<div class="ArticleWrapper">
	<?php include 'menu.php'; ?>
    <div class="MainContainer right">
        <?php include 'header.php'; ?>
        <div class="cover-container"></div>
        <div class="ContentContainer">
            <div class="GameBlockContainer">
                <span>
                    <a href="#" class="ad-block-1 right"><img src="<?php bloginfo('template_directory'); ?>/images/728x90.png"/></a>
                </span>
            </div>
            <div class="SidebarLeftContainer left"></div>
            <div class="ArticleContainer left">
            	<div class="article-heading">
                	<?php while (have_posts()) : the_post(); ?>
                        <h1 class="article-title"><?php the_title(); ?><div class="addthis_sharing_toolbox" data-title="<?php echo get_field('teaser_title'); ?>"></h1>
                        <p class="article-author">By <?php echo get_the_author() . ", " . get_the_author_meta('nickname'); ?></p>
                        <p class="article-date"><?php echo get_the_date() . " - " . get_the_time(); ?></p>
                        <hr>
              		<?php endwhile; ?>
                </div>
                <div class="article-image">
                	<a href="<?php echo get_field('getty_link') ?>" target="_blank"><?php the_post_thumbnail(); ?></a>
                    <p class="deck"><?php echo get_field('deck'); ?></p>
                </div>
                <div class="article-content">
                	<p><?php the_content(); ?></p>
                </div>
                <div class="related-stories">
                    <h2>More <?php echo $category; ?> Stories</h2>
                    <div class="related-images flex">
                    	<?php $args = array('category_name' => $category, 'posts_per_page' => 3, 'post__not_in' => array($post->ID));
                                $my_query = new WP_Query($args); while ($my_query->have_posts()) : $my_query->the_post(); ?>
                        <table>
                        	<tr>
                            	<td>
									<a href="<?php the_permalink(); ?>" data-label="image" data-ajax="false"><?php the_post_thumbnail(); ?></a>
                            	</td>
                            </tr>
                            <tr>
                            	<td>
                                	<a href="<?php the_permalink(); ?>" data-label="headline" data-ajax="false"><p><?php echo get_field('teaser_title'); ?></p></a>
                                </td>
                            </tr>
                       	</table>
                        <?php endwhile; wp_reset_query(); ?>
                    </div>
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
        </div>
        <?php include 'footer.php'; ?>
    </div>
</div>
