jQuery(document).ready(function($) {

	$("#menu-mobile-navigation").before('<div id="mobile-menu-icon"></div>');
	$("#mobile-menu-icon").click(function() {
		$(".menu-mobile").slideToggle();
	});

	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$(".menu-mobile").removeAttr("style");
		}
	});
	
	$("#menu-header-navigation").before('<div id="header-menu-icon"></div><div class="header-menu-arrow"></div>');
	$("#header-menu-icon").click(function() {
		$("#header-menu-icon").toggleClass("active");
		$("#menu-header-navigation").slideToggle(0);
		$(".header-menu-arrow").slideToggle(0);
	});
	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$("#menu-header-navigation").removeAttr("style");
		}
	});
	
	$("#menu-primary-navigation").before('<div id="primary-menu-icon"></div>');
	$("#primary-menu-icon").click(function() {
		$("#primary-menu-icon").toggleClass("active");
		$(".menu-primary").slideToggle();
	});
	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$(".menu-primary").removeAttr("style");
		}
	});
	
	$("#menu-secondary-navigation").before('<div id="secondary-menu-icon"></div>');
	$("#secondary-menu-icon").click(function() {
		$("#secondary-menu-icon").toggleClass("active");
			$(".menu-secondary").slideToggle();
	});
	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$(".menu-secondary").removeAttr("style");
		}
	});
	
});