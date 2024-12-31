<?php
/**
 * Theme functions and definitions.
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 */
function hello_elementor_child_scripts_styles() {
    wp_enqueue_style(
        'hello-elementor-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [
            'hello-elementor-theme-style',
        ],
        HELLO_ELEMENTOR_CHILD_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

function include_multistep_form() {
    // This gets the correct directory for the active theme, whether it's a child theme or a parent theme.
    $template_path = get_stylesheet_directory() . '/multistep-form-template.php';

    if (file_exists($template_path)) {
        include $template_path;
    } else {
        echo 'The file does not exist in the specified path: ' . $template_path;
    }
}
add_action('wp_head', 'include_multistep_form');


function enqueue_multistep_form_assets() {
    // Correctly point to the JavaScript and CSS files in your theme directory
    wp_enqueue_style('multistep-form-styles', get_template_directory_uri() . '/assets/css/multistep-form.css');
    wp_enqueue_script('multistep-form-script', get_template_directory_uri() . '/assets/js/multistep-form.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_multistep_form_assets');