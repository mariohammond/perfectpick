// Google Analytics Tracking

// Header Bar
$(document).on("click", ".HeaderContainer a", function(e) {
	var action, label;
	if ($(this).data("action")) action = $(this).data("action");
	if ($(this).data("label")) label = $(this).data("label");
	ga('send', 'event', 'pp_header', action, label);
});

// Menu Container
$(document).on("click", ".MenuContainer a", function(e) {
	var action, label;
	if ($(this).data("action")) action = $(this).data("action");
	if ($(this).data("label")) label = $(this).data("label");
	ga('send', 'event', 'pp_menu', action, label);
});

// Featured Story (Home Page)
$(document).on("click", ".FeaturedStoryContainer a", function(e) {
	var action, label;
	if ($(this).data("action")) action = $(this).data("action");
	if ($(this).data("label")) label = $(this).data("label");
	ga('send', 'event', 'pp_home_article', action, label);
});

// Lead Stories (Home Page)
$(document).on("click", ".LeadStoriesContainer a", function(e) {
	var action, label;
	if ($(this).data("action")) action = $(this).data("action");
	if ($(this).data("label")) label = $(this).data("label");
	ga('send', 'event', 'pp_home_article', action, label);
});

// AddThis Buttons (Home Page)
$(document).on("click", ".HomeWrapper .at-share-btn", function(e) {
	var label = $("span", this).attr("title").toLowerCase();
	ga('send', 'event', 'pp_sharing', 'home_page', label);
});

// AddThis Buttons (Landing Page)
$(document).on("click", ".LandingPageWrapper .at-share-btn", function(e) {
	var label = $("span", this).attr("title").toLowerCase();
	ga('send', 'event', 'pp_sharing', 'landing_page', label);
});

// AddThis Buttons (Article Page)
$(document).on("click", ".addthis-smartlayers .at4-share-btn", function(e) {
	var label = $("span", this).attr("title").toLowerCase();
	ga('send', 'event', 'pp_sharing', 'article_page', label);
});

// Story List (Home Page)
$(document).on("click", ".story-list a", function(e) {
	var action, label;
	if ($(this).data("action")) action = $(this).data("action");
	if ($(this).data("label")) label = $(this).data("label");
	ga('send', 'event', 'pp_home_article', action, label);
});

// Leaderboard Container (Home Page)
$(document).on("click", "#LeaderboardContainer a", function(e) {
	var label;
	if ($(this).data("label")) label = $(this).data("label");
	ga('send', 'event', 'pp_widget', 'leaderboard', label);
});

// Next Match Widget
$(document).on("click", ".GameBlockContainer a", function(e) {
	var action;
	if ($(this).data("action")) action = $(this).data("action");
	ga('send', 'event', 'pp_widget', action);
});

// YouTube Channel Widget
$(document).on("click", ".youtube-container a", function(e) {
	var action;
	if ($(this).data("action")) action = $(this).data("action");
	ga('send', 'event', 'pp_widget', action);
});

// Footer Links
$(document).on("click", ".FooterContainer a", function(e) {
	var action;
	if ($(this).data("action")) action = $(this).data("action");
	ga('send', 'event', 'pp_footer', action);
	alert(action);
});

// Story List (Landing Page)
$(document).on("click", ".category-list a", function(e) {
	var action, label;
	if ($(this).data("action")) action = $(this).data("action");
	if ($(this).data("label")) label = $(this).data("label");
	ga('send', 'event', 'pp_landing_article', action, label);
});

// Related Stories (Article Page)
$(document).on("click", ".related-stories a", function(e) {
	var label;
	if ($(this).data("label")) label = $(this).data("label");
	ga('send', 'event', 'pp_article', 'related_stories', label);
});
