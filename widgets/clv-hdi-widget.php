<?php
namespace ClearVoice\ElementorWidgets\Widgets;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Clearvoice hdi Widget.
 *
 * Clear voice widget that adds specialized cta section
 *
 * @since 1.0.0
 */
class  Clearvoice_Hdi_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'clearvoice-hdi';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'ClearVoice HDI', 'clearvoice-elementor-addon' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-info-box';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the HDI widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'clearvoice' ];
	}

	/**
	 * Register HDI widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'clearvoice-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		// Control for Title.
		$this->add_control(
			'hdi_title',
			array(
				'label' => esc_html__( 'Heading', 'clearvoice-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'clearvoice-elementor-addon' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'clearvoice-elementor-addon' ),
			)
		);
		// HTML tag control tag for Title.
		$this->add_control(
			'hdi_title_size',
			array(
				'label' => esc_html__( 'Heading Tag', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				),
				'default' => 'h2',
			)
		);
		// Control for description.
		$this->add_control(
			'hdi_item_description',
			array(
				'label' => esc_html__( 'Description', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Default description', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your description here', 'textdomain' ),
			)
		);
		// Control for image
		$this->add_control(
			'hdi_image',
			array(
				'label' => esc_html__( 'Choose Image', 'clearvoice-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			)
		);
		//Control for link.
		$this->add_control(
			'hdi_URL',
			array(
				'label' => esc_html__( 'Link', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'textdomain' ),
				'options' => array( 'url', 'is_external', 'nofollow' ),
				'default' => array(
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				),
				'label_block' => true,
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Render clearvoice hdi widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		// Store the controls data in $settings variable.
		$settings = $this->get_settings_for_display();

		// Render Title with heading tag.
		$title_html = sprintf( '<%1$s>%2$s</%1$s>', \Elementor\Utils::validate_html_tag( $settings['hdi_title_size'] ), $settings['hdi_title'] );

		// render wysiwyg.
		?>

		<div <?php echo $this->get_render_attribute_string( 'hdi_title' ); ?>><?php echo $title_html; ?></div>
		<div <?php echo $this->get_render_attribute_string( 'hdi_item_description' ); ?>><?php echo $settings['hdi_item_description']; ?></div>
		
		<?php
		// rendering the url.
		if ( ! empty( $settings['hdi_URL']['url'] ) ) {
			$this->add_link_attributes( 'hdi_URL', $settings['hdi_URL'] );
		}
		?>
		<div><a <?php echo $this->get_render_attribute_string( 'hdi_URL' ); ?>><?php echo $settings['hdi_URL']['url']; ?></a></div>
		<div <?php echo $this->get_render_attribute_string( 'hdi_image' ); ?>><?php echo wp_get_attachment_image( $settings['hdi_image']['id'], 'medium' ); ?></div>
		<?php

	}
	/**
	 * Render list widget output in the editor.
	 *
	 * Written as a JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<{{{settings.hdi_title_size}}}>{{ settings.hdi_title }}</{{{settings.hdi_title_size}}}>

		<div class="description">{{{settings.hdi_item_description}}}</div>
		<a {{{view.getRenderAttributeString( 'URL' )}}}>{{settings.hdi_URL.url}}</a>
		<div><img src="{{{ settings.hdi_image.url }}}"></div>
		<?php
	}
}
