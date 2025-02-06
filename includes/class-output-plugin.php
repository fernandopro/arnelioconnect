<?php
// =============================================================
//                            output_plugin
// =============================================================
if (! class_exists('Scfs_arnelioconnect_output_plugin')) {
    class Scfs_arnelioconnect_output_plugin
    {

        public $urlPostype;
        public $urlTaxonomy;
        public $urlPage;

        const NAME_PAGE = 'scfs_arnelioconnect_output_plugin';

        function __construct($urlPostype, $urlPage, $urlTaxonomy)
        {

            $this->urlPostype = $urlPostype;
            $this->urlTaxonomy = $urlTaxonomy;
            $this->urlPage = $urlPage;


            // Registrar los avisos al inicializar el administrador
            add_action('admin_init', array($this, 'register_notices'));


            // Cargar solo en las páginas del plugin
            if (defined('IS_URL_ARNELIOCONNECT') && IS_URL_ARNELIOCONNECT) {

            }else{
                // Agregar item al menú del admin bar
                add_action('admin_bar_menu', array($this, 'agregar_item_menu_admin_bar'), 9999, 1);
            }



            // Si es una solicitud AJAX
            if (defined('DOING_AJAX') && DOING_AJAX) {
            }

            add_action('admin_enqueue_scripts', array($this, 'scfs_output_plugin_enqueue_styles'), 1);
        }


        // Registrar los avisos
        public function register_notices()
        {
            //Scfs_arnelioconnect_banners::scfs_arnelioconnect_classic_notices_all_wordpress(array($this, ''));
        }



        // Agregar item al menú del admin bar
        public function agregar_item_menu_admin_bar($wp_admin_bar)
        {

            $posts_count = get_option('scfs_arnelioconnect_api_blogtag_count', 0);

            if ($posts_count > 0) {
                $count = '<span class="arnelioconnect_admin_bar__count">' . $posts_count . '</span>';
            } else {
                $count = '';
            };

            $wp_admin_bar->add_node([
                'id'    => 'arnelioconnect_admin_bar', // Identificador único
                'title' => 'arnelioconnect ' . $count, // Texto del elemento
                'href'  => admin_url('admin.php?page=scfs_arnelioconnect_dashboard'),                    // Enlace (puedes poner una URL personalizada)
                'meta'  => [
                    'class' => 'arnelioconnect_admin_bar', // Clase CSS
                ],
            ]);

            // // Agregar un subelemento (submenu) al elemento principal
            // $wp_admin_bar->add_node([
            //     'id'     => 'arnelioconnect_admin_bar_submenu_1',
            //     'parent' => 'arnelioconnect_admin_bar', // ID del elemento padre
            //     'title'  => 'Opción 1',              // Texto del submenú
            //     'href'   => admin_url('admin.php?page=scfs_arnelioconnect_dashboard'), // Enlace (puedes personalizarlo)
            // ]);

            // // Otro subelemento
            // $wp_admin_bar->add_node([
            //     'id'     => 'arnelioconnect_admin_bar_submenu_2',
            //     'parent' => 'arnelioconnect_admin_bar',
            //     'title'  => 'Opción 2',
            //     'href'   => 'https://tusitio.com',
            // ]);
        }




        ////////////////////////////////////  SCRIPTS  ////////////////////////////////////////

        // CSS
        function scfs_output_plugin_enqueue_styles()
        {

            if (is_rtl()) {
                wp_enqueue_style(self::NAME_PAGE, ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '-rtl.css', array(), ARNELIOCONNECT_VERSION, 'all');
            } else {
                wp_enqueue_style(self::NAME_PAGE, ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '.css', array(), ARNELIOCONNECT_VERSION, 'all');
            }
        }
    } // Final Clase

} // Exist Clase

$scfs_output_plugin = new Scfs_arnelioconnect_output_plugin($urlPostype, $urlPage, $urlTaxonomy);
