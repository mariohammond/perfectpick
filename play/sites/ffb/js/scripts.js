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
	
	// Add new player
	addNewPlayer();
});

function addNewFormation() {
	var formation = $("#playFormation").val();
	if (formation == "formation-other") $("#newFormation").show();
	else $("#newFormation").hide();
}

function getPlayType() {
	var playType = $("#playType").val();
	if (playType == "type-run") {
		$("#passInfo").hide();
		$("#runInfo").show();
	}
	if (playType == "type-pass") {
		$("#runInfo").hide();
		$("#passInfo").show();
	}
}

function addNewPlayer() {
	$(".add-player").click(function(e) {
        var playerInfo = $("#playerInfo .player").last();
		playerInfo.clone().appendTo("#playerInfo");
		$(this).hide();
		addNewPlayer();
    });
}
