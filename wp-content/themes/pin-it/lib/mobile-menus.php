<?php
// Based on code from the StudioPress Genesis Framework 2.0
// @author Brad Potter
// @link http://bradpotter.com/responsive-mobile-navigation-menu-for-the-genesis-theme-framework/

// Register Genesis menus
add_theme_support ( 'genesis-menus' , array ( 'primary' => 'Primary Navigation Menu' , 'secondary' => 'Secondary Navigation Menu' ,'mobile' => 'Mobile Navigation Menu' ) );

// Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array( 'header', 'menu-mobile', 'menu-primary', 'menu-secondary', 'footer-widgets', 'footer' ) );

// Create the mobile navigation menu.
add_action( 'genesis_before_header', 'gst_do_mobilenav' );
function gst_do_mobilenav() {

	// Do nothing if menu not supported
	if ( ! genesis_nav_menu_supported( 'mobile' ) )
		return;

	// If menu is assigned to theme location, output
	if ( has_nav_menu( 'mobile' ) ) {

		$class = 'menu genesis-nav-menu menu-mobile';
		if ( genesis_superfish_enabled() )
			$class .= ' js-superfish';

		$args = array(
			'theme_location' => 'mobile',
			'container'      => '',
			'menu_class'     => $class,
			'echo'           => 0,
		);

		$mobilenav = wp_nav_menu( $args );

		// Do nothing if there is nothing to show
		if ( ! $mobilenav )
			return;

		$mobilenav_markup_open = genesis_markup( array(
			'html5'   => '<nav %s>',
			'xhtml'   => '<div id="mobilenav">',
			'context' => 'nav-mobile',
			'echo'    => false,
		) );
		
		$mobilenav_markup_open .= genesis_structural_wrap( 'menu-mobile', 'open', 0 );

		$mobilenav_markup_close  = genesis_structural_wrap( 'menu-mobile', 'close', 0 );
		$mobilenav_markup_close .= genesis_html5() ? '</nav>' : '</div>';

		$mobilenav_output = $mobilenav_markup_open . $mobilenav . $mobilenav_markup_close;

		echo apply_filters( 'gst_do_mobilenav', $mobilenav_output, $mobilenav, $args );

	}

}

// Add attributes for mobile navigation menu.
add_filter( 'genesis_attr_nav-mobile', 'gst_attributes_nav_mobile' );
function gst_attributes_nav_mobile( $attributes ) {

	$attributes['role']      = 'navigation';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/SiteNavigationElement';

	return $attributes;
}

// Add stylesheet for navigational menus
add_action( 'wp_enqueue_scripts', 'mobile_menu_css' );
function mobile_menu_css() {
	wp_register_style( 'mobile-menu-css', get_stylesheet_directory_uri() . '/lib/css/mobile-menus.css'  );
	wp_enqueue_style( 'mobile-menu-css' );
}

// Register and enqueue mobile navigation menu script
add_action('wp_enqueue_scripts', 'gst_mobilemenu_script');
function gst_mobilemenu_script() {
	wp_register_script( 'mobile-menu', get_stylesheet_directory_uri() . '/lib/js/mobilemenus.js', array('jquery'), '1.0.0', false );
	wp_enqueue_script( 'mobile-menu' );
}