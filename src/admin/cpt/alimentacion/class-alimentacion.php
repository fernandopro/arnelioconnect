<?php
// =============================================================
//                    Alimentacion - Custom Post Type
// =============================================================
if (! class_exists('Scfs_arnelioconnect_alimentacion')) {
    class Scfs_arnelioconnect_alimentacion
    {

        private $urlPostype;
        public $urlTaxonomy;
        private $urlPage;
        private $get_options;
        private $default_options;
        private $initial_options;
        private $tabs;
        private $auto_save_click;
        private $auto_save_change;
        private $field_buttons;
        private $field_buttons_multi;
        private $compareTimeField;


        //Nombre de la página
        const NAME_PAGE   = 'scfs_arnelioconnect_alimentacion';
        const NAME_OPTION = self::NAME_PAGE . '_options';
        const ID_FORM     = 'post';



        function __construct($urlPostype, $urlPage, $urlTaxonomy)
        {

            $this->urlPostype  = $urlPostype;
            $this->urlTaxonomy = $urlTaxonomy;
            $this->urlPage     = $urlPage;

            // Opciones por defecto
            require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/cpt/alimentacion/data-alimentacion.php';


            // Asignar las configuraciones
            $this->auto_save_click     = $auto_save_click;
            $this->auto_save_change    = $auto_save_change;
            $this->field_buttons       = $field_buttons;
            $this->field_buttons_multi = $field_buttons_multi;
            $this->compareTimeField      = $compareTimeField;
            $this->default_options     = $default_options;
            $this->initial_options     = $initial_options;
            $this->tabs                = $tabs;




            add_action('init', array($this, 'alimentacion'), 2);

            if (is_admin()) {
                add_action('save_post_alimentacion', array($this, 'save_post'), 10, 2);
                add_filter('manage_alimentacion_posts_columns', array($this, 'scfs_pro_filter_posts_columns'));
                add_filter('manage_alimentacion_posts_columns', array($this, 'scfs_pro_realestate_columns'));
                add_action('manage_alimentacion_posts_custom_column', array($this, 'scfs_pro_realestate_column'), 10, 2);


                // Alimentacion - Menú
                add_action('admin_menu', array($this, 'add_alimentacion_submenu'), 5);  // El número (5) determina el orden
                add_filter('parent_file', array($this, 'alimentacion_menu_position'), 10);

                // Categorias - Menú
                add_action('admin_menu', array($this, 'categorias_menu'), 2);
                add_action('parent_file', array($this, 'categorias_menu_position'), 2);

                // Etiquetas
                add_action('init', array($this, 'alimentacion_tags'), 2);
                add_action('admin_menu', array($this, 'tags_menu'), 2);
                add_action('parent_file', array($this, 'tags_menu_position'), 2);

                // Filtros para taxonomías
                add_action('restrict_manage_posts', array($this, 'filtros_taxonomys'), 10, 2);

                // quitar filtro fecha en posts
                add_filter('months_dropdown_results', '__return_empty_array');
                add_action('before_delete_post', array($this, 'eliminar_imagen_destacada'));
            }

            // Añadir acción para eliminar términos | DESACTIVADO
            add_action('pre_delete_term', array($this, 'delete_term_and_associated_posts'), 10, 2);



            if ($this->urlPostype == 'alimentacion') {

                add_action('edit_form_advanced', array($this, 'form_register_fields'), 10, 2);
                add_action('post_submitbox_start', array($this, 'scfs_disable_trash_link'));
                // Cambiar número de posts por página
                //add_filter('edit_alimentacion_per_page', array($this, 'scfs_alimentacion_per_page'), 10, 2);

            }


            add_action('admin_init', array($this, 'register_notices'));

            // Scripts

            // alimentacion
            add_action('admin_enqueue_scripts', array($this, 'alimentos_scripts'));

            // alimentacion-cat - Taxonomy
            add_action('admin_enqueue_scripts', array($this, 'alimentacion_cat'));

            // alimentacion-tag - Etiquetas
            add_action('admin_enqueue_scripts', array($this, 'alimentacion_tag'));

            // alimentacion_item
            add_action('admin_enqueue_scripts', array($this, 'alimentacion_item'));
        } // fin construct





        public function alimentacion()
        {

            $icon = 'PHN2ZyBpZD0ibWVudSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgMTE5LjgxIDk4LjMzIj48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6I2ZmZjtmaWxsLXJ1bGU6ZXZlbm9kZDt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPnRhcm9raW5hLW1lbnU8L3RpdGxlPjxwYXRoIGNsYXNzPSJjbHMtMSIgZD0iTTExNi4xNSw2Ni4zOUM5OS45Myw3NC4yMyw4My42NSw4Miw2Ny41LDkwYTM2LjQyLDM2LjQyLDAsMCwxLTI2LjcsMi43MmMtMTEuMzctMy4wOC0yMi44LTYtMzQuMTctOUE1LjkzLDUuOTMsMCwwLDAsLjgyLDg1YzEuMjYuMzcsMi4yOS42OSwzLjMyLDEsMTUuMzksNCwzMC43OCw4LDQ2LjE1LDEyLjEzYTcsNywwLDAsMCw1LjE3LS41NFE4My42LDgzLjg0LDExMS43OCw3MC4yOGMyLjU0LTEuMjIsNS0yLjQ4LDcuOS0zLjg3QTMuMTMsMy4xMywwLDAsMCwxMTYuMTUsNjYuMzlaIi8+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNNDIuMjEsNjEuODVjNC44OCwxLjU0LDguNzcsMS4yMywxMy4xNy0xLjQ3LDYtMy42OCwxMi03LjIzLDE2LjYzLTEyLjc3LDcuNjQtOS4xLDEwLjg0LTE5LjUxLDguNDItMzEuNTZhMy4yOCwzLjI4LDAsMCwwLTIuNjEtMi44M0M2My4zLDksNDguOCw0LjcsMzQuMjkuNDNjLTIuNi0uNzYtMi42LS43NC0yLjE5LDJhMzQuMTIsMzQuMTIsMCwwLDEtMi44NiwyMC40MkE1MC4zNyw1MC4zNywwLDAsMSw0LjMxLDQ3LjEzYy0xLjQzLjY2LTIuODcsMS4zLTQuMzEsMS45NWwuMTQuNTNjLjU0LjE3LDEuMDguMzYsMS42My41MkMxNS4yNiw1NCwyOC44Myw1Ny42MSw0Mi4yMSw2MS44NVoiLz48cGF0aCBjbGFzcz0iY2xzLTEiIGQ9Ik01MC41Myw3NC42NmE2LjEsNi4xLDAsMCwwLDQuNTctLjQ0UTgwLjE5LDYyLDEwNS4zNSw0OS45MUwxMTkuNTcsNDNjLS41Mi0uMzYtLjY3LS41NC0uODYtLjU5LTEwLjA3LTIuNjctMjAuMTQtNS4zLTMwLjItOEM4NywzNCw4Ni42NSwzNC44Miw4Ni4yNiwzNiw4Mi4xNCw0OC43OSw3My44Nyw1Ny44NSw2Mi44LDY0LjM2Yy0zLjIxLDEuODgtNi41MiwzLjU3LTkuNyw1LjQ5YTcuNCw3LjQsMCwwLDEtNi4zOS44M0MzNC4wOCw2NywyMS4zOSw2My40Nyw4Ljc4LDU5LjY3Yy0zLjEtLjk0LTUuMzYuMS04LjExLDEuODdsMy41LjkzQzE5LjYzLDY2LjUyLDM1LjA5LDcwLjU1LDUwLjUzLDc0LjY2WiIvPjxwYXRoIGNsYXNzPSJjbHMtMSIgZD0iTTExMy43Myw1NC45MUM5OC4zMSw2Mi40Miw4Mi44MSw2OS43Myw2Ny40NCw3Ny4zNUEzNi4yMSwzNi4yMSwwLDAsMSw0MSw4MC4wOGMtMTAtMi43LTIwLTUuMDgtMjkuOTUtOC0zLjg0LTEuMTQtNi44My0uMTMtMTAuMjUsMiwuNjkuMjQsMSwuMzksMS4zNi40OHEyNC4yMyw2LjM1LDQ4LjQzLDEyLjczYTYuMDgsNi4wOCwwLDAsMCw0LjU2LS40NVE4My41Myw3My4wNiwxMTIsNTkuMzRjMi40NS0xLjE4LDQuODktMi4zOCw3LjgxLTMuODFDMTE3LjQ0LDU0LjczLDExNS43Nyw1My45MiwxMTMuNzMsNTQuOTFaIi8+PC9zdmc+';


            // Taxonomía Categoria
            $labels_categorias = array(
                'name'          => _x('Categorias', 'taxonomy general name', 'arnelioconnect'),
                'singular_name' => _x('Categoria', 'taxonomy singular name', 'arnelioconnect'),
                'search_items'  => __('Search', 'arnelioconnect'),
                'all_items'     => __('All'),
                'edit_item'     => __('Edit Categoria', 'arnelioconnect'),
                'update_item'   => __('Updated Categoria', 'arnelioconnect'),
                'add_new_item'  => __('New Categoria', 'arnelioconnect'),
                'new_item_name' => __('New Categoria', 'arnelioconnect'),
                'menu_name'     => __('Categorias', 'arnelioconnect'),
                'not_found'     => __('No categorias found', 'arnelioconnect')
            );

            $args_categorias = array(
                'public'             => false,
                'publicly_queryable' => false,
                'hierarchical'       => true,
                'labels'             => $labels_categorias,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'show_admin_column'  => true,
                'query_var'          => true,
                'show_in_rest'       => true,                                                         // rest api
                'rewrite'            => array('slug' => 'alimentacion-cat', 'with_front' => false),
                'capabilities'       => array(
                    'manage_terms' => 'publish_posts',
                    'edit_terms'   => 'edit_posts',
                    'delete_terms' => 'edit_others_posts',
                    'assign_terms' => 'edit_posts',
                ),
            );

            if (current_user_can('publish_posts') || current_user_can('edit_posts') || current_user_can('edit_others_posts')) {
                register_taxonomy('alimentacion-cat', array('alimentacion'), $args_categorias);
            }


            // Custom Post Type  alimentos
            $labels_alimentos = array(
                'name'                  => _x('Alimentos', 'General name', 'arnelioconnect'),
                'singular_name'         => _x('Alimento', 'Singular name', 'arnelioconnect'),
                'menu_name'             => '',
                'name_admin_bar'        => _x('New Alimentos', 'Add New on Toolbar', 'arnelioconnect'),
                'add_new'               => __('New Alimento', 'arnelioconnect'),
                'add_new_item'          => __('Add'),
                'new_item'              => __('New Alimento', 'arnelioconnect'),
                'edit_item'             => __('Edit'),
                'view_item'             => __('View Alimento', 'arnelioconnect'),
                'all_items'             => __('Alimentos', 'arnelioconnect'),
                'search_items'          => __('Search', 'arnelioconnect'),
                'not_found'             => __('No Alimentos found.', 'arnelioconnect'),
                'not_found_in_trash'    => __('No Alimentos found in Trash.', 'arnelioconnect'),
                'featured_image'        => __('Image Alimento', 'arnelioconnect'),
                'set_featured_image'    => __('Set cover image', 'arnelioconnect'),
                'remove_featured_image' => __('Remove cover image', 'arnelioconnect'),
                'use_featured_image'    => __('Use as cover image', 'arnelioconnect'),
                'archives'              => __('alimentos archives', 'arnelioconnect'),
                'insert_into_item'      => __('Insert into alimentos', 'arnelioconnect'),
                'uploaded_to_this_item' => __('Uploaded to this alimentos', 'arnelioconnect'),
                'filter_items_list'     => __('Filter alimentos list', 'arnelioconnect'),
                'items_list_navigation' => __('alimentos list navigation', 'arnelioconnect'),
                'items_list'            => __('alimentos list', 'arnelioconnect')
            );

            $args_alimentos = array(
                'labels'             => $labels_alimentos,
                'show_in_rest'       => true,                                                     // rest api
                'public'             => true,
                'publicly_queryable' => false,
                'has_archive'        => false,
                'map_meta_cap'       => true,
                '_edit_link'         => 'post.php?post_type=alimentacion&post=%d',
                'show_ui'            => true,
                'show_in_menu'       => false,
                'query_var'          => true,
                'rewrite'            => array('slug' => 'alimentacion', 'with_front' => false),
                'capability_type'    => 'post',
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => 'data:image/svg+xml;base64,' . $icon,
                'supports'           => array('title', 'thumbnail'),
                'can_export'         => true,
                'taxonomies'         => array('alimentacion-cat', 'alimentacion-tag')
            );

            if (current_user_can('publish_posts') || current_user_can('edit_posts') || current_user_can('edit_others_posts')) {
                register_post_type('alimentacion', $args_alimentos);
            }
        }


        public function alimentacion_tags()
        {
            // Registrar la taxonomía personalizada 'alimentacion-tag' para etiquetas
            $labels_tags = array(
                'name'          => _x('Etiquetas', 'taxonomy general name', 'arnelioconnect'),
                'singular_name' => _x('Etiqueta', 'taxonomy singular name', 'arnelioconnect'),
                'search_items'  => __('Buscar Etiquetas', 'arnelioconnect'),
                'all_items'     => __('Todas las Etiquetas', 'arnelioconnect'),
                'edit_item'     => __('Editar Etiqueta', 'arnelioconnect'),
                'update_item'   => __('Actualizar Etiqueta', 'arnelioconnect'),
                'add_new_item'  => __('Agregar Nueva Etiqueta', 'arnelioconnect'),
                'new_item_name' => __('Nueva Etiqueta', 'arnelioconnect'),
                'menu_name'     => __('Etiquetas', 'arnelioconnect'),
                'not_found'     => __('No se encontraron etiquetas', 'arnelioconnect')
            );

            $args_tags = array(
                'hierarchical'       => false,
                'labels'             => $labels_tags,
                'show_ui'            => true,
                'show_admin_column'  => true,
                'query_var'          => true,
                'show_in_rest'       => true,                                  // Para compatibilidad con el editor Gutenberg
                'rewrite'            => array('slug' => 'alimentacion-tag'),
                'public'             => false,
                'publicly_queryable' => false,
                'capabilities'       => array(
                    'manage_terms' => 'publish_posts',
                    'edit_terms'   => 'edit_posts',
                    'delete_terms' => 'edit_others_posts',
                    'assign_terms' => 'edit_posts',
                ),
            );

            // Registrar la taxonomía si el usuario tiene los permisos adecuados
            if (current_user_can('publish_posts') || current_user_can('edit_posts') || current_user_can('edit_others_posts')) {
                register_taxonomy('alimentacion-tag', array('alimentacion'), $args_tags);
            }
        }



        // Custom post type Alimentacion -  menu position
        public function add_alimentacion_submenu()
        {
            $position = 1;
            add_submenu_page(
                ARNELIOCONNECT_MENU_URL,                             // Slug del menú padre
                __('Alimentos', 'arnelioconnect'),   // Título de la página
                __('Alimentos', 'arnelioconnect'),   // Texto del menú
                'edit_posts',                             // Capacidad requerida
                'edit.php?post_type=alimentacion', // Slug de la página
                '',                             // Función de callback (no necesaria)
                $position                     // Posición en el menú
            );
        }
        public function alimentacion_menu_position($parent_file)
        {
            global $submenu_file, $post_type;

            if ($post_type == 'alimentacion') {
                $screen = get_current_screen();

                if ($screen->base == 'post' || $screen->base == 'edit') {
                    $parent_file  = ARNELIOCONNECT_MENU_URL;
                    $submenu_file = 'edit.php?post_type=alimentacion';
                }
            }

            return $parent_file;
        }



        // Taxonomía Categorias menu position
        function categorias_menu()
        {
            if (current_user_can('publish_posts') || current_user_can('edit_posts') || current_user_can('edit_others_posts')) {
                add_submenu_page(ARNELIOCONNECT_MENU_URL, 'alimentacion-cat', __('Categorias', 'arnelioconnect'), 'read', 'edit-tags.php?taxonomy=alimentacion-cat&post_type=alimentacion', false);
            }
        }
        function categorias_menu_position($parent_file)
        {
            global $plugin_page;
            if ($this->urlTaxonomy == 'alimentacion-cat')
                $plugin_page = ARNELIOCONNECT_MENU_URL;
            return $parent_file;
        }


        // Ajustar la posición del menú para 'alimentacion-tag'
        function tags_menu()
        {
            if (current_user_can('publish_posts') || current_user_can('edit_posts') || current_user_can('edit_others_posts')) {
                add_submenu_page(
                    ARNELIOCONNECT_MENU_URL,
                    'alimentacion-tag',
                    __('Etiquetas', 'arnelioconnect'),
                    'read',
                    'edit-tags.php?taxonomy=alimentacion-tag&post_type=alimentacion',
                    false
                );
            }
        }
        function tags_menu_position($parent_file)
        {
            global $plugin_page;
            if ($this->urlTaxonomy == 'alimentacion-tag') {
                $plugin_page = ARNELIOCONNECT_MENU_URL;
            }
            return $parent_file;
        }




        // Función para eliminar la imagen destacada
        function eliminar_imagen_destacada($post_id)
        {
            // Verifica si el post pertenece al custom post type 'alimentacion'
            if (get_post_type($post_id) === 'alimentacion') {
                // Verifica si el post tiene una imagen destacada
                $thumbnail_id = get_post_thumbnail_id($post_id);
                if ($thumbnail_id) {
                    // Elimina la imagen destacada
                    wp_delete_attachment($thumbnail_id, true);
                }
            }
        }



        // Columnas
        public function scfs_pro_filter_posts_columns($columns)
        {
            //$columns['columna3'] = esc_html__( 'Columna 3','arnelioconnect' );
            return $columns;
        }


        // Columnas
        public function scfs_pro_realestate_columns($columns)
        {
            $columns = array(
                'cb'    => $columns['cb'],
                'title' => esc_html__('Título', 'arnelioconnect'),
                // Añadir columna para 'alimentacion-cat'
                'taxonomy-alimentacion-cat' => '<div class="column-icon">' . esc_html__('categoria', 'arnelioconnect') . '</div>',
            );

            // Verificar si la taxonomía 'alimentacion-tag' está registrada
            if (taxonomy_exists('alimentacion-tag')) {
                // Añadir columna para 'alimentacion-tag'
                $columns['taxonomy-alimentacion-tag'] = '<div class="column-icon">' . esc_html__('Etiquetas', 'arnelioconnect') . '</div>';
            }

            return $columns;
        }


        // Columnas
        public function scfs_pro_realestate_column($column, $post_id)
        {

            // Mi columna
            if ('columna3' === $column) {

                echo '<a href="' . admin_url('admin.php?page=scfs_arnelioconnect_dashboard') . '" class="">' . ucfirst(esc_html__('texto mi columna')) . '</a>';
            }
        }




        // Filtros para taxonomias
        public function filtros_taxonomys($post_type, $which)
        {
            // Aplicar solo en el post type 'alimentacion'
            if ('alimentacion' !== $post_type) return;

            // Obtener la categoria seleccionada actualmente
            $current_cat = isset($_GET['alimentacion-cat']) ? sanitize_text_field($_GET['alimentacion-cat']) : '';
            $current_tag = isset($_GET['alimentacion-tag']) ? sanitize_text_field($_GET['alimentacion-tag']) : '';

            // Filtro de categorias
            $cat_args = array(
                'taxonomy'   => 'alimentacion-cat',
                'hide_empty' => false,
            );
            $categories = get_terms($cat_args);

            if (!empty($categories) && !is_wp_error($categories)) {
                echo "<select name='alimentacion-cat' id='alimentacion-cat' class='postform'>";
                echo '<option value="">' . esc_html__('Todas las categorias', 'arnelioconnect') . '</option>';
                foreach ($categories as $category) {
                    printf(
                        '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                        esc_attr($category->slug),
                        selected($current_cat, $category->slug, false),
                        esc_html($category->name),
                        absint($category->count)
                    );
                }
                echo '</select>';
            }

            // Filtro de Etiquetas
            if (taxonomy_exists('alimentacion-tag')) {
                // Iniciar el selector
                echo "<select name='alimentacion-tag' id='alimentacion-tag' class='postform'";

                if (!empty($current_cat)) {
                    // Obtener el nombre de la categoria seleccionada
                    $current_cat_obj = get_term_by('slug', $current_cat, 'alimentacion-cat');

                    if ($current_cat_obj) {
                        // Obtener posts de la categoria seleccionada
                        $posts_in_cat = get_posts(array(
                            'post_type'   => 'alimentacion',
                            'numberposts' => -1,
                            'tax_query'   => array(
                                array(
                                    'taxonomy' => 'alimentacion-cat',
                                    'field'    => 'slug',
                                    'terms'    => $current_cat,
                                ),
                            ),
                        ));

                        if (!empty($posts_in_cat)) {
                            // Obtener IDs de los posts
                            $post_ids = wp_list_pluck($posts_in_cat, 'ID');

                            // Obtener etiquetas solo de estos posts
                            $tags = get_terms(array(
                                'taxonomy'   => 'alimentacion-tag',
                                'object_ids' => $post_ids,
                                'hide_empty' => false,
                            ));

                            if (!empty($tags) && !is_wp_error($tags)) {
                                // Hay etiquetas para esta categoria
                                echo '>';
                                echo '<option value="">' . sprintf(
                                    esc_html__('Etiquetas en %s', 'arnelioconnect'),
                                    esc_html($current_cat_obj->name)
                                ) . '</option>';

                                foreach ($tags as $tag) {
                                    printf(
                                        '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                                        esc_attr($tag->slug),
                                        selected($current_tag, $tag->slug, false),
                                        esc_html($tag->name),
                                        absint($tag->count)
                                    );
                                }
                            } else {
                                // No hay etiquetas para esta categoria
                                echo ' disabled>';
                                echo '<option value="">' . sprintf(
                                    esc_html__('No hay etiquetas en %s', 'arnelioconnect'),
                                    esc_html($current_cat_obj->name)
                                ) . '</option>';
                            }
                        } else {
                            // No hay posts en esta categoria
                            echo ' disabled>';
                            echo '<option value="">' . sprintf(
                                esc_html__('No hay contenido en %s', 'arnelioconnect'),
                                esc_html($current_cat_obj->name)
                            ) . '</option>';
                        }
                    }
                } else {
                    // Si no hay categoria seleccionada, mostrar todas las etiquetas
                    $tags = get_terms(array(
                        'taxonomy'   => 'alimentacion-tag',
                        'hide_empty' => false,
                    ));

                    if (!empty($tags) && !is_wp_error($tags)) {
                        echo '>';
                        echo '<option value="">' . esc_html__('Todas las etiquetas', 'arnelioconnect') . '</option>';
                        foreach ($tags as $tag) {
                            printf(
                                '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                                esc_attr($tag->slug),
                                selected($current_tag, $tag->slug, false),
                                esc_html($tag->name),
                                absint($tag->count)
                            );
                        }
                    } else {
                        echo ' disabled>';
                        echo '<option value="">' . esc_html__('No hay etiquetas disponibles', 'arnelioconnect') . '</option>';
                    }
                }
                echo '</select>';
            }

            printf('<button style="%s" type="submit" name="%s" id="%s" class="%s">%s</button>', 'width:100%', 'filter_action', 'submit', 'btn btn-outline-secondary', __('Filter'));
            echo ' ';
            echo '<a id="filter_reset" href="' . esc_url(admin_url('edit.php?post_type=' . $post_type)) . '" class="btn btn-outline-secondary">' . __('All') . '</a>';
        }




        // Método para eliminar posts e imágenes destacadas asociadas con un término de la taxonomía alimentacion-cat
        public function delete_term_and_associated_posts($term_id, $taxonomy)
        {
            if (defined('ARNELIO_DEBUG') && ARNELIO_DEBUG) {
                error_log(__FILE__ . " - line: " . __LINE__ . " - Argumentos recibidos: term_id=$term_id, taxonomy=$taxonomy");
            }
            if ($taxonomy === 'alimentacion-cat') {

                error_log("Eliminando término: $term_id de la taxonomía: $taxonomy");


                // Obtener todos los posts asociados con el término usando WP_Query
                $args = array(
                    'post_type' => 'alimentacion',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'alimentacion-cat',
                            'field'    => 'term_id',
                            'terms'    => $term_id,
                        ),
                    ),
                    'posts_per_page' => -1,
                    'post_status'    => 'any'
                );

                if (defined('ARNELIO_DEBUG') && ARNELIO_DEBUG) {
                    error_log("Argumentos de la consulta: " . print_r($args, true));
                }

                $query = new WP_Query($args);

                if (defined('ARNELIO_DEBUG') && ARNELIO_DEBUG) {
                    error_log("Número de posts encontrados: " . $query->found_posts);
                }

                // Eliminar cada post y su imagen destacada
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $post_id = get_the_ID();

                        // Eliminar la imagen destacada
                        $thumbnail_id = get_post_thumbnail_id($post_id);
                        if ($thumbnail_id) {
                            wp_delete_attachment($thumbnail_id, true);
                            if (defined('ARNELIO_DEBUG') && ARNELIO_DEBUG) {
                                error_log("Imagen destacada eliminada: $thumbnail_id");
                            }
                        }

                        // Eliminar el post
                        wp_delete_post($post_id, true);
                        if (defined('ARNELIO_DEBUG') && ARNELIO_DEBUG) {
                            error_log("Post eliminado: " . $post_id);
                        }
                    }
                    wp_reset_postdata();
                }
            }
        }



        ////////////////////////////////////  REGISTRO DE CAMPOS  ////////////////////////////////////////
        // Formulario dentro de los items del custom post type
        public function form_register_fields($post)
        {

            // Array de opciones en la base de datos
            $database_get_options = maybe_unserialize(get_post_meta($post->ID, self::NAME_OPTION, true));
            $database_get_options = ($database_get_options === false) ? update_post_meta($post->ID, self::NAME_OPTION, $this->default_options) : $database_get_options;
            $this->get_options    = wp_parse_args($database_get_options, $this->default_options);

?>
            <div class="container-page-arnelio">
                <input type="hidden" name="alimentos_nonce" value="<?php echo wp_create_nonce('alimentos_nonce'); ?>">
                <?php
                echo '<input id="nav-arnelio-current" type="hidden" name="' . self::NAME_OPTION . '[tab]" value="' . $this->default_options['tab'] . '">';
                // Renderizar el contenido hacia las tabs 
                scfs_arnelioconnect_layout_fields($this->tabs, $this->get_options, $this->initial_options, null, true, null, self::NAME_OPTION, $post->ID);
                ?>
            </div>
            <?php do_action('scfs_arnelioconnect_layout_fields_footer'); ?>
<?php
        }



        ////////////////////////////////////  SAVE POST  ////////////////////////////////////////
        // Save Fields dentro de los items del custom post type
        public function save_post($post_id)
        {


            if (isset($_POST['alimentos_nonce'])) {
                if (! wp_verify_nonce($_POST['alimentos_nonce'], 'alimentos_nonce')) {
                    return;
                }
            }
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }


            if (isset($_POST['post_type']) && $_POST['post_type'] === 'alimentacion') {
                if (! current_user_can('edit_page', $post_id)) {
                    return;
                } elseif (! current_user_can('edit_post', $post_id)) {
                    return;
                }
            }


            if (isset($_POST['action']) && $_POST['action'] == 'editpost') {


                // Obtener los datos del formulario
                $post_items = $_POST[self::NAME_OPTION] ?? [];

                // Sanitizar los datos de forma recursiva
                $sanitized_input = $this->sanitize_alimentacion_recursive($post_items);

                // Obtener los valores antiguos antes de la actualización
                $old_values = maybe_unserialize(get_post_meta($post_id, self::NAME_OPTION, true));

                // Disparar la acción de salvar individualmente y pasar $sanitized_input por referencia
                $this->handle_page_save($sanitized_input, $old_values, $post_id);


                // Fusionar los datos nuevos con los existentes
                $final_items = array_merge((array)$old_values, (array)$sanitized_input);


                // Guardar los datos fusionados en la base de datos
                update_post_meta($post_id, self::NAME_OPTION, $final_items);
            }
        }

        // Función recursiva para sanitizar campos y gestionar valores de pago
        private function sanitize_alimentacion_recursive($value, $field_key = null)
        {
            // Valores Pro
            $values_pro = [];
            if (is_array($value)) {
                $sanitized_array = [];
                foreach ($value as $key => $item) {
                    if (in_array($key, $values_pro, true)) {
                        // Mantener el valor existente de la base de datos
                        $sanitized_array[$key] = isset($this->get_options[$key]) ? $this->get_options[$key] : null;
                    } else {
                        $sanitized_array[$key] = $this->sanitize_alimentacion_recursive($item, $key);
                    }
                }
                return $sanitized_array;
            } elseif (is_string($value)) {
                // Detectar si el string proviene de un wp_editor o textarea
                if ($field_key && substr($field_key, -10) === '_wp_editor') {
                    return wp_kses_post($value);
                } elseif ($field_key && substr($field_key, -9) === '_textarea') {
                    return sanitize_textarea_field($value);
                } else {
                    return sanitize_text_field($value);
                }
            } elseif (is_int($value) || is_numeric($value)) {
                // Sanitizar enteros
                return intval($value);
            } elseif (is_float($value)) {
                // Sanitizar floats
                return floatval($value);
            } elseif (is_bool($value)) {
                // Los booleanos no requieren sanitización
                return $value;
            } else {
                // Para otros tipos de datos
                return $value;
            }
        }





        ////////////////////////////////////  SAVE INDIVIDUAL  ////////////////////////////////////////

        private function handle_page_save(&$new_values, $old_values, $post_id)
        {
            $compareTimeField  = $this->compareTimeField;
            $default_options = $this->default_options;

            foreach ($new_values as $key => &$new_value) {
                $old_value = isset($old_values[$key]) ? $old_values[$key] : null;
                if ($new_value !== $old_value) {

                    // Procesar cambios específicos en un archivo individual
                    require ARNELIOCONNECT_DIR_PATH . 'src/admin/cpt/alimentacion/individual-save.php';
                    // $new_value se modifica dentro de 'individual-save.php'
                }
            }
            // No es necesario retornar nada ya que $new_values se pasa por referencia
        }




        // Cambiar número de posts por página
        public function scfs_alimentacion_per_page($per_page, $post_type = 'alimentacion')
        {
            if ($post_type == 'alimentacion' && $per_page <= 21) {
                return 22;  // Cambia este valor al número deseado de posts por página
            }
            return $per_page;
        }




        public function scfs_disable_trash_link()
        {
            $screen = get_current_screen();

            if ('alimentacion' == $screen->post_type) {
                echo '<style type="text/css">
                    #delete-action { display: none; }
                </style>';
            }
        }




        // Añade true para mostrar los avisos solo en las páginas del plugin
        // Recuerda que debes añadir las clase css notice para que se vea correctamente fuera del plugin
        public function register_notices()
        {
            if (class_exists('Scfs_arnelioconnect_banners')) {
                //Scfs_arnelioconnect_banners::scfs_arnelioconnect_classic_notices_all_wordpress( [$this, 'notice_desde_plantilla'] );
            }
        }





        ////////////////////////////////////  SCRIPTS  ////////////////////////////////////////

        ///////////////////////////////////////////////////////////////////////////////////////


        // alimentacion cat - Taxonomy
        function alimentacion_cat()
        {

            if ($this->urlTaxonomy == 'alimentacion-cat') {

                // CSS
                if (is_rtl()) {
                    wp_enqueue_style(self::NAME_PAGE . '_cat', ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '_cat-rtl.css', array(), ARNELIOCONNECT_VERSION, 'all');
                } else {
                    wp_enqueue_style(self::NAME_PAGE . '_cat', ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '_cat.css', array(), ARNELIOCONNECT_VERSION, 'all');
                }

                // JS 
                wp_enqueue_script(self::NAME_PAGE . '_cat', ARNELIOCONNECT_DIR_URL . 'dist/admin/js/' . self::NAME_PAGE . '_cat.js', array('jquery', 'wp-i18n'), ARNELIOCONNECT_VERSION, true);
                wp_set_script_translations(self::NAME_PAGE, 'arnelioconnect', ARNELIOCONNECT_DIR_PATH . 'languages');
                // wp_localize_script(self::NAME_PAGE . '_cat', self::NAME_PAGE . '_cat', array(
                // ));
            }
        }

        // alimentacion tag - Etiquetas
        function alimentacion_tag()
        {

            if ($this->urlTaxonomy == 'alimentacion-tag') {


                // CSS
                if (is_rtl()) {
                    wp_enqueue_style(self::NAME_PAGE . '_tag', ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '_tag-rtl.css', array(), ARNELIOCONNECT_VERSION, 'all');
                } else {
                    wp_enqueue_style(self::NAME_PAGE . '_tag', ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '_tag.css', array(), ARNELIOCONNECT_VERSION, 'all');
                }

                // JS 
                wp_enqueue_script(self::NAME_PAGE . '_tag', ARNELIOCONNECT_DIR_URL . 'dist/admin/js/' . self::NAME_PAGE . '_tag.js', array('jquery', 'wp-i18n'), ARNELIOCONNECT_VERSION, true);
                wp_set_script_translations(self::NAME_PAGE, 'arnelioconnect', ARNELIOCONNECT_DIR_PATH . 'languages');
                // wp_localize_script(self::NAME_PAGE . '_tag', self::NAME_PAGE . '_tag', array(
                // ));
            }
        }


        // alimentacion
        public function alimentos_scripts($hook_suffix)
        {
            global $pagenow, $typenow;

            if ($pagenow === 'edit.php' && $typenow === 'alimentacion') {

                // CSS 
                if (is_rtl()) {
                    wp_enqueue_style(self::NAME_PAGE, ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '-rtl.css', array(), ARNELIOCONNECT_VERSION, 'all');
                } else {
                    wp_enqueue_style(self::NAME_PAGE, ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '.css', array(), ARNELIOCONNECT_VERSION, 'all');
                }

                // JS 
                wp_enqueue_script(self::NAME_PAGE, ARNELIOCONNECT_DIR_URL . 'dist/admin/js/' . self::NAME_PAGE . '.js', array('jquery', 'wp-i18n'), ARNELIOCONNECT_VERSION, true);
                wp_set_script_translations(self::NAME_PAGE, 'arnelioconnect', ARNELIOCONNECT_DIR_PATH . 'languages');
            }
        }



        // alimentacion item 
        public function alimentacion_item()
        {
            global $pagenow, $typenow;

            if ($pagenow === 'post.php' && $typenow === 'alimentacion' || $pagenow === 'post-new.php' && $typenow === 'alimentacion') {

                // Get post pasar parametros por javascript
                $get_post             = $_GET['post'] ?? false;
                $database_get_options = maybe_unserialize(get_post_meta($get_post, self::NAME_OPTION, true));
                $php_options   = wp_parse_args($database_get_options, $this->default_options);


                // Scripts para image wordpress
                wp_enqueue_media();


                // Scripts para el field Custom CSS
                scfs_arnelioconnect_custom_css_scripts();


                // CSS
                if (is_rtl()) {
                    wp_enqueue_style(self::NAME_PAGE . '_item', ARNELIOCONNECT_DIR_URL . 'dist/admin/css/' . self::NAME_PAGE . '_item-rtl.css', array(), ARNELIOCONNECT_VERSION, 'all');
                } else {
                    wp_enqueue_style(self::NAME_PAGE . '_item', ARNELIOCONNECT_DIR_URL . 'dist/admin/css/' . self::NAME_PAGE . '_item.css', array(), ARNELIOCONNECT_VERSION, 'all');
                }

                // JS
                wp_enqueue_script(self::NAME_PAGE . '_item', ARNELIOCONNECT_DIR_URL . 'dist/admin/js/' . self::NAME_PAGE . '_item.js', array('jquery', 'wp-i18n'), ARNELIOCONNECT_VERSION, true);
                wp_set_script_translations(self::NAME_PAGE, 'arnelioconnect', ARNELIOCONNECT_DIR_PATH . 'languages');
                wp_localize_script(self::NAME_PAGE . '_item', self::NAME_PAGE . '_item', array(
                    'ajax_url'            => admin_url('admin-ajax.php'),
                    'security' => wp_create_nonce('arnelioconnect_nonce'),
                    'id_form'             => self::ID_FORM,
                    'name_field_options'  => self::NAME_OPTION,
                    'php_options'         => $php_options,
                    'auto_save_click'     => $this->auto_save_click,
                    'auto_save_change'    => $this->auto_save_change,
                    'field_buttons'       => $this->field_buttons,
                    'field_buttons_multi' => $this->field_buttons_multi,
                    'post_id'             => $get_post,
                    'compareTimeField'      => $this->compareTimeField
                ));
            }
        }
    } // Final Clase
} // Exist Clase

$Scfs_arnelioconnect_alimentacion = new Scfs_arnelioconnect_alimentacion($urlPostype, $urlPage, $urlTaxonomy);
