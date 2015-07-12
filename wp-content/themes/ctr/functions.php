<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

require_once(TEMPLATEPATH.'/lib/init.php');
require_once(STYLESHEETPATH.'/lib/init.php');

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'CTR Genesis Theme' );
define( 'CHILD_THEME_URL', 'http://jc.pe' );
define( 'CHILD_THEME_VERSION', '1.0' );

/* # Custom Documment Settings
---------------------------------------------------------------------------------------------------- */

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

// Remove jQuery
add_action('wp_enqueue_scripts', 'crunchify_script_remove_header');
function crunchify_script_remove_header() {
      wp_deregister_script( 'jquery' );
      wp_deregister_script( 'comment-reply' );
}

// Load js files
add_action('genesis_after_footer', 'crunchify_script_add_body');
function crunchify_script_add_body() {
      wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js' );
      wp_register_script( 'main', CHILD_URL .'/js/main.js' );

      wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array( 'jquery' ), '1.11.1', false );
      wp_enqueue_script( 'main', CHILD_URL .'/js/main.js' );
}

// Add font awesome css
add_action( 'wp_enqueue_scripts', 'font_awesome_style_sheet' );
function font_awesome_style_sheet() {
	wp_enqueue_style( 'font-awesome-stylesheet', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), PARENT_THEME_VERSION );
}

// Remove Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );



//
add_filter( 'genesis_header', 'custom_search' );
function custom_search() {
	echo '

<aside class="header-search">
	<section id="header-search-custom" class="widget widget_search">
		<div class="widget-wrap">
			<form method="get" class="search-form" action="http://www.convocatoria.pe/" role="search">
				<input class="search" name="s" placeholder="Buscar convocatorias por institución pública, área, profesión, salario ..." type="search">
				<button class="submit" type="submit"><i class="fa fa-search"></i></button>
				<input value="Search" type="submit">
			</form>
		</div>
	</section>
</aside>

	';
}	

//
add_filter( 'genesis_header', 'custom_media' );
function custom_media() {
	echo '<div class="custom-media">
		  	<ul>
		  		<li><a class="media-facebook" href="https://www.facebook.com/convocatoria.pe" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
		  		<li><a class="media-twitter" href="https://twitter.com/convocatoriape" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
		  		<li><a class="media-gplus" href="https://plus.google.com/+convocatoriape/" rel="nofollow"><i class="fa fa-google-plus"></i></a></li>
		  	</ul>
	</div>
	';
}	

//
// add_filter( 'genesis_header', 'custom_nav' );
function custom_nav() {
echo '
<aside class="widget-area header-widget-area header-user">
	<section id="nav-user" class="widget nav-user">
		<div class="widget-wrap">
			<nav class="nav-header" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
				<ul class="menu genesis-nav-menu">
					

<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-convocatorias">
	<a href="#"><i class="fa fa-th"></i></a>
	<ul class="sub-menu">
		<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#">INEI</a></li>
		<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#">SUNAT</a></li>
		<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#">RENIEC</a></li>
		<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#">MINEDU</a></li>
		<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#">SUNAT</a></li>
		<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#">JUNTOS</a></li>
		<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#">JNE</a></li>
		<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children"><a href="#">ONPE</a></li>
	</ul>
</li>
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-user"><a class="user-login" title="aa" href="#">Iniciar Sesión</a></li>
				</ul>
			</nav>
		</div>
	</section>
</aside>

';
}

/* # Content Area
---------------------------------------------------------------------------------------------------- */


// Load iframe convocatorias
add_action('genesis_after_header', 'iframe_load');
function iframe_load() {

      echo '
      <div class="iframe-load">
			<div class="menu-wrap">
				<iframe id="iframe-ajax-load" src="" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0" style="width: calc(100% - 80px); height: calc(100% - 0px); overflow: scroll"></iframe>
				<button class="close-button" id="close-button" onclick="close_menu()">Close Menu</button>
			</div>
      </div>';
}

