jQuery(function($) {
    var $container = $('.content');
 
    $container.imagesLoaded( function(){
        $container.masonry({
			gutterWidth: 14,
            isFitWidth: true,
			itemSelector: '.entry',
        });
    });
});