<?php include_once 'connect/connect-info.php'; ?>

<link rel="shortcut icon" href="images/favicon.ico"/>
<meta name="viewport" content="width=device-width", initial-scale=1"">     
<link href='http://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<!-- Lean Modal Popup Box: Start -->
<script type="text/javascript" src="js/lean-modal.min.js"></script>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />
<link type="text/css" rel="stylesheet" href="css/lean-modal.css" />
<!-- Lean Modal Popup Box: End -->

<!-- Percentage Circle: Start -->
<script type="text/javascript" src="js/jquery.diagram.js"></script>
<!-- Percentage Circle: End -->

<!-- Lazy Loading: Start -->
<script type="text/javascript" src="js/jquery.lazyload.js"></script>
<!-- Lazy Loading: End -->

<script>
$(function() { 
	$("#LeaderboardContainer").tabs(); 
});
</script>

<script type="text/javaScript" src="js/sha512.js"></script>
<script type="text/javaScript" src="js/forms.js"></script>
<script type="text/javascript" src="js/scripts.js"></script>

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/desktop.css" type="text/css">
<link rel="stylesheet" href="css/tablet.css" type="text/css">
<link rel="stylesheet" href="css/mobile.css" type="text/css">

<!-- Vex Dialog Box: Start -->
<script src="js/vex/js/vex.combined.min.js"></script>
<script>vex.defaultOptions.className = 'vex-theme-os';</script>
<link rel="stylesheet" href="js/vex/css/vex.css" />
<link rel="stylesheet" href="js/vex/css/vex-theme-os.css" />

<script>
function joinMatch(matchId) {
	$.ajax({
		type: "POST",
		url: "util/view_match.php?match_id=" + matchId,
		datatype: "html",
		success: function(data) {
			vex.dialog.buttons.YES.text = 'Join Match';
			vex.dialog.confirm({
				input: "<style>.vex-dialog-message h1 { color: #00a550 !important; } .vex.vex-theme-os .vex-dialog-button.vex-dialog-button-primary { background: #00a550; }</style>",
				message: data,
				callback: function(value) {
					if (value) {
						window.location.href = "util/join_match?matchId=" + matchId;
					}
				}
			});
		}
	});
}

function quitMatch(matchId) {
	vex.dialog.buttons.YES.text = 'Quit Match';
	vex.dialog.confirm({
		message: 'Quit match? All saved picks will be erased.',
		callback: function(value) {
			if (value) {
				window.location.href = "util/quit_match?match=" + matchId;
			}
		}
	});
}
</script>
<!-- Vex Dialog Box: End -->

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-58067202-1', 'auto');
ga('require', 'displayfeatures');
ga('send', 'pageview');
</script>
