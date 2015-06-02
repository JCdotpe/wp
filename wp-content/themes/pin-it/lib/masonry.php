<?php
// Based on code from 'Using Masonry in Genesis for a Pinterest like layout' by Sridhar Katakam
// @author Sridhar Katakam
// @link http://sridharkatakam.com/using-masonry-genesis-pinterest-like-layout/

// Register and enqueue Masonry scripts
add_action( 'wp_enqueue_scripts', 'masonry_script' );
function masonry_script() {
	if( is_home() || is_category() || is_tag() || is_archive() || is_search() || is_page_template('page_blog.php') )
		wp_enqueue_script( 'masonry-init', get_stylesheet_directory_uri().'/lib/js/masonry-init.js' , array( 'jquery-masonry' ), '1.0', true );
	if( is_home() && is_active_sidebar( 'home-stamp' ) ) {
		wp_enqueue_script( 'home-stamp-init', get_stylesheet_directory_uri().'/lib/js/home-stamp-init.js' , array( 'jquery-masonry' ), '1.0', true );

		// Add home-stamp widget space to homepage
		add_action( 'genesis_before_loop', 'home_stamp' );
		function home_stamp() {	
			if( is_home()) {
				if ( is_active_sidebar( 'home-stamp' )) {
					echo '<div class="home-stamp">';
					dynamic_sidebar( 'home-stamp' );
					echo '</div><!-- end .home-stamp -->';
				}	
			}
		}	
	}
}

// Add custom body class to the head
add_filter( 'body_class', 'masonry_body_class' );
function masonry_body_class( $classes ) {
	if( is_home() || is_category() || is_tag() || is_archive() || is_search() || is_page_template('page_blog.php') )
		$classes[] = 'masonry';
		return $classes;
}

// Add new image size
add_image_size( 'masonry', 486, 0, TRUE );

// Adjust layout on Masonry pages
add_action( 'genesis_before_content', 'masonry_layout_change' );
function masonry_layout_change() {
	if( is_home() || is_category() || is_tag() || is_archive() || is_search() || is_page_template('page_blog.php') ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
		remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );	
		add_action( 'genesis_entry_content', 'genesis_do_post_title' );
		add_action( 'genesis_entry_content', 'genesis_do_post_content' );
		add_action( 'genesis_entry_footer', 'genesis_post_meta' );
		add_action( 'genesis_entry_footer', 'genesis_post_info', 12 );
	}
}