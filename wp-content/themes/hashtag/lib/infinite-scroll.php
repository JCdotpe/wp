<?php
// Based on code from 'Using Masonry in Genesis for a Pinterest like layout' by Sridhar Katakam
// @author Sridhar Katakam
// @link http://sridharkatakam.com/using-masonry-genesis-pinterest-like-layout/


// Register and enqueue Infinite Scrolling scripts
add_action( 'wp_enqueue_scripts', 'infinite_scroll_script' );
function infinite_scroll_script() {	
	wp_enqueue_script( 'infinitescroll', get_stylesheet_directory_uri().'/lib/js/jquery.infinitescroll.min.js' , array('jquery'), '1.0', true );
    wp_enqueue_script( 'infinitescroll-init', get_stylesheet_directory_uri().'/lib/js/infinitescroll-init.js' , array('jquery'), '1.0', true );
}

// Add stylesheet for Infinite Scrolling
add_action( 'wp_enqueue_scripts', 'infinitescroll_css' );
function infinitescroll_css() {
	wp_register_style( 'infinitescroll-css', get_stylesheet_directory_uri() . '/lib/css/infinite-scroll.css'  );
	wp_enqueue_style( 'infinitescroll-css' );
}