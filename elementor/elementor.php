<?php
// =============================================================
//       			 Elementor
// =============================================================
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function scfs_elementor() {

	// Load plugin file
	require_once( ARNELIOCONNECT_DIR_PATH . 'elementor/includes/plugin.php' );

	// Run the plugin
	\Arnelioconnect_Elementor\Plugin::instance();

}
add_action( 'plugins_loaded', 'scfs_elementor' );