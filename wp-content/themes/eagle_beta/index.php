<?php 
	$cat_info = get_the_category();
	//$category = $cat_info[0]->name;
	
	foreach ($cat_info as $cat) {
		if ($cat->name == 'NFL' || $cat->name == 'NBA' || $cat->name == 'MLB' || $cat->name == 'NHL' || $cat->name == 'NCAA') {
			$category = $cat->name;
		}
	}
	
	$excludePostIds = array();
?>
<html>
<head>
	<?php wp_head(); ?>
    <title><?php wp_title(''); ?></title>
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico"/>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    
    <meta name="viewport" content="width=device-width", initial-scale=1"">
    <meta charset="<?php bloginfo('charset'); ?>">
    
    <link href='http://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo content_url(); ?>/themes/eagle/styles.php" type="text/css">
    
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54a1b25a2da792fa" async="async"></script>
    
	<script type="text/javascript" src="<?php echo content_url(); ?>/themes/eagle/scripts.php"></script>
    <script type="text/javascript">
	var addthis_share = addthis_share || {}
	addthis_share = {
		passthrough : {
			twitter: {
				via: "PerfectPickem"
			}
		}
	}
	</script>
    <script>
  	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 	 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  	ga('create', 'UA-58067202-1', 'auto');
	ga('require', 'displayfeatures');
  	ga('send', 'pageview');
	</script>
</head>
<body>
	<?php
		if (is_front_page()) {
			include 'page-home.php';	
		} else if (is_category()) {
			include 'page-category.php';	
		} else if (is_single()) {
			include 'page-article.php';
		}
	?>
</body>
</html>
