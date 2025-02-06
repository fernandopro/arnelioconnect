<?php

/**
 * @wordpress-plugin
 * Plugin Name:       arnelioconnect
 * Plugin URI:        https://arnelio.com
 * Description:       Descripcion del plugin
 * Version:           1.1
 * Author:            arnelio
 * Author URI:        https://arnelio.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       arnelioconnect
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Escribir siempre la primera letra en mayúscula.
 * Es importante hacerlo en el orden que está aquí.
 * 
 * 
 * Alimentacion           Nombre del CPT
 * Alimentos              Nombre en plural
 * Alimento               Nombre en singular
 * Categorias             Nombre en plural de la taxonomía. El slug de la taxonomía es alimentacion-cat
 * Categoria              Nombre en singular de la taxonomía.
 * Etiquetas              Nombre en plural de la taxonomía. El slug de la taxonomía es alimentacion-tag
 * Etiqueta               Nombre en singular de la taxonomía.
 * Scfs_                Prefijo - Debe empezar con una mayúscula y seguir siempre en minúsculas.
 * Arnelioconnect              Nombre del plugin
 * 
 * arnelio                Nombre de la empresa
 */
define( 'ARNELIOCONNECT_VERSION', '1.1' );


 //Nombre de la página principal del menú
define('ARNELIOCONNECT_MENU_URL',  'scfs_arnelioconnect_dashboard');


// Constantes del plugin
define('ARNELIOCONNECT__FILE__', __FILE__);
define('ARNELIOCONNECT_PLUGIN_BASE', plugin_basename(ARNELIOCONNECT__FILE__));
define('ARNELIOCONNECT_PATH', plugin_dir_path(ARNELIOCONNECT__FILE__));
define('ARNELIOCONNECT_URL', plugins_url('/', ARNELIOCONNECT__FILE__));
define('ARNELIOCONNECT_NAME_BASENAME', dirname(plugin_basename(__FILE__)) . '/');
define('ARNELIOCONNECT_DIR_PATH', plugin_dir_path(__FILE__));
define('ARNELIOCONNECT_DIR_URL', plugin_dir_url(__FILE__));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-arnelioconnect-activator.php
 */
function activate_arnelioconnect() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-arnelioconnect-activator.php';
	Arnelioconnect_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-arnelioconnect-deactivator.php
 */
function deactivate_arnelioconnect() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-arnelioconnect-deactivator.php';
	Arnelioconnect_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_arnelioconnect' );
register_deactivation_hook( __FILE__, 'deactivate_arnelioconnect' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-arnelioconnect-master.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_arnelioconnect() {

	$plugin = new Arnelioconnect();
	$plugin->run();

}
run_arnelioconnect();
