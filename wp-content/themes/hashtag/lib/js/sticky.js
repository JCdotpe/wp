jQuery(document).ready(function($){
	if ($(window).width() > 768){
	
		$(window).scroll( function() {
			if ($(window).scrollTop() > $('.site-header').offset().top)
				$('.site-header .wrap').addClass('sticky');
			else
				$('.site-header .wrap').removeClass('sticky');
		} );
		
		$(window).scroll( function() {
			if ($(window).scrollTop() > $('.site-header').offset().top)
				$('.nav-primary .wrap').addClass('sticky');
			else
				$('.nav-primary .wrap').removeClass('sticky');
		} );
		
		$(window).scroll( function() {
			if ($(window).scrollTop() > $('.site-header').offset().top)
				$('.nav-secondary .wrap').addClass('sticky');
			else
				$('.nav-secondary .wrap').removeClass('sticky');
		} );
				
		$(window).scroll( function() {
			if ($(window).scrollTop() > $('.site-header').offset().top)
				$('.site-inner').addClass('sticky');
			else
				$('.site-inner').removeClass('sticky');
		} );
			
	}
	
	$(window).scroll( function() {
		if ($(window).scrollTop() > $('.content').offset().top)
			$('.return-to-top').addClass('sticky');
		else
			$('.return-to-top').removeClass('sticky');
	} );
	
	// Add smooth scroll for .return-to-top link
	$('.return-to-top').on('click', function(){
		$('html, body').animate({scrollTop:0}, 'slow');
		return false;
	});

} );