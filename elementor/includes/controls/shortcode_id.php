<?php
/**
 * Elementor search control.
 *
 * A control for displaying a search field with the ability to fetch results.
 *
 * @since 1.0.0
 */
class Shortcode_id extends \Elementor\Base_Data_Control {

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
        return 'search_id';
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
        <div class="shortcode_widget_id">
            <input type="hidden" id="search_id" data-setting="{{ data.name }}" value="{{ data.value }}">
        </div>
        <?php
    }
}
?>