<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class shortcode_widget extends \Elementor\Widget_Base {

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
		return 'tarokina-shortcode';
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
		return esc_html__( 'Tarokina', 'arnelioconnect' );
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
		return 'eicon-photo-library';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
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
		return [ 'tarokina', 'tarot', 'shortcode' ];
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




	// /**
	//  * CSS Y JS.
	//  *
	//  * Add input fields to allow the user to customize the widget settings.
	//  *
	//  * @since 1.0.0
	//  * @access public
	//  */
    // public function get_script_depends() {
	// 	return [ 'elementor_shortcode_widget' ];
	// }

	// public function get_style_depends() {
	// 	return [ 'elementor_shortcode_widget' ];
	// }



	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'scfs_shortcode_section',
			[
				'label' => esc_html__( 'Isert tarot', 'arnelioconnect' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);


		$this->add_control(
			'scfs_shortcode_search_text',
			[
				'label' => esc_html__( 'Search Text', 'arnelioconnect' ),
				'type' => 'search_text', // Tipo de control personalizado
				'placeholder' => esc_html__( 'Search tarot', 'arnelioconnect' ),
				'description'=> sprintf( __( 'Busca un tarot por su nombre e insertalo directamente en el contenido. Accede a la lista de lecturas de tarot desde este link. %1$s', 'arnelioconnect' ), '<a href="'.admin_url('edit.php?post_type=scfs_tarots').'" target="_blank">'.esc_html__( 'Edit tarot', 'arnelioconnect' ).'</a>' ),
			]
		);


		$this->add_control(
			'scfs_shortcode_search_id',
			[
				'label' => esc_html__( 'Search ID', 'arnelioconnect' ),
				'type' => 'search_id', // Hacer el campo invisible
				'default' => '',
			]
		);
		


		$this->end_controls_section();

	}


	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['search_text'] ) ) {
			return;
		}
	
		$control_uid = uniqid('elementor_shortcode_widget_');

		$id_tarot = $settings['search_id'];
		$post_name = get_post_field( 'post_name', $id_tarot );
	
		
		// Verificar si estamos en el editor de Elementor
		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
			// Render en el editor de Elementor
			?>
			<div class="edit_shortcode_widget">
			<svg width="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 198.84 198.84"><defs><style>.cls-1{ fill: #fff;} .cls-2{ fill: #202123; fill-rule:evenodd;} </style></defs><title>deck_checkbox</title><g id="circulo"><circle class="cls-1" cx="99.42" cy="99.42" r="99.42"/></g><g id="pro"><path class="cls-2" d="M169.86,116.12c-19.17,9.27-38.4,18.39-57.47,27.86a43,43,0,0,1-31.53,3.21c-13.44-3.64-26.93-7.05-40.37-10.69a7,7,0,0,0-6.86,1.58c1.49.43,2.7.81,3.93,1.13,18.17,4.76,36.35,9.49,54.5,14.32a8.18,8.18,0,0,0,6.11-.63q33.22-16.17,66.52-32.17c3-1.45,6-2.93,9.33-4.58A3.7,3.7,0,0,0,169.86,116.12Z"/><path class="cls-2" d="M82.52,110.76c5.76,1.83,10.36,1.46,15.56-1.73,7.08-4.34,14.16-8.54,19.64-15.08,9-10.75,12.8-23,10-37.27a3.88,3.88,0,0,0-3.09-3.35c-17.15-5-34.28-10.06-51.42-15.1-3.07-.91-3.07-.89-2.58,2.31A40.34,40.34,0,0,1,67.2,64.67C60.78,78,50.71,87.32,37.75,93.38c-1.69.78-3.39,1.54-5.09,2.31l.17.62c.64.21,1.28.43,1.92.61C50.69,101.49,66.71,105.76,82.52,110.76Z"/><path class="cls-2" d="M92.35,125.9a7.21,7.21,0,0,0,5.39-.52Q127.38,111,157.09,96.67l16.8-8.14c-.61-.43-.8-.65-1-.7-11.89-3.15-23.79-6.26-35.66-9.45-1.79-.48-2.2.46-2.66,1.88-4.87,15.08-14.63,25.79-27.72,33.47-3.78,2.22-7.69,4.21-11.45,6.49a8.77,8.77,0,0,1-7.54,1c-14.92-4.39-29.92-8.52-44.81-13-3.65-1.11-6.32.12-9.58,2.21l4.14,1.1C55.85,116.29,74.11,121.05,92.35,125.9Z"/><path class="cls-2" d="M167,102.57c-18.21,8.87-36.52,17.5-54.67,26.5A42.78,42.78,0,0,1,81,132.3c-11.78-3.19-23.66-6-35.37-9.47-4.54-1.35-8.08-.15-12.11,2.41.81.28,1.2.45,1.6.56q28.62,7.5,57.21,15a7.21,7.21,0,0,0,5.39-.53Q131.32,124,165,107.8l9.23-4.5C171.38,102.36,169.41,101.4,167,102.57Z"/></g></svg>
				<div class="esw_title"><?php echo esc_attr( $settings['search_text'] ); ?></div>
			</div>
			<?php

		}else{
			// Render en el frontend
			echo do_shortcode( '[tarot_pro name="' . $post_name . '"]');
		}
	}

}

// function add_div_before_tarokina_shortcode( $element ) {
//     if ( 'tarokina-shortcode' === $element->get_name() ) {
//         $settings = $element->get_settings_for_display();
// 		echo do_shortcode( '[tarot_pro id="' . $settings['search_id'] . '"]');
//     }
// }
// add_action( 'elementor/frontend/widget/after_render', 'add_div_before_tarokina_shortcode' );

