<?php
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Pin It' );
define( 'CHILD_THEME_URL', 'http://www.media-cairn.com/themes/pin-it-child-theme/' );
define( 'CHILD_THEME_VERSION', '3.0' );

// Theme support
add_theme_support( 'html5' );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-footer-widgets', 0 );

// Enqueue Google font: Oleo Script Swash Caps
add_action( 'wp_enqueue_scripts', 'genesis_google_fonts' );
function genesis_google_fonts() {
	wp_enqueue_style( 'google-font-pt-sans-narrow', '//fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps', array(), CHILD_THEME_VERSION );
}

// Add IE Stylesheets
add_action( 'wp_enqueue_scripts', 'ie_css' );
function ie_css() {
	global $is_IE;
	if( $is_IE ) {
		wp_register_style( 'ie-css-lte8', get_stylesheet_directory_uri() . '/lib/css/ie-lte8.css'  );
		  $GLOBALS['wp_styles']->add_data( 'ie-css-lte8', 'conditional', 'lte IE 8' );
		wp_enqueue_style( 'ie-css-lte8' );
	}
}

// Add additional javascript functionality
add_action( 'genesis_meta', 'additional_js' );
function additional_js() {
	wp_register_script( 'sticky', get_stylesheet_directory_uri() . '/lib/js/sticky.js', array('jquery'), '1.0.0', false );
	wp_enqueue_script( 'sticky' );
}

// Enable additional functionality
require_once( get_stylesheet_directory() . '/lib/mobile-menus.php' ); // Better mobile menus
require_once( get_stylesheet_directory() . '/lib/masonry.php' ); // Masonry
require_once( get_stylesheet_directory() . '/lib/infinite-scroll.php' ); // Infinite scrolling
require_once( get_stylesheet_directory() . '/lib/site-inner.php' ); // .site-inner adjustments for sticky menus
require_once( get_stylesheet_directory() . '/lib/custom-css.php' ); // Ace CSS editor

// Remove the default header widget and create new ones
unregister_sidebar( 'header-right' );
add_action( 'genesis_header', 'header_widget_left' );
function header_widget_left() {
	echo '<aside class="widget-area header-widget-left">';
	dynamic_sidebar( 'header-widget-left' );
	echo '</aside>';
}
add_action( 'genesis_header', 'header_widget_right' );
function header_widget_right() {
	echo '<aside class="widget-area header-widget-right">';
	dynamic_sidebar( 'header-widget-right' );
	echo '</aside><div class="clear"></div>';
}

// Move breadcrumb, taxonomy and author description above content
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');
add_action('genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs');
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
add_action('genesis_before_content_sidebar_wrap', 'genesis_do_taxonomy_title_description', 15 );
remove_action( 'genesis_before_loop', 'genesis_do_author_box_archive', 15 );
add_action('genesis_before_content_sidebar_wrap', 'genesis_do_author_box_archive', 15 );
remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
add_action('genesis_before_content_sidebar_wrap', 'genesis_do_author_title_description', 15 );

// Move search title above content
add_action( 'genesis_before', 'move_search_title' );
function move_search_title() {
	if( is_search() )
		add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_search_title' );
}

// Customize search form input box text
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
	return esc_attr( 'Search' );
}

// Customize search form input button text
add_filter( 'genesis_search_button_text', 'sp_search_button_text' );
function sp_search_button_text( $text ) {
	return esc_attr( '' );
}

// Register widget areas
genesis_register_sidebar( array(
	'id'			=> 'header-widget-left',
	'name'			=> __( 'Header Widget Left', 'pin_it' ),
	'description'	=> __( 'This is the left header widget.', 'pin_it' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'header-widget-right',
	'name'			=> __( 'Header Widget Right', 'pin_it' ),
	'description'	=> __( 'This is the right header widget.', 'pin_it' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-stamp',
	'name'			=> __( 'Homepage Corner Stamp', 'pin_it' ),
	'description'	=> __( 'This is the corner stamp in the upper left corner of the homepage.', 'pin_it' ),
) );

// Customize the credits
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'pin_it_footer' );
function pin_it_footer() {
    echo '<a href="#top" rel="nofollow" class="return-to-top"></a><div class="creds"><p><small>&copy; ' . date('Y') . ' ';
	echo bloginfo('Name');
	echo ' &middot; <a href="#">Facebook</a> - <a href="#">Twitter</a> - <a href="#">Instagram</a> &middot; <a href="';
	echo bloginfo('url');
	echo '#">Android</a> - <a href="#">iOS</a> - <a href="#">Windows Phone</a></small></p></div>';
}

// Remove read more
add_filter( 'get_the_content_more_link', 'child_read_more_link' );
function child_read_more_link() {
return '';
}


// Custom credit footer
add_filter( 'genesis_post_info', 'cd_post_info_filter' );
function cd_post_info_filter( $post_info ) {
	$entry_author = get_avatar( get_the_author_meta( 'email' ), 64 );
	$author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
	$post_info = sprintf( '<span class="author-avatar"><a href="%s">%s</a></span>', $author_link, $entry_author );
	$post_info .= '[post_author_posts_link]';
	$post_info .= '[post_categories before=""]';
	return $post_info;
}


add_filter( 'excerpt_length', 'sp_excerpt_length' );
function sp_excerpt_length( $length ) {
	echo "string";
	//return 50; // pull first 50 words
}