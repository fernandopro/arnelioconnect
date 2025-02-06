<?php
      // =============================================================
      //                    plantilla   PAGE
      // =============================================================
if (! class_exists('Scfs_arnelioconnect_plantilla')) {
  class Scfs_arnelioconnect_plantilla
  {

    private $urlPostype;
    private $urlTaxonomy;
    private $urlPage;
    private $get_options;
    private $default_options;
    private $initial_options;
    private $tabs;
    private $auto_save_click;
    private $auto_save_change;
    private $field_buttons;
    private $field_buttons_multi;
    private $dateTransientAdmin;
    private $compareTimeField;

          //Nombre de la página
    const NAME_PAGE   = 'scfs_arnelioconnect_plantilla';
    const NAME_OPTION = self::NAME_PAGE . '_options';
    const ID_FORM     = self::NAME_PAGE .'_form';

    public function __construct($urlPostype, $urlPage, $urlTaxonomy)
    {

      $this->urlPostype  = $urlPostype;
      $this->urlPage     = $urlPage;
      $this->urlTaxonomy = $urlTaxonomy;


            // Opciones por defecto
      require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/pages/plantilla/data-plantilla.php';

            // Asignar las configuraciones
      $this->auto_save_click     = $auto_save_click;
      $this->auto_save_change    = $auto_save_change;
      $this->field_buttons       = $field_buttons;
      $this->field_buttons_multi = $field_buttons_multi;
      $this->dateTransientAdmin  = $dateTransientAdmin;
      $this->compareTimeField    = $compareTimeField;
      $this->default_options     = $default_options;
      $this->initial_options     = $initial_options;
      $this->tabs                = $tabs;


            // Verificar si la URL actual coincide 
      if ($this->urlPage == self::NAME_PAGE || defined('DOING_AJAX') && DOING_AJAX) {

              // Array de opciones en la base de datos
        $database_get_options = maybe_unserialize(get_option( self::NAME_OPTION));
        $database_get_options = ($database_get_options === false) ? update_option( self::NAME_OPTION, $this->default_options) : $database_get_options;
        $this->get_options    = wp_parse_args($database_get_options, $this->default_options);


              // Añadir los scripts y estilos
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
      }



            // Registrar los avisos al inicializar el administrador
      add_action('admin_init', array($this, 'register_notices'));
      add_action('admin_init', array($this, 'menu_register'));
      add_action('admin_menu', array($this, 'page_menu'), 4);  // 4 para establecer el orden en el menú

            // Hook para mostrar las páginas de transientes de fecha en el panel de administración
      add_action('scfs_arnelioconnect_layout_fields_header', array($this, 'scfs_arnelioconnect_date_transient_admin_hook'));


    }



          // Submenu
    public function page_menu()
    {

      if (current_user_can('manage_options')) {
        add_submenu_page(
          ARNELIOCONNECT_MENU_URL,                            // escribir '&nbsp;' para no mostrar el submenu
          ''                 ,                            // Título h1
          __                 ('plantilla', 'arnelioconnect'),   // titulo sidebar
          'read',
          self::NAME_PAGE,                            // url de la página principal del menú
          array           ($this, 'page_callback'),   //function
          null
        );
      }
    }

          ////////////////////////////////////  REGISTRO DE CAMPOS  ////////////////////////////////////////
    public function page_callback()
    {
      if (current_user_can('publish_posts') || current_user_can('edit_posts') || current_user_can('edit_others_posts')) {
              // Definir las rutas hacia las tabs
?>
        <form class = "wrap-arnelio" method = "post" id = "<?php echo self::ID_FORM ?>" action = "options.php">
          <?php settings_fields( self::NAME_OPTION ); ?>
          <div class = "container-page-arnelio">
          <h1  class = "screen-reader-text"></h1>
            <?php
            echo '<div class="container-page-save mb-4">';
            echo '<button type="submit" name="submit" id="submit" class="btn btn-primary">' . __('Save Changes') . '</button>';
            echo '</div>';
            echo '<input id="nav-arnelio-current" type="hidden" name="' . self::NAME_OPTION. '[tab]" value="' . $this->get_options['tab'] . '">';
                  // Renderizar el contenido hacia las tabs
            scfs_arnelioconnect_layout_fields( $this->tabs, $this->get_options, $this->initial_options, null, true, null, self::NAME_OPTION, null );
            ?>
            <?php do_action('scfs_arnelioconnect_layout_fields_footer'); ?>
          </div>
        </form>
      <?php
      }
    }


    

          // Registrar los Fields
    public function menu_register()
    {
      register_setting( self::NAME_OPTION, self::NAME_OPTION, array($this, 'save_sanitize'));
    }


          // Añade true para mostrar los avisos solo en las páginas del plugin
          // Recuerda que debes añadir las clase css notice para que se vea correctamente fuera del plugin
    public function register_notices()
    {
      if (class_exists('Scfs_arnelioconnect_banners')) {
              //Scfs_arnelioconnect_banners::scfs_arnelioconnect_classic_notices_all_wordpress( [$this, 'notice_desde_plantilla'] );
      }
    }


          ////////////////////////////////////  SAVE ALL AND SANITIZE //////////////////////////
          // Sanitize
    public function save_sanitize($input)
    {

            // Sanitizar los campos recursivamente
      $sanitized_input = $this->sanitize_recursive($input);

            // Obtener los valores antiguos antes de la actualización
      $old_values = get_option(self::NAME_OPTION);


            // Disparar la acción de salvar individualmente y pasar $sanitized_input por referencia
      $this->handle_page_save($sanitized_input, $old_values);

        // Fusionar los datos nuevos con los existentes
      $final_items = array_merge((array)$old_values, (array)$sanitized_input);

      return $final_items;
    }

    private function sanitize_recursive($value, $field_key = null)
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
            $sanitized_array[$key] = $this->sanitize_recursive($item, $key);
          }
        }
        return $sanitized_array;
      } elseif (is_string($value)) {
              // Detectar si el string proviene de un wp_editor o textarea
        if ($field_key && substr($field_key, -10) === '_wp_editor') {
          return wp_kses_post($value);
        }elseif ($field_key && substr($field_key, -9) === '_textarea') {
          return sanitize_textarea_field($value);
        }
        else {
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

    private function handle_page_save(&$new_values, $old_values)
    {
      $dateTransientAdmin = $this->dateTransientAdmin;
      $compareTimeField   = $this->compareTimeField;
      $default_options    = $this->default_options;

      foreach ($new_values as $key => &$new_value) {
        $old_value = isset($old_values[$key]) ? $old_values[$key] : null;
        if ($new_value !== $old_value) {

                // Procesar cambios específicos en un archivo individual
          require ARNELIOCONNECT_DIR_PATH . 'src/admin/pages/plantilla/individual-save.php';
                // $new_value se modifica dentro de 'individual-save.php'
        }
      }
            // No es necesario retornar nada ya que $new_values se pasa por referencia
    }



          // Notices
    public function notice_desde_plantilla()
    {
      ?>
      <div class = "alert alert-info">
        <p><?php _e('This is a test notice from plantilla desde el footer', 'arnelioconnect'); ?></p>
      </div>
<?php
    }

      ////////////////////////////////////  SCRIPTS  ////////////////////////////////////////

    function enqueue_scripts()
    {


        // Scripts para image wordpress
        wp_enqueue_media();


        // Scripts para el field Custom CSS
        scfs_arnelioconnect_custom_css_scripts();


        if (is_rtl()) {
          wp_enqueue_style(self::NAME_PAGE, ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '-rtl.css', array(), ARNELIOCONNECT_VERSION, 'all');
        } else {
          wp_enqueue_style(self::NAME_PAGE, ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . self::NAME_PAGE . '.css', array(), ARNELIOCONNECT_VERSION, 'all');
        }

        wp_enqueue_script(self::NAME_PAGE, ARNELIOCONNECT_DIR_URL . 'dist/admin/js/' . self::NAME_PAGE . '.js', array('jquery', 'wp-i18n'), ARNELIOCONNECT_VERSION, true);
        wp_set_script_translations(self::NAME_PAGE, 'arnelioconnect', ARNELIOCONNECT_DIR_PATH . 'languages');
        wp_localize_script(self::NAME_PAGE, self::NAME_PAGE, array(
          'ajax_url'            => admin_url('admin-ajax.php'),
          'security'            => wp_create_nonce('arnelioconnect_nonce'),
          'id_form'             => self::ID_FORM,
          'name_field_options'  => self::NAME_OPTION,
          'php_options'         => $this->get_options,
          'auto_save_click'     => $this->auto_save_click,
          'auto_save_change'    => $this->auto_save_change,
          'field_buttons'       => $this->field_buttons,
          'field_buttons_multi' => $this->field_buttons_multi,
          'dateTransientAdmin'  => $this->dateTransientAdmin,
          'compareTimeField'    => $this->compareTimeField
        ));

    }


          /**
     * Renderiza las páginas de transientes de fecha en el panel de administración.
     *
     * Esta función genera y muestra las páginas asociadas a los transientes de fecha definidos.
     * Utiliza la función `scfs_arnelioconnect_date_transient_admin` para cada transient específico,
     * asegurando que el contenido se muestre solo si el transient correspondiente existe.
     * 
     * @return void
     */
    public function scfs_arnelioconnect_date_transient_admin_hook()
    {
      echo scfs_arnelioconnect_date_transient_admin($name = "date_transient_admin_deportes");
      echo scfs_arnelioconnect_date_transient_admin($name = "date_transient_admin_comidas");
      echo scfs_arnelioconnect_date_transient_admin($name = "dentista");
    }
  } // Final Clase

} // Exist Clase

$Scfs_arnelioconnect_plantilla = new Scfs_arnelioconnect_plantilla($urlPostype, $urlPage, $urlTaxonomy);
