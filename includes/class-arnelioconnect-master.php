<?php

class Arnelioconnect {

	protected $loader;

	protected $plugin_name;


	protected $version;

	public function __construct() {
		if ( defined( 'ARNELIOCONNECT_VERSION' ) ) {
			$this->version = ARNELIOCONNECT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'arnelioconnect';



		// Propiedades
		$urlPostype = (isset($_GET['post_type'])) ? sanitize_key($_GET['post_type']) : false;
		$urlPage = (isset($_GET['page'])) ? sanitize_key($_GET['page']) : false;
		$urlTaxonomy = (isset($_GET['taxonomy'])) ? sanitize_text_field($_GET['taxonomy']) : false;

		// constantes para la url actual del plugin
		require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/modules/is_url_arnelioconnect.php';

		// Output Plugin
		require_once ARNELIOCONNECT_DIR_PATH .'includes/class-output-plugin.php';

		// fields_content
		require_once ARNELIOCONNECT_DIR_PATH .'src/admin/lib/wp_content_edd/fields_content.php';

		// BLOQUES GUTENBERG
		//require_once ARNELIOCONNECT_DIR_PATH . 'blocks/blocks.php';

		// WIDGETS ELEMENTOR
		//require_once ARNELIOCONNECT_DIR_PATH . 'elementor/elementor.php';

		// Functions
		require_once ARNELIOCONNECT_DIR_PATH .'includes/functions.php';

		// Fields
		require_once ARNELIOCONNECT_DIR_PATH .'includes/fields.php';


		// Custom Post Type Tarots
		require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/cpt/alimentacion/class-alimentacion.php';

		// Page Dashboard
		require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/pages/dashboard/class-dashboard.php';

		// Page plantilla
		require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/pages/plantilla/class-plantilla.php';

		// Banners
		require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/modules/banners.php';

		// all_offcanvas
		require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/modules/all_offcanvas.php';

		// MÓDULOS
		

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();



	}


	// =============================================================
	//       				DEPENDENCIAS
	// =============================================================
	private function load_dependencies() {
	
		require_once ARNELIOCONNECT_DIR_PATH . 'includes/class-arnelioconnect-loader.php';
		require_once ARNELIOCONNECT_DIR_PATH . 'includes/class-arnelioconnect-i18n.php';
		require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/class-arnelioconnect-admin.php';
		require_once ARNELIOCONNECT_DIR_PATH . 'src/public/class-arnelioconnect-public.php';

		$this->loader = new Arnelioconnect_Loader();

	}

	// =============================================================
	//       				IDIOMAS
	// =============================================================
	private function set_locale() {

		$plugin_i18n = new Arnelioconnect_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}


	// =============================================================
	//       				ALL ADMIN - HOOKS
	// =============================================================
	private function define_admin_hooks() {

		$plugin_admin = new Arnelioconnect_Admin( $this->get_plugin_name(), $this->get_version() );
		

		// Cargar solo en las páginas del plugin
		if (defined('IS_URL_ARNELIOCONNECT') && IS_URL_ARNELIOCONNECT) {


			// Cabecera
			$this->loader->add_action( 'in_admin_header', $plugin_admin, 'cabecera_arnelioconnect' );

			// LINK Review in footer web for arnelioconnect
			$this->loader->add_action( 'admin_footer_text', $plugin_admin, 'scfs_arnelioconnect_brand_footer' );

			// Cargar el footer
			add_action('admin_footer', 'scfs_arnelioconnect_page_footer');

		}

		// Eliminar todos los avisos de WordPress
		$this->loader->add_action('admin_init', $plugin_admin, 'arnelioconnect_remove_all_notices');

		// Update plugin desde el exterior
		$this->loader->add_action('upgrader_process_complete', $plugin_admin, 'scfs_upgrader_process_complete', 10, 2);

		// Update plugin desde un archivo ZIP
		$this->loader->add_action('upgrader_post_install', $plugin_admin, 'scfs_upgrader_post_install', 10, 3);


	}


	// =============================================================
	//       				PUBLIC HOOKS
	// =============================================================
	private function define_public_hooks() {

		$plugin_public = new Arnelioconnect_Public( $this->get_plugin_name(), $this->get_version() );


				// Shortcode
				require_once ARNELIOCONNECT_DIR_PATH . 'src/public/shortcode.php';

	}


	// =============================================================
	//       				RUN CARGADOR
	// =============================================================
	public function run() {
		$this->loader->run();
	}


	public function get_plugin_name() {
		return $this->plugin_name;
	}


	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
