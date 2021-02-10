// Eagle Theme Scripts

$(document).ready(function() {
	$wideWidth = $(".SidebarLeftContainer").css("display") == "block";
	$desktopWidth = ($(".SidebarLeftContainer").css("display") == "none" && $(".SidebarRightContainer").css("display") == "block");
	$tabletWidth = ($(".SidebarRightContainer").css("display") == "none" && $(".sign-in-button").css("display") == "block");
	$tabletWidth_ff = ($(".SidebarRightContainer").css("display") == "none" && $(".sign-in-button").css("display") == "list-item");
	$mobileWidth = $(".sign-in-button").css("display") == "none";
	
	// Modification for Firefox browsers
	if ($tabletWidth || $tabletWidth_ff) {
		$tabletWidth = true;	
	}
	
	$(window).resize(function() {	
		$wideWidth = $(".SidebarLeftContainer").css("display") == "block";
		$desktopWidth = ($(".SidebarLeftContainer").css("display") == "none" && $(".SidebarRightContainer").css("display") == "block");
		$tabletWidth = ($(".SidebarRightContainer").css("display") == "none" && $(".sign-in-button").css("display") == "block");
		$tabletWidth_ff = ($(".SidebarRightContainer").css("display") == "none" && $(".sign-in-button").css("display") == "list-item");
		$mobileWidth = $(".sign-in-button").css("display") == "none";
		
		// Modification for Firefox browsers
		if ($tabletWidth || $tabletWidth_ff) {
			$tabletWidth = true;	
		}
	});
	
	// Determine page type
	if ($("div").hasClass("LandingPageWrapper")) {
		$("body").addClass("landing-page");
	}
});

$(document).ready(function() {
	// Setup menu layout and functionality
	if ($mobileWidth) {
		$(".MenuContainer").css("height", window.innerHeight);
	} else {
		$documentHeight = $(document).height();
		$(".MenuContainer").css("height", $documentHeight);
	}
	
	$(window).resize(function() {
		if ($mobileWidth) {
			$(".MenuContainer").css("height", window.innerHeight);
		} else {
			$documentHeight = $(document).height();
			$(".MenuContainer").css("height", $documentHeight);
		}
	});
	
	$(".header-content").on("click", "li.menu-button", function(e) {
		$(".MenuContainer").css("left", "0");
		if ($mobileWidth == false) {
			$(".MainContainer").css("left", "200");
		}
		$(".cover-container").css("display", "block");
		$(".MainContainer").css("opacity", "0.65");
		 
		e.preventDefault();
	});
	
	$(".menu-close").click(function(e) {
		$(".MenuContainer").css("left", "-200");
		$(".MainContainer").css("left", "0");
		$(".MainContainer").css("opacity", "1");
		$(".cover-container").css("display", "none");
		
		e.preventDefault();
	});
	
	// Switch to menu rollover button on hover
	if (($wideWidth) || ($desktopWidth)) {
		$(".menu-button").mouseenter(function(e) {
			$(".menu-button").css("background-color", "#fff");
			$(".menu-button .menu").css("display", "none");
			$(".menu-button .menu-rollover").css("display", "block");
		});
		
		$(".menu-button").mouseleave(function(e) {
			$(".menu-button").css("background-color", "#fc4349");
			$(".menu-button .menu").css("display", "block");
			$(".menu-button .menu-rollover").css("display", "none");
		});
	}
	
	// Activate leaderboard JQuery UI feature
	$(function() { 
		$("#LeaderboardContainer").tabs(); 
	});
		
	// Set width of story list container
	$storyListWidth = $(window).width() - 330; // Twitter widget and padding
	$(".list-content .story-list").css("width", $storyListWidth);
	
	$(window).resize(function() {
		$storyListWidth = $(window).width() - 330; // Twitter widget and padding
		$(".list-content .story-list").css("width", $storyListWidth);
	});
	
	// Set width of youtube container
	$ytWidth = $(window).width() - 20; // Margin
	$(".youtube-container").css("width", $ytWidth);
	
	$(window).resize(function() {
		$ytWidth = $(window).width() - 20; // Margin
		$(".youtube-container").css("width", $ytWidth);
	});
});

// Adjust width of Story Container
$(window).bind("load", function() {
	if ($mobileWidth) {
		$storyWidth = $(window).width() - 20;
	} else if ($tabletWidth) {
		$storyWidth = "auto";
	} else if ($desktopWidth) {
		$storyWidth = $(window).width() - 330;
	} else {
		$storyWidth = $(window).width() - 252 - 320;
	}
	
	$(".StoryContainer").css("width", $storyWidth);
	$(".StoryContainer").css("display", "block");
	$(".featured-image img").css("display", "block");
});

$(window).resize(function() {
	if (($tabletWidth) || ($mobileWidth)) {
		$storyWidth = $(window).width() - 20;
	} else if ($desktopWidth) {
		$storyWidth = $(window).width() - 330;
	} else {
		$storyWidth = $(window).width() - 252 - 320;
	}
	
	$(".StoryContainer").css("width", $storyWidth);
});

// Set heights of lead story containers
$(window).bind("load", function() {
	if (($wideWidth) || ($desktopWidth)) {
		$leadStoryHeight = (1038 - $(".FeaturedStoryContainer").height() - 40) / 4;
		$(".lead-story").css("height", $leadStoryHeight);
		$(".lead-story-image img").css("height", $leadStoryHeight);
	}
	$(".LeadStoriesContainer").css("display", "block");
});

$(window).resize(function() {
	if (($wideWidth) || ($desktopWidth)) {
		$leadStoryHeight = (1038 - $(".FeaturedStoryContainer").height() - 40) / 4;
		$(".lead-story").css("height", $leadStoryHeight);
		$(".lead-story-image img").css("height", $leadStoryHeight);
	}
});
