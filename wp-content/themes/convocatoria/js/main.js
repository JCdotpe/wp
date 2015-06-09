/**
 * main3.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */

 $( document ).ready(function() {
 	contentHeader = document.querySelector( '.site-header' );
 	contentAds = document.querySelector( '.header-ads' );

	contentHeader.addEventListener( 'click', function(ev) {
		var target = ev.target;
		if ($('body').hasClass('open-iframe')) {
			close_menu();
		}
	});


	contentAds.addEventListener( 'click', function(ev) {
		var target = ev.target;
		if ($('body').hasClass('open-iframe')) {
			close_menu();
		}
	});


});

function close_menu(){

	$('body').removeClass('open-iframe');
	var bodyEl = document.body;
	$("#iframe-ajax-load").attr("src", "");
	classie.remove( bodyEl, 'show-menu' );
	setTimeout( function() {
		path.attr( 'd', initialPath );
		isAnimating = false; 
	}, 300 );

}


function iframe_load(id_button){

	var bodyEl = document.body;
	morphEl = document.getElementById( 'morph-shape' );
	s = Snap( morphEl.querySelector( 'svg' ) );
	path = s.select( 'path' );
	pathOpen = morphEl.getAttribute( 'data-morph-open' );
	initialPath = this.path.attr('d');

	iframe_src = $("#"+id_button+"").val();
	$("#iframe-ajax-load").attr("src", iframe_src);
	classie.add( bodyEl, 'show-menu' );
	path.animate( { 'path' : pathOpen }, 400, mina.easeinout, function() { isAnimating = false; } );
	$('body').addClass('open-iframe');

}
 

(function($) { $(document).ready( function() { $('.navbar-header').on('click','button',function(e) { e.preventDefault(); var menuName = $(this).data('target'); 

	$(menuName).slideToggle(); }); var menuName = $('.navbar-header button').data('target'); $(menuName).slideUp(); }); })(jQuery); 
 

//

/*

$('#navigation li:eq(0)').before('<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-03" id="menu-item-03" style="padding-top: 15px"><div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/u/0/100436791050344137563" data-rel="publisher"></div></li>');

$('#navigation li:eq(0)').before('<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-02" id="menu-item-02"><iframe src="//platform.twitter.com/widgets/follow_button.html?screen_name=convocatoriaPE&lang=es" style="width: 250px; height: 20px; position: relative; top: 15px" allowtransparency="true" frameborder="0" scrolling="no"> </iframe></li>');

$('#navigation li:eq(0)').before('<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-01" id="menu-item-01"><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fconvocatoria.pe&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21&amp;appId=1521980168075345" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width: 120px; position: relative; top: 15px" allowTransparency="true"></iframe></li>');

*/