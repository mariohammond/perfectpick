// Eagle Theme Scripts (Desktop)

$(document).ready(function() {
	// Adjust Story List Container after twitter widget removed
	if ($wideWidth == false) {
		$(".list-content .story-list").css("width", "100%");
	}
	
	$(window).resize(function() {
		if ($wideWidth == false) {
			$(".list-content .story-list").css("width", "100%");
		}
	});
});
