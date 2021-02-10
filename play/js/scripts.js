// Play Theme Scripts

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
		$documentHeight = $(document).height();
		$(".MenuContainer").css("height", $documentHeight);
	}
	
	$(window).resize(function() {
		if ($mobileWidth) {
			$(".MenuContainer").css("height", window.innerHeight + 100);
		} else {
			$documentHeight = $(document).height();
			$(".MenuContainer").css("height", $documentHeight);
		}
	});
	
	$(".header-content").on("click", "li.menu-button", function(e) {
		$(".MenuContainer").css("left", "0");
		$(".cover-container").css("display", "block");
		$(".Main").css("opacity", "0.65");
		 
		e.preventDefault();
	});
	
	$(".menu-close").click(function(e) {
		$(".MenuContainer").css("left", "-200");
		$(".Main").css("opacity", "1");
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
	
	$(".cover-container").click(function(e) {
		$(".MenuContainer").css("left", "-200");
		$(".Main").css("opacity", "1");
		$(".cover-container").css("display", "none");
		
		e.preventDefault();
	});
	
	$("#modal_trigger_menu").click(function(e) {
		$(".MenuContainer").css("left", "-200");
		$(".Main").css("opacity", "1");
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
	
	// Setup footer position
	$(".content").css("min-height", $(window).height() - 100);
	if ($mobileWidth) {
		$(".Main").css("min-height", $(window).height() - 100);
	} else {
		$(".Main").css("min-height", $(window).height() - 130);
	}
	
	// Splash Page - Mobile footer fix
	if ($("#page-home").length > 0) {
		$(".FooterContainer").css("top", 0);
		$(".content").css("min-height", 100);
	}
	// View Questions Page - Mobile footer fix
	$(".ViewPicksContainer.Main").css("min-height", "auto");
	
	// Match start button
	$(".start-button").click(function(e) {
		// Slide panel
		$(".MatchQuestions").hide();
		$(".MatchQuestions").css("left", -320);
		$(".MatchQuestions").show();
		
		// Make match title visible
		$(".MatchTitle h1, .MatchTitle h2").css("display", "block");
		
		// Adjust height of Match Questions container
		$parentId = $(this).closest(".QuestionContent").attr("id"); 
		$idNumber = parseInt($parentId.substring(1)) + 1;
		$nextId = "q" + $idNumber;
		
		$currentDiv = document.getElementById($nextId);
		$children = $currentDiv.childNodes; 
		
		$questionHeight = 0;
		$optionHeight = 0;
		
		for (i = 0; i < $children.length; i++) {
			if ($children[i].className == "question") {
				$questionHeight += $children[i].clientHeight + 20;
			}
			
			if ($children[i].className == "answer-choice" || $children[i].className == "answer-choice selected") {
				$optionHeight += $children[i].clientHeight + 20;
			}
			
			if ($children[i].className == "tiebreaker-answer") {
				$optionHeight += $children[i].clientHeight + 20;
			}
		}
		
		$(".MatchQuestions").css("height", $optionHeight + $questionHeight + 98);
	});
	
	// Match filter buttons
	$(".sports-filter, .type-filter").click(function(e) {
		$sport = "";
		$type = "";
		
		if ($(this).hasClass("sports-filter")) {
			$(".sports-filter p").removeClass("selected-filter"); // Remove styling from all buttons
			$(this).find('p').addClass("selected-filter"); // Add styling to clicked button
			
			$sport = $(this).find('p').text(); // Store button text as parameter
			
			$(".type-filter").each(function(index) {
				if ($(this).find('p').hasClass("selected-filter")) { // Check if button from other group is clicked
					$type = $(this).find('p').text(); // Store button text as parameter
				}
			});
		}
		
		if ($(this).hasClass("type-filter")) {
			$(".type-filter p").removeClass("selected-filter");
			$(this).find('p').addClass("selected-filter");
			
			$type = $(this).find('p').text();
			
			$(".sports-filter").each(function(index) {
				if ($(this).find('p').hasClass("selected-filter")) {
					$sport = $(this).find('p').text();
				}
			});
		}
		
		$.ajax({
			type: "POST",
			url: "util/filter_match.php?sport=" + $sport + "&type=" + $type,
			datatype: "html",
			success: function(data) {
				document.getElementById('allMatches').innerHTML = data;
				if ($mobileWidth || $tabletWidth) {
					$("html, body").animate({ scrollTop: 0 }, "slow");
					return false;
				}
			},
		});
	});
	
	$(".clear-filter").click(function(e) {
		$(".sports-filter p").removeClass("selected-filter");
		$(".type-filter p").removeClass("selected-filter");
		
		$.ajax({
			type: "POST",
			url: "util/filter_match.php",
			datatype: "html",
			success: function(data) {
				document.getElementById('allMatches').innerHTML = data;
				if ($mobileWidth || $tabletWidth) {
					$("html, body").animate({ scrollTop: 0 }, "slow");
					return false;
				}
			},
		});
	});
	
	// Option answer functions
	$(".answer").click(function(e) {
		$questionId = $(this).closest(".QuestionContent").attr("id");
		
		// Revert all options back to default color
		$currentQuestion = document.getElementById($questionId);
		$questionChildren = $currentQuestion.childNodes;
		
		for (i = 0; i < $questionChildren.length; i++) {
			if ($questionChildren[i].className == "answer-choice") {
				$questionChildren[i].style.backgroundColor = "#2c3e50";
			}
		}
		
		// Add class to slider nav dot
		$idNumber = $questionId.substr(1);
		$("#slide" + $idNumber + " p").addClass("answered");
		
		// Change selected option to green
		$answerDiv = $(this).closest(".answer-choice");
		$answerDiv.css("background-color", "#00a550");
		
		// Submit answer to form
		$selectedAnswer = $(this).text();
		$('[name=' + $questionId + ']').val($selectedAnswer);
	});
	
	// Leaderboard filter buttons
	$(".time-frame a").click(function(e) {
		$time = $(this).text();
		$.ajax({
			type: "POST",
			url: "util/filter_leaderboard.php?time=" + $time,
			datatype: "html",
			success: function(data) {
				document.getElementById('leaderboard-content').innerHTML = data;
			},
		});
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
				url: "http://play.perfectpickem.com/util/add_email.php?email=" + email,
				datatype: "html",
				success: function(data) {
					document.getElementById('newsletter-body').innerHTML = data;
				},
			});
		}
		$(".newsletter-email").val("");
	});
	
	// Detect IE browser
	if (navigator.userAgent.match(/msie/i) || navigator.userAgent.match(/trident/i)) {
		var bodyWidth = $("body").css("width");
		bodyWidth = parseInt(bodyWidth.replace("px", ""));
		
		if (bodyWidth >= 600) {
			$(".liquid-slider .ls-panel").css("width", 600);
		} else {
			$(".liquid-slider .ls-panel").css("width", bodyWidth);
		}
	}
	
	// Home Page Mobile Images
	if ($currentWidth == "mobile") {
		var browserWidth = $(window).width();
		$("#page-home #region-1 img").css("width", browserWidth - 20);
		$("#page-home #region-2 img").css("width", browserWidth - 20);
	}
	$(window).resize(function() {
		if ($currentWidth == "mobile") {
			var browserWidth = $(window).width();
			$("#page-home #region-1 img").css("width", browserWidth - 20);
			$("#page-home #region-2 img").css("width", browserWidth - 20);
		}
	});
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
	ga("send", "event", category, action, label);
});
