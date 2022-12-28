<?php
/**
 * Plugin Name: Clearvoice Elementor Widgets
 * Description: Custom Elementor Widgets for ClearVoice Website
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Jawad
 * Author URI:  https://developers.elementor.com/
 * Text Domain: clearvoice-elementor-addon
 *
 * Elementor tested up to: 3.9.2
 * Elementor Pro tested up to: 3.9.2
 */
namespace ClearVoice\ElementorWidgets;

use ClearVoice\ElementorWidgets\Widgets as clv_widgets;

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

    public function init_plugin() {
        // Check php version
        // check if elementor is installed
        // bring in the widget classes
        // bring in the controls
    }

    public function init_controls() {
        
    }

    public function init_widgets( $widgets_manager ) {

        // Require the widget class.
		require_once( __DIR__ . '/widgets/clv-hdi-widget.php' );

        // Register widget with elementor.
        $widgets_manager->register( new clv_widgets\Clearvoice_Hdi_Widget() );

    }

    public static function get_instance() {

        if ( null == self::$_instance ) {
            self::$_instance = new Self();
        }

        return self::$_instance;

    }

	/**
	 * Create new category and show it on top of all categories in elementor.
	 */
	public function create_new_category( $elements_manager ) {

		$clv_categories = array();
		$clv_categories['clearvoice'] = array(
			'title' => __( 'ClearVoice', 'ClearVoice-elementor-widgets' ),
			'icon'  => 'fa fa-plug',
		);
		// Get our category to the top.
		$old_categories = $elements_manager->get_categories();
		$clv_categories = array_merge( $clv_categories, $old_categories );
		$set_categories = function ( $clv_categories ) {
			$this->categories = $clv_categories;
		};

		$set_categories->call( $elements_manager, $clv_categories );
    }

}

ClearVoiceElementorWidgets::get_instance();
