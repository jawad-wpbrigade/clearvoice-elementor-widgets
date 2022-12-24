<?php
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
		return 'clearvoice_hdi';
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
		return esc_html__( 'HDI', 'clearvoice-elementor-addon' );
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
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
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
		return [ 'general' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'HDI', 'heading', 'link', 'image' ];
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
			[
				'label' => esc_html__( 'Content', 'clearvoice-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		// Control for Title.
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Heading', 'clearvoice-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'clearvoice-elementor-addon' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'clearvoice-elementor-addon' ),
			]
		);
		// HTML tag control tag for Title.
		$this->add_control(
			'title_size',
			[
				'label' => esc_html__( 'Heading Tag', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			]
		);
		// Control for description.
		$this->add_control(
			'item_description',
			[
				'label' => esc_html__( 'Description', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Default description', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your description here', 'textdomain' ),
			]
		);
		// Control for image
		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'clearvoice-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		//Control for link.
		$this->add_control(
			'URL',
			[
				'label' => esc_html__( 'Link', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'textdomain' ),
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
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
		$title_html = sprintf( '<%1$s>%2$s</%1$s>', \Elementor\Utils::validate_html_tag( $settings['title_size'] ), $settings['title'] );

		// render wysiwyg.
		?>

		<div <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo $title_html; ?></div>
		<div <?php echo $this->get_render_attribute_string( 'item_description' ); ?>><?php echo $settings['item_description']; ?></div>
		
		<?php
		// rendering the url.
		if ( ! empty( $settings['URL']['url'] ) ) {
			$this->add_link_attributes( 'URL', $settings['URL'] );
		}
		?>
		<div><a <?php echo $this->get_render_attribute_string( 'URL' ); ?>><?php echo $settings['URL']['url']; ?></a></div>
		<div <?php echo $this->get_render_attribute_string( 'image' ); ?>><?php echo wp_get_attachment_image( $settings['image']['id'], 'medium' ); ?></div>
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
		<{{{settings.title_size}}}>{{ settings.title }}</{{{settings.title_size}}}>

		<div class="description">{{{settings.item_description}}}</div>
		<a {{{view.getRenderAttributeString( 'URL' )}}}>{{settings.URL.url}}</a>
		<div><img src="{{{ settings.image.url }}}"></div>
		<?php
	}
}
