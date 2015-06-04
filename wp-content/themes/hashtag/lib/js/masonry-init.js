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
        	$this.addClass("read-more");
        }
    });


    jQuery('.entry-content').each(function() {
    	var $this = jQuery(this);

    	if($this.find("h1.entry-title").length) {

    	}
    	else{
    		$this.find("p").removeClass("read-more");
    	}


	});
    	

});