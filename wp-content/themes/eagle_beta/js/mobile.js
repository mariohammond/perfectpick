// Eagle Theme Scripts (Mobile)

$(document).ready(function(e) {
	// Set ContentContainer width
	$(".ContentContainer").css("width", "auto");
	
	// Adjust height of landing page images
	$(window).bind("load", function() {
		$landingImgWidth = $(".category-list-image img").width();
		$(".category-list-image img").css("height", $landingImgWidth / 1.5);
	});
	
	$(window).resize(function() {
		$landingImgWidth = $(".category-list-image img").width();
		$(".category-list-image img").css("height", $landingImgWidth / 1.5);
	});
	
	// Set properties for mobile article page
	if ($mobileWidth) {
		$(".ArticleWrapper .ContentContainer").css("width", $(window).width());
		$(".ArticleContainer").css("width", $(window).width() - 20);
		$(".article-title").css("width", $(window).width() - 20);
		$(".article-image img").css("width", $(window).width() - 20);
		$(".article-image .deck").css("width", $(window).width() - 10);
		$(".article-content").css("width", $(window).width() - 20);
		$("iframe.vine-embed").css({"width": $(window).width() - 20, "height": $(window).width() - 20});
		$(".embed.embed-simple").css({"width": $(window).width() - 20, "height": $(window).width() - 20});
		$(".related-images").removeClass("flex");
		$(".related-images table").css("width", "100%");
		$(".related-images img").css("height", "auto");
	}
	
	$(window).resize(function() {
		if ($mobileWidth) {
			$(".ArticleWrapper .ContentContainer").css("width", $(window).width());
			$(".ArticleContainer").css("width", $(window).width() - 20);
			$(".article-title").css("width", $(window).width() - 20);
			$(".article-image img").css("width", $(window).width() - 20);
			$(".article-image .deck").css("width", $(window).width() - 10);
			$(".article-content").css("width", $(window).width() - 20);
			$("iframe.vine-embed").css({"width": $(window).width() - 20, "height": $(window).width() - 20});
			$(".embed.embed-simple").css({"width": $(window).width() - 20, "height": $(window).width() - 20});
			$(".related-images").removeClass("flex");
			$(".related-images table").css("width", "100%");
			$(".related-images img").css("height", "auto");
		} else if ($tabletWidth) {
			$(".ArticleWrapper .ContentContainer").css("width", "728");
			$(".ArticleContainer").css("width", "620");
			$(".article-title").css("width", "auto");
			$(".article-image img").css("width", "100%");
			$(".article-image .deck").css("width", "auto");
			$(".article-content").css("width", "auto");
			$("iframe.vine-embed").css({"width": "600", "height": "600"});
			$(".embed.embed-simple").css({"width": "600", "height": "600"});
			$(".related-images").addClass("flex");
			$(".related-images table").css("width", "32%");
			$(".related-images img").css("height", "120px");
		} else {
			$(".ArticleWrapper .ContentContainer").css("width", "960");
			$(".ArticleContainer").css("width", "620");
			$(".article-title").css("width", "auto");
			$(".article-image img").css("width", "100%");
			$(".article-image .deck").css("width", "auto");
			$(".article-content").css("width", "auto");
			$("iframe.vine-embed").css({"width": "600", "height": "600"});
			$(".embed.embed-simple").css({"width": "600", "height": "600"});
			$(".related-images").addClass("flex");
			$(".related-images table").css("width", "32%");
			$(".related-images img").css("height", "120px");	
		}
	});
});

// Swipe left to close menu
$(function() {
  $(".MenuContainer").on("swipeleft", function(e) {
  		$(".MenuContainer").css("left", "-200");
		$(".MainContainer").css("left", "0");
		$(".MainContainer").css("opacity", "1");
		$(".cover-container").css("display", "none");
		
		e.preventDefault();
	});
});
