<?php

// Adjust padding on .site-inner if primary menu or secondary menu exists
if ( ! genesis_nav_menu_supported( 'primary' ) )
	return;
if ( has_nav_menu( 'primary' ) && !has_nav_menu( 'secondary' ) || !has_nav_menu( 'primary' ) && has_nav_menu( 'secondary' ) ) {
	add_action( 'wp_enqueue_scripts', 'one_menu_css' );
	function one_menu_css() {
		wp_register_style( 'one-menu-css', get_stylesheet_directory_uri() . '/lib/css/one-menu.css'  );
		wp_enqueue_style( 'one-menu-css' );
	}
}

// Adjust padding on .site-inner if primary menu and secondary menu exist
if ( ! genesis_nav_menu_supported( 'secondary' ) )
	return;
if ( has_nav_menu( 'primary' ) && has_nav_menu( 'secondary' ) ) {
	add_action( 'wp_enqueue_scripts', 'two_menus_css' );
	function two_menus_css() {
		wp_register_style( 'two-menus-css', get_stylesheet_directory_uri() . '/lib/css/two-menus.css'  );
		wp_enqueue_style( 'two-menus-css' );
	}
}