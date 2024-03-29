<?php

// Add support for Custom CSS
add_action( 'admin_enqueue_scripts', 'custom_css_scripts' );
 
function custom_css_scripts( $hook ) {
    if ( 'appearance_page_custom_css_admin_page_content' == $hook ) {
        wp_enqueue_script( 'ace_code_highlighter_js', get_template_directory_uri() . '/js/ace.js', '', '1.0', true );
        wp_enqueue_script( 'ace_mode_js', get_template_directory_uri() . '/js/mode-css.js', array( 'ace_code_highlighter_js' ), '1.0', true );
        wp_enqueue_script( 'custom_css_js', get_template_directory_uri() . '/js/custom-css.js', array( 'jquery', 'ace_code_highlighter_js' ), '1.0', true );
    }
}

add_action( 'admin_menu', 'custom_css_admin_page' );
 
function custom_css_admin_page() {
    add_theme_page( 'Custom CSS',  __( 'Custom CSS' ), 'edit_theme_options', 'custom_css_admin_page_content', 'custom_css_admin_page_content' );
}

add_action( 'admin_init', 'register_custom_css_setting' );
 
function register_custom_css_setting() {
    register_setting( 'custom_css', 'custom_css',  'custom_css_validation');
}

function custom_css_admin_page_content() {
    // The default message that will appear
    $custom_css_default = __( '/*
Welcome to the Custom CSS editor! 
	
Please add all your custom CSS here and avoid modifying the core theme files, since that\'ll make upgrading the theme problematic. Your custom CSS will be loaded after the theme\'s stylesheets, which means that your rules will take precedence. Just add your CSS here for what you want to change, you don\'t need to copy all the theme\'s style.css content. 

You can delete all of this text at any time.
*/' );
    $custom_css = get_option( 'custom_css', $custom_css_default );
    ?>
    <div class="wrap">
        <div id="icon-themes" class="icon32"></div>
        <h2><?php _e( 'Custom CSS' ); ?></h2>
        <?php if ( ! empty( $_GET['settings-updated'] ) ) echo '<div id="message" class="updated"><p><strong>' . __( 'Custom CSS updated.' ) . '</strong></p></div>'; ?>
 
        <form id="custom_css_form" method="post" action="options.php" style="margin-top: 15px;">
 
            <?php settings_fields( 'custom_css' ); ?>
 
            <div id="custom_css_container" style="height:400px;">
                <textarea id="custom_css_textarea" name="custom_css" style="height:100%;width:100%;"><?php echo $custom_css; ?></textarea>
            </div>
 
            
            <p><input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" /></p>
        </form>
    </div>
<?php
}

function custom_css_validation( $input ) {
    if ( ! empty( $input['custom_css'] ) )
        $input['custom_css'] = trim( $input['custom_css'] );
    return $input;
}

add_action( 'wp_head', 'display_custom_css' );
 
function display_custom_css() {
	$custom_css = get_option( 'custom_css' );
	if ( ! empty( $custom_css ) ) {
		echo '<style type="text/css">';
		echo '/* Custom CSS */' . "\n";
		echo $custom_css . "\n";
		echo '</style>';
	}
}