// Custom post info
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = '<i class="fa fa-bullhorn"></i> [post_categories before=""] <i class="fa fa-clock-o"></i> [post_date"] [post_edit]';
	$post_info .= '<aside class="shares"><ul><li><a class="share-link share-facebook" href="http://www.facebook.com/sharer.php?u='.get_permalink().'" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i> Comparte en Facebook</a></li>
						<li><a class="share-link share-twitter" href="https://twitter.com/share?url='.get_permalink().'&text='.get_the_title().'" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i> Comparte en Twitter</a></li>
						<li><a class="share-link share-google" href="https://plus.google.com/share?url='.get_permalink().'" rel="nofollow" target="_blank"><i class="fa fa-google-plus"></i> Comparte en Google+</a></li>
						<li><a class="share-link share-linkedin" href="http://www.linkedin.com/shareArticle?url='.get_permalink().'&title='.get_the_title().'" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i> Comparte en Linkedin</a></li>
					</ul></aside>';
	return $post_info;
}}

// Breadcrumbs You are Here
add_filter( 'genesis_breadcrumb_args', 'b3m_prefix_breadcrumb' );
function b3m_prefix_breadcrumb( $args ) {
  $args['labels']['prefix'] = '';
  return $args;
}

// Breadcrumbs Home
add_filter( 'genesis_breadcrumb_args', 'b3m_home_text_breadcrumb' );
function b3m_home_text_breadcrumb( $args ) {
  $args['home'] = 'Inicio';
  return $args;
}

// Breadcrumb Separator
add_filter( 'genesis_breadcrumb_args', 'b3m_change_separator_breadcrumb' );
function b3m_change_separator_breadcrumb( $args ) {
  $args['sep'] = ' » ';
  return $args;
}

// Custom post meta function
function be_post_meta_filter($post_meta) {
	$post_meta = '<i class="fa fa-bookmark"></i> [post_tags before="Tags: "]';
	return $post_meta;
}
add_filter('genesis_post_meta', 'be_post_meta_filter');

// Pagination text anterior
add_filter( 'genesis_prev_link_text', 'gt_review_prev_link_text' );
function gt_review_prev_link_text() {
        $prevlink = '&laquo; Anterior';
        return $prevlink;
}

// Pagination text siguiente
add_filter( 'genesis_next_link_text', 'gt_review_next_link_text' );
function gt_review_next_link_text() {
        $nextlink = 'Siguiente &raquo;';
        return $nextlink;
}

// Remove comment form
remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );

/* # Aside
---------------------------------------------------------------------------------------------------- */


// Subscribe Left
function subscribe_aside() {
	echo '
		<section id="subscribe-aside" class="widget widget_text subscribe-aside">
			<div class="widget-wrap">
				<h4 class="widgettitle"><i class="fa fa-envelope-o"></i> Recibir Ofertas Similares</h4>
				<div class="textwidget">
					<p>Suscríbete a nuestro boletín de correo electrónico para recibir ofertas de empleo y consejos útiles para potenciar tu carrera profesional. Enviamos todos los Martes.</p>
					<form action="//convocatoria.us11.list-manage.com/subscribe/post?u=814bba40d5cf620e6a3f88aa6&amp;id=fdc3714501" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					    <input name="EMAIL" type="text" placeholder="Ingresar correo electrónico">
					    <button class="submit" type="submit">Suscribirse</button>
					  </form>




				</div>
			</div>
		</section>

	';
}
add_filter('genesis_before_sidebar_widget_area', 'subscribe_aside');


