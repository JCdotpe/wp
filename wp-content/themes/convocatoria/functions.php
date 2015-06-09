<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'CTR Genesis Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '1.0' );


//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


// Custom post info
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
if ( !is_page() ) {
	$post_info = '[post_date"] [post_edit]';
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
  $args['home'] = 'WP';
  return $args;
}

// Breadcrumb Separator
add_filter( 'genesis_breadcrumb_args', 'b3m_change_separator_breadcrumb' );
function b3m_change_separator_breadcrumb( $args ) {
  $args['sep'] = ' » ';
  return $args;
}


// Remove comment form
remove_action( 'genesis_comment_form', 'genesis_do_comment_form' );

// Remove jQuery
add_action('wp_enqueue_scripts', 'crunchify_script_remove_header');
function crunchify_script_remove_header() {
      wp_deregister_script( 'jquery' );
      wp_deregister_script( 'jquery-ui' );
}

// Remove Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


// Custom footer
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds"><p><a href="#" class="top">Subir &uarr;</a></p></div>';
}


// Remove the post meta function
function be_post_meta_filter($post_meta) {
	$post_meta = '[post_tags before="Tags: "]';
	return $post_meta;
}
add_filter('genesis_post_meta', 'be_post_meta_filter');


// Pagination text

add_filter( 'genesis_prev_link_text', 'gt_review_prev_link_text' );
function gt_review_prev_link_text() {
        $prevlink = '&laquo; Anterior';
        return $prevlink;
}

add_filter( 'genesis_next_link_text', 'gt_review_next_link_text' );
function gt_review_next_link_text() {
        $nextlink = 'Siguiente &raquo;';
        return $nextlink;
}



// ADS PRO


// Leaderboard
add_action('genesis_before_loop', 'leaderboard');
function leaderboard() {
	echo "
		<div class='leaderboard'><img src='http://www.convocatoria.pe/wp-content/themes/convocatoria/images/728x90.png' /></div>
	";
}



// Wide Skyscraper

add_filter( 'xxxx', 'wide_skyscraper' );
function wide_skyscraper(){
	echo "
		<div class='wide-skyscraper'><img src='http://www.convocatoria.pe/wp-content/themes/convocatoria/images/336x280.png' /></div>
	";
}


// Roadblock
add_filter( 'genesis_after_entry_content', 'adsense336block_top' );
function adsense336block_top(){
	echo "
		<div class='adsense336block-left'><img src='http://www.convocatoria.pe/wp-content/themes/convocatoria/images/336x280.png' /></div>
		<div class='adsense336block-right'><img src='http://www.convocatoria.pe/wp-content/themes/convocatoria/images/336x280.png' /></div>
	";
}



// Roadblock
add_filter( 'genesis_before_entry_content', 'adsense336block_bottom' );
function adsense336block_bottom(){
	echo "
		<div class='adsense336block-left'><img src='http://www.convocatoria.pe/wp-content/themes/convocatoria/images/336x280.png' /></div>
		<div class='adsense336block-right'><img src='http://www.convocatoria.pe/wp-content/themes/convocatoria/images/336x280.png' /></div>
	";
}



// Load iframe convocatorias
add_action('genesis_after_header', 'leader_lu');
function leader_lu() {
	echo '
		<div class="leader-lu"><img src="http://localhost/wp/wp-content/themes/convocatoria/images/728x15.png" /></div>
	';
}