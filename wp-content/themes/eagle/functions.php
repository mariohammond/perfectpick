<?php // Eagle Theme Functions

	/* Set image size presets */
	add_action('after_setup_theme', 'thumbnail_setup');
	function thumbnail_setup() {
		add_theme_support('post-thumbnails');
		add_image_size('780x450', 780, 450, true);
		add_image_size('670x420', 670, 420, true);
		add_image_size('430x260', 430, 260, true);
		add_image_size('360x225', 360, 225, true);
		add_image_size('230x145', 230, 145, true);
		add_image_size('64x64', 64, 64, true);
		add_image_size('1x1', 1, 1, true);
	}
	
	add_filter('image_size_names_choose', 'custom_image_sizes_choose');
	function custom_image_sizes_choose($sizes) {
		$custom_sizes = array(
			'780x450' => '780x450',
			'670x420' => '670x420',
			'430x260' => '430x260',
			'360x225' => '360x225',
			'230x145' => '230x145',
			'64x64' => '64x64',
			'1x1' => '1x1',
		);
		return array_merge($sizes, $custom_sizes);
	}
	
	/* Create custom sidebars */
	function arphabet_widgets_init() {
		register_sidebar( array(
			'name'          => 'Lead Stories Order',
			'id'            => 'lead_stories_order',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		) );
	}
	add_action('widgets_init', 'arphabet_widgets_init');
?>
