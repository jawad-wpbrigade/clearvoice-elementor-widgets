<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Clearvoice Custom Posts
 *
 * This Widget will get posts from categories.
 *
 * @since 1.0.0
 */
class  Clearvoice_Custom_Posts extends \Elementor\Widget_Base {

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
		return 'clearvoice-custom-posts';
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
		return esc_html__( 'ClearVoice Custom Posts', 'ClearVoice-elementor-widgets' );
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
		return 'eicon-posts-carousel';
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
				'label' => esc_html__( 'Content', 'ClearVoice-elementor-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		/**
		 * Let's get all the cats and store them in $options array.
		 */
		$options = array();
		$args = array(
    		'hide_empty' => false,
		);
		$categories = get_categories( $args );
		if ( isset( $categories ) && is_array( $categories ) ) {
			foreach ( $categories as $key => $category ) {
				$options[ $category->name ] = $category->name;
			}
		}
        $this->add_control(
			'clv_categories',
			array(
				'label'       => esc_html__( 'Select Categories', 'ClearVoice-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     =>  $options,
			)
		);
		$this->add_control(
			'clv_posts_per_page',
			array(
				'label'       => esc_html__( 'Posts Per Page', 'ClearVoice-elementor-widgets' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => -1,
				'separator'   => 'before',
			)
		);
		$this->add_control(
			'clv_hide_posts',
			array(
				'label' => esc_html__( 'Hide Posts', 'ClearVoice-elementor-widgets' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'clv_hide_posts_description',
			array(
				'raw' => esc_html__( " Enter the comma separated post id's that you want to hide like : 23,43 ", 'elementor' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
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
		$settings          = $this->get_settings_for_display();
		$clv_post_per_page = isset( $settings['clv_posts_per_page'] ) ? $settings['clv_posts_per_page'] : -1;
		$clv_categories    = isset( $settings['clv_categories'] ) ? $settings['clv_categories'] : array();
		$clv_hide_posts    = explode( ',' , $settings['clv_hide_posts'] );

		// Let's do the query magic now.
		$args = array(
			'post_type' => 'any',
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $clv_categories,
				)
			),
			'post__not_in'   => $clv_hide_posts,
			'posts_per_page' => $clv_post_per_page,
			'order'          => 'ASC',
		);

		$query = new WP_Query($args);
		if ( $query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post(); 
				?>
				<div style = "max-wdith: 50px">
				<div><?php echo get_the_post_thumbnail( get_the_ID(), array( 200, 200 ) ); ?></div>
				<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
				</div>
				<?php
			}
		}
		// Reset Query.
		wp_reset_query() ;
	}
}
