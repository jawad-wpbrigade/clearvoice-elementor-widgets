<?php
/**
 * Plugin Name: Clearvoice Elementor Widgets
 * Description: Custom Elementor Widgets for ClearVoice Website
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Jawad
 * Author URI:  https://developers.elementor.com/
 * Text Domain: ClearVoice-elementor-widgets
 *
 * Elementor tested up to: 3.9.2
 * Elementor Pro tested up to: 3.9.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class ClearVoiceElementorWidgets {

    const VERSION = '1.0.0';
    const ELEMENTOR_MINIMUM_VERSION = '3.0.0';
    const PHP_MINIMUM_VERSION = '7.4';

    private static $_instance = null;

    public function __construct() {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        add_action( 'elementor/elements/categories_registered', [ $this, 'create_new_category' ] );
        add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
    }

    public function i18n() {
        load_plugin_textdomain( 'ClearVoice-elementor-widgets' );
    }

    /**
     * Will do the logic here later
     * Most probably will show notices
     * if elementor plugin is not installed
    */
    public function init_plugin() {}

	/**
	 * Will write custom controls here
	 */
    public function init_controls() {}

	/**
	 * Start Registering Widgets
	 */
    public function init_widgets( $widgets_manager ) {

        // Require the widget class.
		require_once( __DIR__ . '/widgets/clv-hdi-widget.php' );

        // Register widget with elementor.
        $widgets_manager->register( new Clearvoice_Hdi_Widget() );

    }

    public static function get_instance() {

        if ( null == self::$_instance ) {
            self::$_instance = new Self();
        }

        return self::$_instance;

    }

    public function create_new_category( $elements_manager ) {

        $elements_manager->add_category(
            'clearvoice',
            [
                'title' => __( 'ClearVoice', 'ClearVoice-elementor-widgets' ),
                'icon'  => 'fa fa-plug'
            ]
        );

    }

}

ClearVoiceElementorWidgets::get_instance();
