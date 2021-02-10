// Eagle Theme Scripts

$(document).ready(function() {
	$wideWidth = $(".wideCheck").css("display") == "block";
	$desktopWidth = $(".desktopCheck").css("display") == "block";
	$tabletWidth = $(".tabletCheck").css("display") == "block";
	$mobileWidth = $(".mobileCheck").css("display") == "block";
	
	$currentWidth = "wide";
	if ($desktopWidth)	$currentWidth = "desktop";
	if ($tabletWidth)	$currentWidth = "tablet";
	if ($mobileWidth)	$currentWidth = "mobile";
	
	$(window).resize(function() {	
		$wideWidth = $(".wideCheck").css("display") == "block";
		$desktopWidth = $(".desktopCheck").css("display") == "block";
		$tabletWidth = $(".tabletCheck").css("display") == "block";
		$mobileWidth = $(".mobileCheck").css("display") == "block";
		
		$currentWidth = "wide";
		if ($desktopWidth)	$currentWidth = "desktop";
		if ($tabletWidth)	$currentWidth = "tablet";
		if ($mobileWidth)	$currentWidth = "mobile";
	});
});

$(document).ready(function() {
	// Setup menu layout and functionality
	if ($mobileWidth) {
		$(".MenuContainer").css("height", window.innerHeight + 100);
	} else {
		$(".MenuContainer").css("height", $(document).height());
	}
	
	$(window).resize(function() {
		if ($mobileWidth) {
			$(".MenuContainer").css("height", window.innerHeight + 100);
		} else {
			$(".MenuContainer").css("height", $(document).height());
		}
	});
	
	$(".header-content").on("click", "li.menu-button", function(e) {
		$(".MenuContainer").css("left", "0");
		$(".cover-container").css("display", "block");
		$(".MainContainer").css("opacity", "0.65");
		 
		e.preventDefault();
	});
	
	$(".menu-close").click(function(e) {
		$(".MenuContainer").css("left", "-200");
		$(".MainContainer").css("opacity", "1");
		$(".cover-container").css("display", "none");
		
		e.preventDefault();
	});
	
	$(".menu-chevron.more").click(function(e) {
		if ($(this).hasClass("news")) {
			$(".menu-chevron.news.more").hide();
			$(".menu-chevron.news.less").show();
			$(".sub-menu.news").slideDown();
		} else {
			$(".menu-chevron.play.more").hide();
			$(".menu-chevron.play.less").show();
			$(".sub-menu.play").slideDown();
		}
		e.preventDefault();
	});
	
	$(".menu-chevron.less").click(function(e) {
		if ($(this).hasClass("news")) {
			$(".menu-chevron.news.less").hide();
			$(".menu-chevron.news.more").show();
			$(".sub-menu.news").slideUp();
		} else {
			$(".menu-chevron.play.less").hide();
			$(".menu-chevron.play.more").show();
			$(".sub-menu.play").slideUp();
		}
		e.preventDefault();
	});
	
	// Set footer ad
	if ($("#page-home").length > 0) {
		$(".footer.ad.leaderboard").addClass("home");
	}
	
	$(window).load(function(){
		// Setup Cover Container
		$contentHeight = $(".MainContainer").height();
		$(".cover-container").css("height", $contentHeight);
		$(".cover-container").click(function(e) {
			$(".MenuContainer").css("left", "-200");
			$(".MainContainer").css("opacity", "1");
			$(".cover-container").css("display", "none");
			
			e.preventDefault();
		});
		
		// Setup Footer Container
		$windowHeight = $(window).height();
		$docHeight = $(document).height();
		$mainHeight = $(".MainContainer").height();
		
		if ($mainHeight < $windowHeight - 45) {
			$(".FooterContainer").css("top", $windowHeight - $mainHeight - 60 - 45);
		}
		$(".FooterContainer").show();
	});
	
	// Load More Feature
	var groupCount = 1;
	var groupSize = $(".category-list-group").size();
	
	$(".category-list-group:lt(" + groupCount + ")").show();
	
	$(".load-more a").click(function () {
		groupCount++;
		$(".category-list-group:lt(" + groupCount + ")").show();
		
		if (groupCount == groupSize){
			$(".load-more").hide();
		}
	});
	
	// Newsletter Signup
	$(".newsletter-submit").click(function(e) {
		var email = $(".newsletter-email").val();
		var atpos = email.indexOf("@");
		var dotpos = email.lastIndexOf(".");
		if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
			$("#newsletter-body").html("<strong>Signup Error:</strong><br/>Please enter a valid<br/>email address.");
		} else {
			$.ajax({
				type: "POST",
				url: "http://www.perfectpickem.com/wp-content/themes/eagle/util/add_email.php?email=" + email,
				datatype: "html",
				success: function(data) {
					document.getElementById('newsletter-body').innerHTML = data;
				},
			});
		}
		$(".newsletter-email").val("");
	});
	
	// Leaderboard Widget
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
	
	
	// Article Share Bar
	$(window).scroll(function() {
		var offset = $("#page-article .addthis-share").offset();
		if (offset != null) {
			if ($(window).scrollTop() > offset.top) {
				$(".HeaderContainer.article-share").slideDown(500).css({'display' : 'block'});
			} else {
				$(".HeaderContainer.article-share").slideUp(500);
			}
		}
	});
	
	// Adjust embedded YouTube widget
	if ($mobileWidth) {
		if ($(".embed-youtube").length > 0) {
			var embedWidth = $(".embed-youtube iframe").css("width");
			var ytWidth = parseInt(embedWidth.substr(0, embedWidth.length - 2));
			var ytHeight = ytWidth / 1.6;
			$(".embed-youtube iframe").css("height", ytHeight);
		}
	}
	
	$(window).resize(function() {
		if ($mobileWidth) {
			if ($(".embed-youtube").length > 0) {
				var embedWidth = $(".embed-youtube iframe").css("width");
				var ytWidth = parseInt(embedWidth.substr(0, embedWidth.length - 2));
				var ytHeight = ytWidth / 1.6;
				$(".embed-youtube iframe").css("height", ytHeight);
			}
		} else {
			$(".embed-youtube iframe").css("height", 390);
		}
	});
	
	// Social scripts
	$("body").on("click", ".social-icon.facebook-share", function(e) {
		e.preventDefault();
		return false;
	});
	
	// Google Analytics Event Tracking
	$(document).on("click", "a", function(e) {
		var category, action, label;
		if ($(this).data("category")) {
			category = $(this).data("category") + "-" + $currentWidth;
		}
		if ($(this).data("action")) {
			action = $(this).data("action");
		}
		if ($(this).data("label")) {
			label = $(this).data("label");
		}
		if ($(this).parents(".article-content").length > 0) {
			category = "pp-article" 	+ "-" + $currentWidth;
			action = "article-body";
			label = "link";
		}
		if ($(this).parents(".topics").length > 0) {
			category = "pp-article" 	+ "-" + $currentWidth;
			action = "article-body";
			label = "topic";
		}
		ga("send", "event", category, action, label);
	});
});
