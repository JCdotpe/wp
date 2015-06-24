
 $( document ).ready(function() {

 	contentHeader = document.querySelector( '.site-header' );
 	contentAds = document.querySelector( '.leader-lu' );

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
	$('body').removeClass('show-menu');
	$('body').removeClass('open-iframe');
}


function iframe_load(id_button){
	window.scrollTo(0, 0);
	var bodyEl = document.body;
	iframe_src = $("#"+id_button+"").val();
	$("#iframe-ajax-load").attr("src", iframe_src);

	$('body').addClass('show-menu');
	$('body').addClass('open-iframe');

}
 

/*

(function($) { $(document).ready( function() { $('.navbar-header').on('click','button',function(e) { e.preventDefault(); var menuName = $(this).data('target'); 

	$(menuName).slideToggle(); }); var menuName = $('.navbar-header button').data('target'); $(menuName).slideUp(); }); })(jQuery); 
 

//



$('#navigation li:eq(0)').before('<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-03" id="menu-item-03" style="padding-top: 15px"><div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/u/0/100436791050344137563" data-rel="publisher"></div></li>');

$('#navigation li:eq(0)').before('<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-02" id="menu-item-02"><iframe src="//platform.twitter.com/widgets/follow_button.html?screen_name=convocatoriaPE&lang=es" style="width: 250px; height: 20px; position: relative; top: 15px" allowtransparency="true" frameborder="0" scrolling="no"> </iframe></li>');

$('#navigation li:eq(0)').before('<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-01" id="menu-item-01"><iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fconvocatoria.pe&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21&amp;appId=1521980168075345" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width: 120px; position: relative; top: 15px" allowTransparency="true"></iframe></li>');

*/


$( ".sidebar .widget_tag_cloud h4" ).prepend( '<i class="fa fa-tags"></i> ' );

// $( ".genesis-nav-menu .menu-item.menu-item-has-children a" ).html( '<i class="fa fa-th"></i> ' );

$( ".genesis-nav-menu .menu-item-has-children a" ).first().html( '<i class="fa fa-th"></i> ' );
$( ".genesis-nav-menu .menu-item-has-children" ).first().addClass( 'menu-convocatorias' );

$( ".genesis-nav-menu .menu-item" ).last().addClass( 'menu-user' );


$( ".genesis-nav-menu .menu-item-has-children .sub-menu li:nth-child(1) a" ).addClass( 'inei' );
$( ".genesis-nav-menu .menu-item-has-children .sub-menu li:nth-child(2) a" ).addClass( 'sunat' );
$( ".genesis-nav-menu .menu-item-has-children .sub-menu li:nth-child(3) a" ).addClass( 'onpe' );
$( ".genesis-nav-menu .menu-item-has-children .sub-menu li:nth-child(4) a" ).addClass( 'jne' );
$( ".genesis-nav-menu .menu-item-has-children .sub-menu li:nth-child(5) a" ).addClass( 'juntos' );
$( ".genesis-nav-menu .menu-item-has-children .sub-menu li:nth-child(6) a" ).addClass( 'reniec' );
$( ".genesis-nav-menu .menu-item-has-children .sub-menu li:nth-child(7) a" ).addClass( 'more' );
