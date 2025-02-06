<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://arnelio.com
 * @since      1.0.0
 *
 * @package    Arnelioconnect
 * @subpackage Arnelioconnect/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Arnelioconnect
 * @subpackage Arnelioconnect/includes
 * @author     arnelio <service@arnelio.com>
 */
class Arnelioconnect_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	// public function load_plugin_textdomain() {

	// 	load_plugin_textdomain(
	// 		'arnelioconnect',
	// 		false,
	// 		dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
	// 	);

	// }


	public function load_plugin_textdomain() {
    $domain = 'arnelioconnect';
    $locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
    $mofile = dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' . $domain . '-' . $locale . '.I10n.php';

    if ( file_exists( $mofile ) ) {
        // Carga las traducciones desde el archivo I10n.php
        load_textdomain( $domain, $mofile );
    } else {
        // Carga las traducciones desde los archivos .mo
        load_plugin_textdomain(
            $domain,
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );
    }
}


}
