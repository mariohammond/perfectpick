<?php // Eagle Theme Functions

	/* Enable featured image option */
	add_theme_support('post-thumbnails');
	
	/* Create custom title for home page */
	add_filter('wp_title', 'get_custom_title');

	function get_custom_title($title) {
		if (empty($title) && (is_home() || is_front_page())) {
			return __('Perfect Pick\'em', 'theme_domain') . ' | ' . get_bloginfo('description');
	  	} else if (is_category()) {
			$cat_info = get_the_category();
			$category = $cat_info[0]->name;
			return $category . ' | Perfect Pick\'em'; 
		} else if (is_404()) {
			return 'Page not found | Perfect Pick\'em';
		} else {
	  		return $title;
		}
	}
	
	add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
	add_comments_page('My Plugin Comments', 'My Plugin', 'read', 'my-unique-identifier', 'my_plugin_function');
}
?>