// Display related posts in Genesis based on Category
function related_posts_categories() {
if ( is_single ( ) ) {
global $post;
$count = 0;
$postIDs = array( $post->ID );
$related = '';
$cats = wp_get_post_categories( $post->ID );
$catIDs = array( );{
foreach ( $cats as $cat ) {
$catIDs[] = $cat;
}
$args = array(
'category__in' => $catIDs,
'post__not_in' => $postIDs,
'showposts' => 10,
'ignore_sticky_posts' => 1,
'orderby' => 'rand',
'tax_query' => array(
array(
'taxonomy' => 'post_format',
'field' => 'slug',
'terms' => array(
'post-format-link',
'post-format-status',
'post-format-aside',
'post-format-quote' ),
'operator' => 'NOT IN'
)
)
);
$cat_query = new WP_Query( $args );
if ( $cat_query->have_posts() ) {
while ( $cat_query->have_posts() ) {
$cat_query->the_post();
$related .= '<li><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . get_the_title() . '</a></li>';
}
}
}
if ( $related ) {
	$category = get_the_category(); 
printf( '<section id="related-category-aside" class="widget widget_text related-category-aside">
		 	<div class="widget-wrap">
		 		<h4><i class="fa fa-link"></i> Convocatorias '.$category[0]->cat_name.'</h4>
		 		<div class="textwidget">
					<ul>%s</ul>
				</div>
		</section>', $related );
}
wp_reset_query();
}
}
add_action( 'genesis_after_sidebar_widget_area', 'related_posts_categories' );



// Display related posts in Genesis based on Tags
function related_posts_tags () {
if ( is_single ( ) ) {
global $post;
$count = 0;
$postIDs = array( $post->ID );
$related = '';
$tags = wp_get_post_tags( $post->ID );
foreach ( $tags as $tag ) {
$tagID[] = $tag->term_id;
}
$args = array(
'tag__in' => $tagID,
'post__not_in' => $postIDs,
'showposts' => 6,
'ignore_sticky_posts' => 1,
'tax_query' => array(
array(
'taxonomy' => 'post_format',
'field' => 'slug',
'terms' => array(
'post-format-link',
'post-format-status',
'post-format-aside',
'post-format-quote'
),
'operator' => 'NOT IN'
)
)
);
$tag_query = new WP_Query( $args );
if ( $tag_query->have_posts() ) {
while ( $tag_query->have_posts() ) {
$tag_query->the_post();
$related .= '<li><a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . get_the_title() . '</a></li>';
$postIDs[] = $post->ID;
$count++;
}
}
if ( $related ) {
printf( '<aside id="related-tags" class="related-tags">
		 	<h3>Convocatorias similares</h3>
		 	<ul>%s</ul>
		 </aside>', $related );
}
wp_reset_query();
}
}
add_action( 'genesis_entry_footer', 'related_posts_tags' );


/* # Footer
---------------------------------------------------------------------------------------------------- */

// Custom footer
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds one-half first">
			<p><b>Convocatoria.pe</b> es una plataforma para encontrar trabajo en el sector público del Perú. Utilice nuestro motor de búsqueda de convocatorias de personal para encontrar ofertas de empleos en entidades públicas, municipales y gubernamentales.</p>
		  </div>

		  <div class="one-half">
		  	<ul class="footer-nav">
		  		<li><a href="#">Terms</a></li>
		  		<li><a href="#">Privacidad</a></li>
		  		<li><a href="#">Suscribirse</a></li>
		  		<li><a href="#">Publicidad</a></li>
		  		<li><a href="#">Blog</a></li>
		  		<li><a href="#">Acerca de</a></li>
		  	</ul>

		  	<br class="clear" />

			<ul class="footer-social">
				<li><a href="#" rel="nofollow" target="_social"><i class="fa fa-linkedin-square fa-2x"></i></a></li>
				<li><a href="#" rel="nofollow" target="_social"><i class="fa fa-youtube-square fa-2x"></i></a></li>
				<li><a href="#" rel="nofollow" target="_social"><i class="fa fa-pinterest-square fa-2x"></i></a></li>
				<li><a href="http://www.convocatoria.pe/feed/" rel="nofollow" target="_social"><i class="fa fa-rss-square fa-2x"></i></a></li>
				<li><a href="https://plus.google.com/+convocatoriape" rel="nofollow" target="_social"><i class="fa fa-google-plus-square fa-2x"></i></a></li>
				<li><a href="https://twitter.com/convocatoriape" rel="nofollow" target="_social"><i class="fa fa-twitter-square fa-2x"></i></a></li>
				<li><a href="https://www.facebook.com/convocatoria.pe" rel="nofollow" target="_social"><i class="fa fa-facebook-square fa-2x"></i></a></li>
			</ul>

		  </div>

		  <hr class="clear-hr" />

		  <div class="one-third first"><p>© 2015 Convocatoria.pe</p></div>
		  <div class="one-third top"><p><a href="#">↑ Volver arriba</a></p></div>
		  <div class="one-third text-right made"><p>Made in Perú</p></div>		  		  

		  ';
}


/* # CTR Ads
---------------------------------------------------------------------------------------------------- */

// Leaderboard
add_action( 'genesis_before_header', 'leaderboard_top_header' );
function leaderboard_top_header() {
	echo "
		<div class='leaderboard-header'><div class='wrap'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 	

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "<img src='http://localhost/wp/wp-content/themes/ctr/images/728x90.png' />";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 728x90_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="7134596765"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}	

	echo "
		</div></div>
	";
}


