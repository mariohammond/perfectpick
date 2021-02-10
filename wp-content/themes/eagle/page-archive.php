<?php
	$path = explode("/", $_SERVER['REQUEST_URI']);
	
	if ($path[1] == "topic") {
		$archiveType = "topic";
		$archiveName = $path[2];
	} else {
		$archiveType = "category";
		$archiveName = $path[1];
	}
?>
<div id="page-archive" class="content">
	<div id="region-1">
    	<div class="ad">
        	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle billboard"
                 style="display:block"
                 data-ad-client="ca-pub-7176350007636201"
                 data-ad-slot="9836226773"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div class="section-title"><h1><?php echo str_replace("-", " ", strtoupper($archiveName)); ?></h1></div>
    </div>
    
    <?php 
		//if ($archiveType == "category") {
			//include 'page-category.php';
		//} elseif ($archiveType == "topic") {
			include 'page-topic.php';
		//}
	?>
    
    <div id="region-footer-ad" class="left">
    	<div class="ad">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle leaderboard"
                 style="display:inline-block;"
                 data-ad-client="ca-pub-7176350007636201"
                 data-ad-slot="2312959972"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
</div>
