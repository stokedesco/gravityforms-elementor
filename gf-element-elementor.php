<?php
/**
 * Plugin Name: GF Element for Elementor
 * Plugin URI:  https://stokedesign.co
 * Description: Adds Elementor styling controls for Gravity Forms.
 * Version:     1.0.0
 * Author:      Stoke Design Co
 * Author URI:  https://stokedesign.co
 * Text Domain: gf-element-elementor
 * License:     GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Activation hook.
 */
function gf_element_elementor_activate() {
    // Check for Gravity Forms and Elementor.
    if ( ! class_exists( 'GFForms' ) || ! did_action( 'elementor/loaded' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( __( 'This plugin requires both Gravity Forms and Elementor to be installed and active.', 'gf-element-elementor' ) );
    }
}
register_activation_hook( __FILE__, 'gf_element_elementor_activate' );

/**
 * Display admin notice if required plugins are missing after activation.
 */
function gf_element_elementor_check_dependencies() {
    if ( class_exists( 'GFForms' ) && did_action( 'elementor/loaded' ) ) {
        return;
    }

    add_action( 'admin_notices', function() {
        echo '<div class="notice notice-error"><p>' . esc_html__( 'GF Element Elementor requires both Gravity Forms and Elementor to be installed and active.', 'gf-element-elementor' ) . '</p></div>';
    } );
}
add_action( 'plugins_loaded', 'gf_element_elementor_check_dependencies' );

/**
 * Enqueue plugin assets.
 */
function gf_element_elementor_enqueue_assets() {
    wp_enqueue_style( 'gf-element-elementor', plugin_dir_url( __FILE__ ) . 'assets/css/gf-element-elementor.css', array(), '1.0.0' );
    wp_enqueue_script( 'gf-element-elementor', plugin_dir_url( __FILE__ ) . 'assets/js/gf-element-elementor.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'gf_element_elementor_enqueue_assets' );
