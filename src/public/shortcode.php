<?php
if (!class_exists('Shortcode_arnelioconnect')) {
    class Shortcode_arnelioconnect
    {

        public function __construct()
        {

            add_shortcode('arnelioconnect', array($this, 'arnelioconnect_shortcode'));
        }

        public function arnelioconnect_shortcode($atts = array(), $content = null, $tag = '')
        {
            //$atts = array_change_key_case( (array) $atts, CASE_LOWER );

            extract(shortcode_atts(array(
                'shortcode' => 'valid',
                'id'        => '',
                'name'      => ''
            ), $atts, $tag));
            if (!empty($id)) {
                $id = absint($id);
            } else {
                $id = 0;
            }



           





        } // fin function shortcode

    } // Final Clase
} // Exist Clase



$Shortcode_arnelioconnect = new Shortcode_arnelioconnect();
