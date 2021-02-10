// Eagle Theme Scripts (Tablet)

$(document).ready(function() {
	if ($tabletWidth) {
		// Display second 728x90 ad
		$(".TabletAdContainer").addClass("flex");
	}
	
	$(window).resize(function() {
		if ($tabletWidth) {
			// Display second 728x90 ad
			$(".TabletAdContainer").addClass("flex");
		} else {
			// Remove tablet 728x90 ad
			$(".TabletAdContainer").removeClass("flex");
		}
	});
});
