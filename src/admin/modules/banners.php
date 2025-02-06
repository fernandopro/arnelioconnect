<?php
	// =============================================================
	//                            banners
	// =============================================================
if ( ! class_exists('Scfs_arnelioconnect_banners' ) ) {
    class Scfs_arnelioconnect_banners{

        public $urlPostype;
        public $urlTaxonomy;
        public $urlPage;


        function __construct($urlPostype,$urlPage,$urlTaxonomy) {

            $this->urlPostype = $urlPostype;
            $this->urlTaxonomy = $urlTaxonomy;
            $this->urlPage = $urlPage;


            // Registrar los avisos al inicializar el administrador
            add_action('admin_init', array($this, 'register_notices'));

            add_action('admin_init', array($this, 'scfs_arnelioconnect_classic_notices_all_wordpress'));


            // Cargar solo en las páginas del plugin
		    if (defined('IS_URL_ARNELIOCONNECT') && IS_URL_ARNELIOCONNECT) {

                // Añadir banners en el header de todas las páginas
               //add_action('scfs_arnelioconnect_layout_fields_header', array($this, 'baner_2'));

               add_action('scfs_arnelioconnect_layout_fields_header', array($this, 'baner_2'));
 
            }

            // Añadir hook para current_screen
            add_action('current_screen', array($this, 'check_current_screen'));

            // Si es una solicitud AJAX
            if ( defined('DOING_AJAX') && DOING_AJAX ) {


            }

        }

        // Renderizar el banner en la página de configuración del plugin
        public function check_current_screen() {
            $screen = get_current_screen();
            if ( $screen->id == 'edit-alimentacion-cat' ) {
                //add_action('scfs_arnelioconnect_notices_all_header', array($this, 'baner_2'));
            }
            if ( $screen->id == 'edit-alimentacion' ) {
                //add_action('scfs_arnelioconnect_notices_all_header', array($this, 'baner_2'));
            }
            if ( $screen->id == 'alimentacion' ) {
                //add_action('scfs_arnelioconnect_notices_all_header', array($this, 'baner_1'));
            }
        }

        // Función para cargar classic notices 
       public static function scfs_arnelioconnect_classic_notices_all_wordpress($value=null, $onlyPlugin = false) {
            if ($onlyPlugin && !defined('IS_URL_ARNELIOCONNECT')) {
                return;
            }
            if ($value == null) {
                return;
            }
            add_action('admin_notices', $value );
            add_action('scfs_arnelioconnect_notices_all_header', $value );
        }


       // Registrar Classic notices - Añade true para mostrar los avisos solo en las páginas del plugin
        public function register_notices() {
           //self::scfs_arnelioconnect_classic_notices_all_wordpress(array($this, 'baner_2'));
        }
        


        //Notice de prueba
        public function baner_1() {
            ?>

            <div class="notice notice-info is-dismissible">
                <h2>¡Asegúrate de que los correos electrónicos de tus formularios eviten la carpeta de spam!</h2>
                <p>Usar el servicio de envío del sitio para mejorar la entrega de correos electrónicos, registros detallados de correos y fácil configuración.</p>
                <a href="#" class="button"><span>Instalar plugin</span></a>
            </div>

        
            <?php
        }

          //Notice de prueba
          public function baner_2() {
           
        }


    }// Final Clase

}// Exist Clase

$scfs_banners = new Scfs_arnelioconnect_banners($urlPostype,$urlPage,$urlTaxonomy);