// Links Ads
add_action('genesis_after_header', 'leader_lu');
function leader_lu() {
	echo "
		<div class='leader-lu'>
			<div class='wrap'>
	";



$ip = $_SERVER['REMOTE_ADDR']; 


	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
			<img src='http://localhost/wp/wp-content/themes/ctr/images/728x15.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 728x15_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:15px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5239061166"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}

	echo "</div></div>";
}

// Wide Skyscraper
function sidebar_160(){
	echo "
		<div class='sidebar-160-left'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 	

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "<img src='http://localhost/wp/wp-content/themes/ctr/images/160x600.png' />";
	}
	else {
		echo '

			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- CTR convocatoria.pe 160x600 -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:160px;height:600px"
			     data-ad-client="ca-pub-1445607604292298"
			     data-ad-slot="9949755967"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>

		';
	}

	echo "</div>";
}

// Leaderboard
function leaderboard_top() {
	echo "
		<div class='leaderboard'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 	

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "<img src='http://localhost/wp/wp-content/themes/ctr/images/728x90.png' />";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 728x90_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="7134596765"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}	

	echo "
		</div>
	";
}

// Roadblock Vertical Left
function roadblock_vertical_left() {
	echo "
		<div class='roadblock-left'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 	

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
					<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}		

	echo "<br><br>";

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
					<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}		

	echo "
		</div>
	";
}

// Roadblock Vertical Right
function roadblock_vertical_right() {
	echo "
		<div class='roadblock-right'>
			
		";

	
	$ip = $_SERVER['REMOTE_ADDR']; 		

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
					<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}		

	echo "<br><br>";

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
					<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}		

	echo "	
	</div>
	";
}

// Roadblock Top
function roadblock_top() {
	echo "
		<div class='roadblock-left'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 		

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}	

	echo "
		</div>
	";

	echo "
		<div class='roadblock-right'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 		

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}	


	echo "
		</div>
		<br class='clear' />
	";
}

// Roadblock Bottom
function roadblock_bottom() {
	echo "
		<div class='roadblock-left'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 		

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}	

	echo "
		</div>
	";

	echo "
		<div class='roadblock-right'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 		

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}	


	echo "
		</div>
		<br class='clear' />
	";
}

// Adsense 336 Top Left
function adsense336_top_left() {
	echo "
		<div class='adsense336-block-left'>
		";

	
	$ip = $_SERVER['REMOTE_ADDR']; 		

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}			

	echo "
		</div>
	";
}

// Adsense 336 Top Right
function adsense336_top_right() {
	echo "
		<div class='adsense336-block-right'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 		

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}		

	echo"
		</div>
	";
}

// Adsense 336 Bottom
function adsense336_bottom() {
	echo "
		<div class='adsense336-block'>
	";

	
	$ip = $_SERVER['REMOTE_ADDR']; 		

	if ( ($ip == '127.0.0.1') or ($ip == 'localhost') or ($ip == '::1') or ($ip == '192.168.0.26') or ($ip == '179.7.89.6') ) { 
		echo "
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		";
	}
	else {
		echo '

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336x280_NCTR -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-1445607604292298"
     data-ad-slot="5657863566"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		';
	}	

	echo "
		</div>
	";
}


$i = rand(1, 7);

switch ($i) {
    case 0:
        break;
    case 1:
        add_filter('genesis_before_entry_content', 'roadblock_vertical_left');
        // add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;
    case 2:
        add_filter('genesis_before_entry_content', 'roadblock_vertical_right');
        // add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;
    case 3:
        add_action('genesis_before_loop', 'leaderboard_top');
        add_filter('genesis_after_entry_content', 'adsense336_bottom');
        // add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;
    case 4:
        add_filter('genesis_after_entry_content', 'roadblock_bottom');
        // add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;             
    case 5:
        add_filter('genesis_before_entry_content', 'adsense336_top_left');
        add_filter('genesis_after_entry_content', 'adsense336_bottom');
        // add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;       
    case 6:
        add_filter('genesis_before_entry_content', 'adsense336_top_right');
        add_filter('genesis_after_entry_content', 'adsense336_bottom');
        // add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;       
    case 7:
        add_filter('genesis_before_entry_content', 'roadblock_top');
        // add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;                    
}


