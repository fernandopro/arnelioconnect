<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://arnelio.com
 * @since      1.0.0
 *
 * @package    Arnelioconnect
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Elimina todas las opciones, custom post type, taxonomías y metadatos asociados con el plugin.
 */

// 1. Eliminar opciones del plugin (opción principal definida en arnelioconnect.php).
delete_option( ARNELIOCONNECT_MENU_URL . '_options' );

// 2. (Opcional) Eliminar otras opciones relacionadas utilizando un prefijo en el nombre.
// global $wpdb;
// $wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'scfs_arnelioconnect%'" );

// 3. Eliminar todos los posts del custom post type "alimentacion".
$alimentacion_posts = get_posts( array(
	'post_type'   => 'alimentacion',
	'numberposts' => -1,
	'post_status' => 'any'
) );
if ( ! empty( $alimentacion_posts ) ) {
	foreach ( $alimentacion_posts as $post ) {
		wp_delete_post( $post->ID, true ); // Eliminación permanente.
	}
}

// 4. Eliminar todos los términos de las taxonomías "alimentacion-cat" y "alimentacion-tag".
$taxonomies = array( 'alimentacion-cat', 'alimentacion-tag' );
foreach ( $taxonomies as $taxonomy ) {
	$terms = get_terms( array(
		'taxonomy'   => $taxonomy,
		'hide_empty' => false,
	) );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			wp_delete_term( $term->term_id, $taxonomy );
		}
	}
}

// 5. Eliminar metadatos asociados a "scfs_". Esto remueve datos en wp_postmeta.
global $wpdb;
$wpdb->query(
	"DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE 'scfs_%'"
);

// 6. Si el plugin creó tablas personalizadas u otros datos, incorporarlos aquí.
// ...existing custom table deletion code...
