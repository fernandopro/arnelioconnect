<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */


function scfs_register_blocks() {
    // Registra el bloque usando metadata de block.json
  register_block_type( __DIR__ . '/build/blocks/tarots' );

  // Configura las traducciones para el script del editor
	wp_set_script_translations(
		'arnelioconnect-editor-script', // Handle generado automáticamente
		'arnelioconnect', // Text domain
		ARNELIOCONNECT_DIR_PATH . 'languages'
	);
}
add_action( 'init', 'scfs_register_blocks' );
