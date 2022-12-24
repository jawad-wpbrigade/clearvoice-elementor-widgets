<?php
/**
 * Plugin Name: Clearvoice Elementor Addon
 * Description: Add a specialized widget for HDI like sections
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Jawad
 * Author URI:  https://developers.elementor.com/
 * Text Domain: clearvoice-elementor-addon
 *
 * Elementor tested up to: 3.7.0
 * Elementor Pro tested up to: 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register clear voice hdi widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_hdi_widget( $widgets_manager ) {

	require_once( __DIR__ . '/inc/clearvoice-widget.php' );

	$widgets_manager->register( new \Clearvoice_Hdi_Widget() );

}
add_action( 'elementor/widgets/register', 'register_hdi_widget' );