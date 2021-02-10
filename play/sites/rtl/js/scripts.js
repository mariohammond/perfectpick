// RTL Scripts

$(document).ready(function() {
	$desktopWidth = $(".desktopCheck").css("display") == "block";
	$tabletWidth = $(".tabletCheck").css("display") == "block";
	$mobileWidth = $(".mobileCheck").css("display") == "block";
	
	$currentWidth = "desktop";
	if ($tabletWidth)	$currentWidth = "tablet";
	if ($mobileWidth)	$currentWidth = "mobile";
	
	$(window).resize(function() {
		$desktopWidth = $(".desktopCheck").css("display") == "block";
		$tabletWidth = $(".tabletCheck").css("display") == "block";
		$mobileWidth = $(".mobileCheck").css("display") == "block";
		
		$currentWidth = "desktop";
		if ($tabletWidth)	$currentWidth = "tablet";
		if ($mobileWidth)	$currentWidth = "mobile";
	});
});

$(document).ready(function() {
	// Add image placeholder
	$("img").on("error", function () {
		this.src = "/images/placeholder.jpg";
	});
	
	// Setup menu layout and functionality
	if ($mobileWidth) {
		$(".menu").css("height", window.innerHeight + 100);
	} else {
		$documentHeight = $(document).height();
		$(".menu").css("height", $documentHeight);
	}
	
	$(window).resize(function() {
		if ($mobileWidth) {
			$(".menu").css("height", window.innerHeight + 100);
		} else {
			$documentHeight = $(document).height();
			$(".menu").css("height", $documentHeight);
		}
	});
	
	$(".header").on("click", ".menu-button", function(e) {
		$(".menu").css("left", "0");
		e.preventDefault();
	});
	
	$(".menu-close").click(function(e) {
		$(".menu").css("left", "-230");
		e.preventDefault();
	});
	
	$(".menu-chevron.more").click(function(e) {
		var subMenu = $(this).attr("id");
		$(".menu-chevron.more#" + subMenu).hide();
		$(".menu-chevron.less#" + subMenu).show();
		$(".menu-option.sub-menu." + subMenu).slideDown();
		e.preventDefault();
	});
	
	$(".menu-chevron.less").click(function(e) {
		var subMenu = $(this).attr("id");
		$(".menu-chevron.less#" + subMenu).hide();
		$(".menu-chevron.more#" + subMenu).show();
		$(".menu-option.sub-menu." + subMenu).slideUp();
		e.preventDefault();
	});
	
	// Adjust size and position on tablet
	/*if (currentRes == "tablet") {
		$(".gallery-container").css("width", $(window).width());
		$(".gallery-container").offset({left: 0});
	}
	$(window).resize(function() {
		if (currentRes == "tablet") {
			$(".gallery-container").css("width", $(window).width());
			$(".gallery-container").offset({left: 0});
		} else {
			$(".gallery-container").css("width", "100%");
			$(".gallery-container").css("left", "0");
		}
	});*/
	
	// Set width of photo gallery
	var photos = $("#page-home .photo").length;
	var galleryWidth = parseInt($("#page-home #slideshow").css("width").replace("px", ""));
	
	var currentWidth = photos * galleryWidth;
	$("#page-home .photo-gallery").css("width", currentWidth);
	
	// Left and right button functions
	$("#page-home .fa-angle-left").click(function(e) {
		var currentPos = parseInt($("#page-home .photo-gallery").css("left").replace("px", ""));
		$("#page-home .fa").removeClass("fade");
		if (currentPos < 0) {
			$("#page-home .photo-gallery").css("left", currentPos + galleryWidth);
		} else {
			$(this).addClass("fade");	
		}
	});
	$("#page-home .fa-angle-right").click(function(e) {
		var currentPos = $("#page-home .photo-gallery").css("left").replace("px", "");
		$("#page-home .fa").removeClass("fade");
		if (currentPos > -(galleryWidth * (photos - 1))) {
			$("#page-home .photo-gallery").css("left", currentPos - galleryWidth);
		} else {
			$(this).addClass("fade");	
		}
	});
});
