<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

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
      wp_deregister_script( 'jquery-ui' );
}

// Remove Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );



//
add_filter( 'genesis_header', 'custom_search' );
function custom_search() {
	echo "<div class='header-search'>
		  	<img src='http://localhost/wp/wp-content/themes/ctr/images/search.png' />
	</div>
	";
}	

/* # Content Area
---------------------------------------------------------------------------------------------------- */

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
	$post_meta = '[post_tags before="Tags: "]';
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


/* # Footer
---------------------------------------------------------------------------------------------------- */

// Custom footer
add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
function sp_footer_creds_text() {
	echo '<div class="creds"><p><a href="#" class="top">Subir &uarr;</a></p></div>';
}


/* # CTR Ads
---------------------------------------------------------------------------------------------------- */

// Links Ads
add_action('genesis_after_header', 'leader_lu');
function leader_lu() {
	echo "
		<div class='leader-lu'>
			<div class='wrap'>
				<img src='http://localhost/wp/wp-content/themes/ctr/images/728x15.png' />
			</div>
		</div>
	";
}

// Wide Skyscraper
function sidebar_160(){
	echo "
		<div class='sidebar-160-left'><img src='http://localhost/wp/wp-content/themes/ctr/images/160x600.png' /></div>
	";
}

// Leaderboard
function leaderboard_top() {
	echo "
		<div class='leaderboard'><img src='http://localhost/wp/wp-content/themes/ctr/images/728x90.png' /></div>
	";
}

// Roadblock Vertical Left
function roadblock_vertical_left() {
	echo "
		<div class='roadblock-left'>
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
			<br /><br />
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		</div>
	";
}

// Roadblock Vertical Right
function roadblock_vertical_right() {
	echo "
		<div class='roadblock-right'>
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
			<br /><br />
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		</div>
	";
}

// Roadblock Top
function roadblock_top() {
	echo "
		<div class='roadblock-left'>
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		</div>
		<div class='roadblock-right'>
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		</div>
	";
}

// Roadblock Bottom
function roadblock_bottom() {
	echo "
		<div class='roadblock-left'>
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		</div>
		<div class='roadblock-right'>
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		</div>
	";
}

// Adsense 336 Top Left
function adsense336_top_left() {
	echo "
		<div class='adsense336-block-left'>
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		</div>
	";
}

// Adsense 336 Top Right
function adsense336_top_right() {
	echo "
		<div class='adsense336-block-right'>
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		</div>
	";
}

// Adsense 336 Bottom
function adsense336_bottom() {
	echo "
		<div class='adsense336-block'>
			<img src='http://localhost/wp/wp-content/themes/ctr/images/336x280.png' />
		</div>
	";
}




$i = rand(1, 7);

switch ($i) {
    case 0:
        break;
    case 1:
        add_filter('genesis_before_entry_content', 'roadblock_vertical_left');
        add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;
    case 2:
        add_filter('genesis_before_entry_content', 'roadblock_vertical_right');
        add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;
    case 3:
        add_action('genesis_before_loop', 'leaderboard_top');
        add_filter('genesis_after_entry_content', 'adsense336_bottom');
        add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;
    case 4:
        add_filter('genesis_after_entry_content', 'roadblock_bottom');
        add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;             
    case 5:
        add_filter('genesis_before_entry_content', 'adsense336_top_left');
        add_filter('genesis_after_entry_content', 'adsense336_bottom');
        add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;       
    case 6:
        add_filter('genesis_before_entry_content', 'adsense336_top_right');
        add_filter('genesis_after_entry_content', 'adsense336_bottom');
        add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;       
    case 7:
        add_filter('genesis_before_entry_content', 'roadblock_top');
        add_filter('genesis_after_sidebar_widget_area', 'sidebar_160');
        break;                    
}