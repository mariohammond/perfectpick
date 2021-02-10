<?php
	session_start();
	
	include_once 'connect/db-connect.php';
	include_once 'util/functions.php';

	$directory = get_bloginfo('template_directory');
	$excludePostIds = array();
	
	// Functions
	$nextMatch = getNextMatch($connection);
	$allTimeLeaders = getRanking($connection, "");
	$yearLeaders = getRanking($connection, "Year");
	$monthLeaders = getRanking($connection, "Month");
	$upcomingMatches = getUpcomingMatches($connection);
	
	$categoryList = array("NFL", "NBA", "MLB", "NHL", "NCAA", "Quiz");
?>
<html>
<head>
	<?php wp_head(); ?>
    <?php
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        echo 'url: ' . $url;
		if (is_front_page()) {
			$title = "Perfect Pick'em | " . get_bloginfo("description");
		} else if (is_archive()) {
			$title = single_cat_title("", false);
			$title = strtoupper($title) . " | Perfect Pick'em";
		} else if (is_single() || is_page()) {
			$title = get_the_title()  . " | Perfect Pick'em";
		} else if (strpos($url, 'webhook') !== false) {
            include 'webhook.php';
        } else if (is_404()) {
			$title = "Page not found | Perfect Pick'em";
		} else {
			$title = "Perfect Pick'em";
		}
	?>
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico"/>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    
    <meta name="google-site-verification" content="YhJA1YcItTO-Vs9KurpcjiCkF9p0EOEbdRPSraTihV8" />
    <meta name="p:domain_verify" content="083448de9ae9b1a98be3311219158a3f"/>
    <meta name="viewport" content="width=device-width", initial-scale=1"">
    <meta charset="<?php bloginfo('charset'); ?>">
    
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@perfectpickem">
    <meta name="twitter:title" content="<?php echo get_field('teaser_title'); ?>">
    <meta name="twitter:creator" content="@perfectpickem">
    <meta name="twitter:widgets:csp" content="on">
    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '670x420'); $image1 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '780x450'); $image2 = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '430x260'); ?>
    <meta name="twitter:image" content="<?php echo jetpack_photon_url($image2[0]); ?>"">
    
    <link href='http://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    
    <!--<link rel="stylesheet" href="<?php //echo content_url(); ?>/themes/eagle/styles.php" type="text/css">-->
    <link rel="stylesheet" href="<?php echo content_url(); ?>/themes/eagle/style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo content_url(); ?>/themes/eagle/css/desktop.css" type="text/css">
    <link rel="stylesheet" href="<?php echo content_url(); ?>/themes/eagle/css/tablet.css" type="text/css">
    <link rel="stylesheet" href="<?php echo content_url(); ?>/themes/eagle/css/mobile.css" type="text/css">
    
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54a1b25a2da792fa" async="async"></script>
    
	<script type="text/javascript" src="<?php echo content_url(); ?>/themes/eagle/scripts.php"></script>
    
    <!-- AddThis Sharing: Start -->
    <script type="text/javascript">var addthis_config = {'data_use_flash': false, 'data_track_clickback': true};</script>
	<script type="text/javascript">
	var addthis_share = {
		passthrough : { twitter: { via: "PerfectPickem" } },
		url_transforms : { shorten: { twitter: 'bitly' } }, 
		shorteners : { bitly : {} }
	}
	</script>
    <!-- AddThis Sharing: End -->
    
    <!-- Google Analytics: Start -->
    <script>
  	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 	 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  	ga('create', 'UA-58067202-1', 'auto');
	ga('require', 'displayfeatures');
  	ga('send', 'pageview');
	</script>
    <!-- Google Analytics: End -->
</head>
<body>
	<!-- FB Comments: Start -->
	<div id="fb-root"></div>
	<script>
	(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=688615697852514";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- FB Comments: End -->
    
	<?php include 'menu.php'; ?>
    <?php include 'header.php'; ?>
    <div class="MainContainer">
		<?php if (is_front_page()) {
            include 'page-home.php';	
        } else if (is_archive()) {
            include 'page-archive.php';	
        } else if (is_single()) {
            include 'page-article.php';
        } else if (is_page()) {
            include 'page-basic.php';
        } else if (strpos($url, 'webhook') !== false) {
            include 'webhook.php';
        } else if (is_404()) {
			include 'page-404.php';
		}
        include 'footer.php'; ?>
    </div>
	<script>
    $(".social-icon.sms").click(function() {
		var ua = navigator.userAgent.toLowerCase();
		var url;
		
		if (ua.indexOf("iphone") > -1 || ua.indexOf("ipad") > -1) {
			url = "sms:&body=<?php echo get_field('teaser_title'); ?> | Perfect Pick'em <?php the_permalink(); ?>";
		} else {
			url = "sms:?body=<?php echo get_field('teaser_title'); ?> | Perfect Pick'em <?php the_permalink(); ?>";
		}
    
    	location.href = url;
    });
    </script>
	<span class="wideCheck"></span><span class="desktopCheck"></span><span class="tabletCheck"></span><span class="mobileCheck"></span>
</body>
</html>
