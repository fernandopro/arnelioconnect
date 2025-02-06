<?php
/**
 * Elementor search control.
 *
 * A control for displaying a search field with the ability to fetch results.
 *
 * @since 1.0.0
 */
class Shortcode_text extends \Elementor\Base_Data_Control {

    /**
     * Get search control type.
     *
     * Retrieve the control type, in this case `search`.
     *
     * @since 1.0.0
     * @access public
     * @return string Control type.
     */
    public function get_type() {
        return 'search_text';
    }

    /**
     * Render search control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template() {
        $control_uid = $this->get_control_uid();
        ?>
        <search class="shortcode_widget_text">
            <input type="search" id="search_text" data-setting="{{ data.name }}" placeholder="{{ data.placeholder }} ..." autocomplete="off"><i class="eicon-search-bold" aria-hidden="true" ></i >

            <div id="search_results" style="display: none;"></div>

            <# if ( data.description ) { #>
            <div class="search_description">{{{ data.description }}}</div>
        </search>
        <# } #>
        <?php
    }



    public function enqueue() {

            wp_register_style('elementor_shortcode_widget', ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/elementor_shortcode_widget.css', array(), ARNELIOCONNECT_VERSION, 'all');
            wp_enqueue_style( 'elementor_shortcode_widget' );

		   wp_register_script('elementor_shortcode_widget', ARNELIOCONNECT_DIR_URL . 'dist/admin/js/elementor_shortcode_widget.js', array(), ARNELIOCONNECT_VERSION, true);
		   wp_enqueue_script( 'elementor_shortcode_widget' );

    }
}
?>