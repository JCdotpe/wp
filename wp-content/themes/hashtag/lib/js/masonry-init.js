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


jQuery(document).ready(function() {

    jQuery('.entry-content p').each(function() {
        var $this = jQuery(this);
        if($this.html().replace(/\s|&nbsp;/g, '').length == 0) {
            $this.remove();
        }
        else{
        	$this.addClass("excerpt-p");
        }
    });

});


jQuery(document).scroll(function(e){
    
    jQuery('.entry-content p').each(function() {
        var $this = jQuery(this);
        if($this.html().replace(/\s|&nbsp;/g, '').length == 0) {
            $this.remove();
        }
        else{
        	$this.addClass("excerpt-p");
        }
    });

});