<?php ?>
<!DOCTYPE html>
<html>
<head>
	<title>Page Not Found | Perfect Pick'em</title>
	<?php include 'head-info.php'; ?>
</head>
<body>
	<div class="404Wrapper">
		<?php include 'menu.php'; ?>
        <?php include 'header.php'; ?>
        <div class="PageNotFoundContainer Main">
            <h2>Oops.... This page doesn't exist.</h2>
            <p>Don't worry. It happens to everyone.</p>
            <h2><a data-category="pp-404" data-action="link" data-label="home" href="http://play.perfectpickem.com"><span style="color:#fc4349;">Click here</span></a> to return back to the home page.</h2>
            <img class="punter-fail" src="images/punter-fail.gif" style="display:none">
        </div>
        <?php include 'footer.php'; ?>
        <script>
		$(document).ready(function(e) {
           $(".404Wrapper .FooterContainer").css("top", "70px");
		   $(".404Wrapper .punter-fail").show();
        });
		</script>
    </div>
</body>
