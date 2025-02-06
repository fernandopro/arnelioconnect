<?php
// =============================================================
//                            notifications
// =============================================================
if (! class_exists('scfs_arnelioconnect_all_offcanvas')) {
    class scfs_arnelioconnect_all_offcanvas
    {

        public $urlPostype;
        public $urlTaxonomy;
        public $urlPage;
        public $limit;


        function __construct($urlPostype, $urlPage, $urlTaxonomy)
        {

            $this->urlPostype = $urlPostype;
            $this->urlTaxonomy = $urlTaxonomy;
            $this->urlPage = $urlPage;
            $this->limit = 10; // Número de posts a mostrar

            // Cargar solo en las páginas del plugin
            if (defined('IS_URL_ARNELIOCONNECT') && IS_URL_ARNELIOCONNECT) {

                add_action('admin_enqueue_scripts', array($this, 'all_javascript_offcanvas'), 9999);
                add_action('admin_footer', array($this, 'scfs_arnelioconnect_all_offcanvas'));
            }



            // Si es una solicitud AJAX
            if (defined('DOING_AJAX') && DOING_AJAX) {

                add_action('wp_ajax_scfs_arnelioconnect_clear_transients', array($this, 'scfs_arnelioconnect_clear_transients'));
                add_action('wp_ajax_scfs_arnelioconnect_mark_as_read', array($this, 'scfs_arnelioconnect_mark_as_read'));
            }
        }

        // Función para obtener datos de la API usando transients
        private function get_api_data()
        {
            $api_data = get_transient('scfs_arnelioconnect_api_blogtag');
            $reduced_posts = array();

            if (false === $api_data) {
                // No existe el transient, hacer la llamada a la API
                $tag_slugs = array('arnelioconnect','news'); // Etiquetas de los posts
                $tag_query = implode(',', $tag_slugs);

                $response = wp_remote_get("https://arnelio.com/wp-json/wp/v2/tags?slug={$tag_query}");

                if (is_wp_error($response)) {
                    // Error en la respuesta de la API
                    set_transient('scfs_arnelioconnect_api_blogtag', [], 3 * HOUR_IN_SECONDS);
                    update_option('scfs_arnelioconnect_api_blogtag_count', 0);
                    return [];
                }

                $body = wp_remote_retrieve_body($response);
                $tags = json_decode($body, true);

                // Verificar errores de JSON y existencia del tag
                if (json_last_error() !== JSON_ERROR_NONE || empty($tags)) {
                    // Error en la decodificación JSON o el tag no existe
                    set_transient('scfs_arnelioconnect_api_blogtag', [], 3 * HOUR_IN_SECONDS);
                    update_option('scfs_arnelioconnect_api_blogtag_count', 0);
                    return [];
                }

                $tag_ids = array();
                foreach ($tags as $tag) {
                    if (isset($tag['id'])) {
                        $tag_ids[] = intval($tag['id']);
                    }
                }

                // Obtener los posts con varios IDs de etiquetas
                $posts_response = wp_remote_get("https://arnelio.com/wp-json/wp/v2/posts?tags=" . implode(',', $tag_ids) . "&_embed&per_page=".$this->limit."&orderby=date&order=desc");

                if (is_wp_error($posts_response)) {
                    // Error en la respuesta de la API de posts
                    set_transient('scfs_arnelioconnect_api_blogtag', [], 3 * HOUR_IN_SECONDS);
                    update_option('scfs_arnelioconnect_api_blogtag_count', 0);
                    return [];
                }

                $posts_body = wp_remote_retrieve_body($posts_response);
                $posts = json_decode($posts_body, true);

                // Verificar errores de JSON en los posts
                if (json_last_error() !== JSON_ERROR_NONE || ! is_array($posts)) {
                    // Error en la decodificación JSON de los posts
                    set_transient('scfs_arnelioconnect_api_blogtag', [], 3 * HOUR_IN_SECONDS);
                    update_option('scfs_arnelioconnect_api_blogtag_count', 0);
                    return [];
                }

                // Procesar y reducir los datos de los posts
                foreach ($posts as $post) {
                    // Calcular tiempo relativo
                    $post_date    = strtotime($post['date']);
                    $current_time = current_time('timestamp');
                    $time_diff    = human_time_diff($post_date, $current_time);
                    $relative_time = sprintf(__('%s ago'), $time_diff);

                    // Obtenemos el excerpt y eliminamos el enlace "Continue reading →"
                    $excerpt = $post['excerpt']['rendered'];
                    $excerpt = preg_replace('/<a[^>]*>Continue reading &rarr;<\/a>/', '', $excerpt);
                    $excerpt = trim($excerpt);

                    $reduced_posts[] = array(
                        'title'         => $post['title']['rendered'],
                        'excerpt'       => $excerpt,
                        'relative_time' => $relative_time,
                        'link'          => $post['link'],
                        'id'            => $post['id']
                    );
                }

                // Almacenar el array reducido en el transient por 1 día
                set_transient('scfs_arnelioconnect_api_blogtag', $reduced_posts, DAY_IN_SECONDS);
            } else {
                // Usar los datos del transient
                $reduced_posts = $api_data;
            }

            // Separar artículos leídos y no leídos (se ejecuta siempre)
            $read_posts = get_option('scfs_arnelioconnect_read_posts', array());
            $unread_posts = array();
            $read_array   = array();

            foreach ($reduced_posts as $item) {
                if (in_array($item['id'], $read_posts)) {
                    $read_array[] = $item;
                } else {
                    $unread_posts[] = $item;
                }
            }

            // Actualizar contador solo con los posts no leídos
            $unread_count = count($unread_posts);
            update_option('scfs_arnelioconnect_api_blogtag_count', $unread_count);

            return array(
                'unread' => $unread_posts,
                'read'   => $read_array
            );
        }



        // Render Notifications offcanvas
        public function scfs_arnelioconnect_all_offcanvas()
        {
?>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNotifications" aria-labelledby="offcanvasNotificationsLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNotificationsLabel">
                        <i style="font-size: 1.9rem;" class="bi bi-megaphone-fill"></i>&nbsp;&nbsp;
                        <span><?php echo __('News') ?></span>&nbsp;&nbsp;
                        <span id="notification-api-num2" class="badge rounded-pill bg-danger">
								<span class="visually-hidden">unread messages</span>
						</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
               <div class="offcanvas-links">
                    <a id="offcanvas_dismiss" class="offcanvas_dismiss icon-link icon-link-hover" href="#"><?php echo __('Read All','arnelioconnect')?></a>
               </div>
                <div class="offcanvas-body">
                    <ul class="nav nav-tabs" id="arnelioconnect-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="unread-tab" data-bs-toggle="tab" data-bs-target="#unread" type="button" role="tab" aria-controls="unread" aria-selected="true">
                            <?php echo _x('Inbox', 'Status indicating messages or items that have not been read yet', 'arnelioconnect'); ?>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="read-tab" data-bs-toggle="tab" data-bs-target="#read" type="button" role="tab" aria-controls="read" aria-selected="false">
                            <?php echo _x('Articles read', 'Past tense - indicating something has been read', 'arnelioconnect'); ?>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="arnelioconnect-tabContent">
                        <div class="tab-pane fade show active" id="unread" role="tabpanel" aria-labelledby="unread-tab">
                            <div class="container-notification" id="arnelioconnect-notifications-unread"></div>
                        </div>
                        <div class="tab-pane fade" id="read" role="tabpanel" aria-labelledby="read-tab">
                            <div class="container-notification" id="arnelioconnect-notifications-read"></div>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }


        // Eliminar transients
        public function scfs_arnelioconnect_clear_transients()
        {
            check_ajax_referer('scfs_arnelioconnect_offcanvas_nonce', '_wpnonce');
            
            // Borrar transient actual
            delete_transient('scfs_arnelioconnect_api_blogtag');
            
            // Obtener datos frescos de la API
            $posts = $this->get_api_data();

            // Enviar los posts actualizados en la respuesta
            wp_send_json_success(array(
                'unread'      => $posts['unread'],
                'read'        => $posts['read'],
                'posts_count' => count($posts['unread'])
            ));
        }

        // Nuevo método para marcar como leído y guardar en BD
        public function scfs_arnelioconnect_mark_as_read()
        {
            check_ajax_referer('scfs_arnelioconnect_offcanvas_nonce', '_wpnonce');
            $post_id   = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
            $read_data = get_option('scfs_arnelioconnect_read_posts', array());

            // Si el ID no existe en el array
            if (!in_array($post_id, $read_data)) {
                // Si alcanzamos el límite, eliminamos el ID más antiguo (el primero del array)
                if (count($read_data) >= $this->limit) {
                    array_shift($read_data); // Elimina el primer elemento del array (el más antiguo)
                }
                // Añadimos el nuevo ID al final del array
                $read_data[] = $post_id;
                update_option('scfs_arnelioconnect_read_posts', $read_data);

                // Obtener el conteo actual y restar 1
                $current_count = get_option('scfs_arnelioconnect_api_blogtag_count', 0);
                $new_count = max(0, $current_count - 1); // Aseguramos que no sea negativo
                update_option('scfs_arnelioconnect_api_blogtag_count', $new_count);
            }

            wp_send_json_success();
        }


        // JS para el offcanvas
        public function all_javascript_offcanvas()
        {

            // Obtener los datos de la API
            $reduced_posts = $this->get_api_data();
            // Calcular posts_count
            $posts_count = get_option('scfs_arnelioconnect_api_blogtag_count', 0);

            wp_enqueue_script('scfs_arnelioconnect_all_offcanvas', ARNELIOCONNECT_DIR_URL . 'dist/admin/js/scfs_arnelioconnect_all_offcanvas.js', array('jquery', 'wp-i18n'), ARNELIOCONNECT_VERSION, true);
            wp_set_script_translations( 'scfs_arnelioconnect_all_offcanvas', 'arnelioconnect', ARNELIOCONNECT_DIR_PATH . 'languages');
            wp_localize_script('scfs_arnelioconnect_all_offcanvas', 'all_js', array(
                'messages' => array(
                    'm1' => __('(not found)'),
                    'm2' => __('Reading')
                ),
                'posts'       => $reduced_posts,
                'posts_count' => $posts_count,
                'ajaxurl'     => admin_url('admin-ajax.php'),
                'nonce'       => wp_create_nonce('scfs_arnelioconnect_offcanvas_nonce')
            ));
        }
    } // Final Clase

} // Exist Clase

$scfs_notifications = new scfs_arnelioconnect_all_offcanvas($urlPostype, $urlPage, $urlTaxonomy);
