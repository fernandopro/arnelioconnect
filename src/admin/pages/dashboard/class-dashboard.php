<?php
// =============================================================
//                     DASHBOARD - PAGE
// =============================================================

/**
 * Class Scfs_arnelioconnect_dashboard
 *
 * Encapsula la funcionalidad del panel de administración del plugin arnelioconnect.
 *
 * @package FerPlugin
 */
if (! class_exists('Scfs_arnelioconnect_dashboard')) {
  class Scfs_arnelioconnect_dashboard
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

    // Nombre de la página esta en el archivo arnelioconnect.php


    /**
     * Identificador de la opción para guardar la configuración.
     */
    const NAME_OPTION = ARNELIOCONNECT_MENU_URL . '_options';
    /**
     * Identificador del formulario.
     */
    const ID_FORM     = ARNELIOCONNECT_MENU_URL . '_form';

    /**
     * Constructor de la clase.
     *
     * @param string $urlPostype URL o slug del custom post type.
     * @param string $urlPage URL de la página.
     * @param string $urlTaxonomy URL o slug de la taxonomía.
     */
    public function __construct($urlPostype, $urlPage, $urlTaxonomy)
    {

      $this->urlPostype  = $urlPostype;
      $this->urlTaxonomy = $urlTaxonomy;
      $this->urlPage     = $urlPage;

      // Opciones por defecto
      require_once ARNELIOCONNECT_DIR_PATH . 'src/admin/pages/dashboard/data-dashboard.php';

      // Asignar las configuraciones
      $this->tabs                = $tabs;
      $this->default_options     = $default_options;
      $this->initial_options     = $initial_options;
      $this->auto_save_click     = $auto_save_click;
      $this->auto_save_change    = $auto_save_change;
      $this->field_buttons       = $field_buttons;
      $this->field_buttons_multi = $field_buttons_multi;
      $this->dateTransientAdmin  = $dateTransientAdmin;
      $this->compareTimeField    = $compareTimeField;


      // Verificar si la URL actual coincide 
      if ($this->urlPage == ARNELIOCONNECT_MENU_URL || defined('DOING_AJAX') && DOING_AJAX) {

        // Obtener opciones guardadas
        $database_get_options = maybe_unserialize(get_option(ARNELIOCONNECT_MENU_URL . '_options'));
        $database_get_options = ($database_get_options === false) ? update_option(ARNELIOCONNECT_MENU_URL . '_options', $this->default_options) : $database_get_options;
        $this->get_options    = wp_parse_args($database_get_options, $this->default_options);

        // Scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 1);
      }


      // Registrar los avisos al inicializar el administrador
      add_action('admin_init', array($this, 'register_notices'));
      add_action('admin_init', array($this, 'scfs_dashboard_menu_register'));

      add_action('admin_menu', array($this, 'scfs_dashboard_menu'), 1);
      add_action('admin_menu', array($this, 'scfs_dashboard_menusub'), 1);
    }


    /**
     * Registra el menú principal en el área de administración.
     *
     * @return void
     */
    public function scfs_dashboard_menu()
    {

      if (current_user_can('publish_posts') || current_user_can('edit_posts') || current_user_can('edit_others_posts')) {

        // Cargar solo en las páginas del plugin
        if (defined('IS_URL_ARNELIOCONNECT') && IS_URL_ARNELIOCONNECT) {
          $badge = '';
        } else {
          $posts_count = get_option('scfs_arnelioconnect_api_blogtag_count', 0);
          $badge = ($posts_count > 0) ? '&nbsp;<span class="update-plugins">' . $posts_count . '</span>' : '';
        }


        $icon = 'PHN2ZyBpZD0ibWVudSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgMTE5LjgxIDk4LjMzIj48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6I2ZmZjtmaWxsLXJ1bGU6ZXZlbm9kZDt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPnRhcm9raW5hLW1lbnU8L3RpdGxlPjxwYXRoIGNsYXNzPSJjbHMtMSIgZD0iTTExNi4xNSw2Ni4zOUM5OS45Myw3NC4yMyw4My42NSw4Miw2Ny41LDkwYTM2LjQyLDM2LjQyLDAsMCwxLTI2LjcsMi43MmMtMTEuMzctMy4wOC0yMi44LTYtMzQuMTctOUE1LjkzLDUuOTMsMCwwLDAsLjgyLDg1YzEuMjYuMzcsMi4yOS42OSwzLjMyLDEsMTUuMzksNCwzMC43OCw4LDQ2LjE1LDEyLjEzYTcsNywwLDAsMCw1LjE3LS41NFE4My42LDgzLjg0LDExMS43OCw3MC4yOGMyLjU0LTEuMjIsNS0yLjQ4LDcuOS0zLjg3QTMuMTMsMy4xMywwLDAsMCwxMTYuMTUsNjYuMzlaIi8+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNNDIuMjEsNjEuODVjNC44OCwxLjU0LDguNzcsMS4yMywxMy4xNy0xLjQ3LDYtMy42OCwxMi03LjIzLDE2LjYzLTEyLjc3LDcuNjQtOS4xLDEwLjg0LTE5LjUxLDguNDItMzEuNTZhMy4yOCwzLjI4LDAsMCwwLTIuNjEtMi44M0M2My4zLDksNDguOCw0LjcsMzQuMjkuNDNjLTIuNi0uNzYtMi42LS43NC0yLjE5LDJhMzQuMTIsMzQuMTIsMCwwLDEtMi44NiwyMC40MkE1MC4zNyw1MC4zNywwLDAsMSw0LjMxLDQ3LjEzYy0xLjQzLjY2LTIuODcsMS4zLTQuMzEsMS45NWwuMTQuNTNjLjU0LjE3LDEuMDguMzYsMS42My41MkMxNS4yNiw1NCwyOC44Myw1Ny42MSw0Mi4yMSw2MS44NVoiLz48cGF0aCBjbGFzcz0iY2xzLTEiIGQ9Ik01MC41Myw3NC42NmE2LjEsNi4xLDAsMCwwLDQuNTctLjQ0UTgwLjE5LDYyLDEwNS4zNSw0OS45MUwxMTkuNTcsNDNjLS41Mi0uMzYtLjY3LS41NC0uODYtLjU5LTEwLjA3LTIuNjctMjAuMTQtNS4zLTMwLjItOEM4NywzNCw4Ni42NSwzNC44Miw4Ni4yNiwzNiw4Mi4xNCw0OC43OSw3My44Nyw1Ny44NSw2Mi44LDY0LjM2Yy0zLjIxLDEuODgtNi41MiwzLjU3LTkuNyw1LjQ5YTcuNCw3LjQsMCwwLDEtNi4zOS44M0MzNC4wOCw2NywyMS4zOSw2My40Nyw4Ljc4LDU5LjY3Yy0zLjEtLjk0LTUuMzYuMS04LjExLDEuODdsMy41LjkzQzE5LjYzLDY2LjUyLDM1LjA5LDcwLjU1LDUwLjUzLDc0LjY2WiIvPjxwYXRoIGNsYXNzPSJjbHMtMSIgZD0iTTExMy43Myw1NC45MUM5OC4zMSw2Mi40Miw4Mi44MSw2OS43Myw2Ny40NCw3Ny4zNUEzNi4yMSwzNi4yMSwwLDAsMSw0MSw4MC4wOGMtMTAtMi43LTIwLTUuMDgtMjkuOTUtOC0zLjg0LTEuMTQtNi44My0uMTMtMTAuMjUsMiwuNjkuMjQsMSwuMzksMS4zNi40OHEyNC4yMyw2LjM1LDQ4LjQzLDEyLjczYTYuMDgsNi4wOCwwLDAsMCw0LjU2LS40NVE4My41Myw3My4wNiwxMTIsNTkuMzRjMi40NS0xLjE4LDQuODktMi4zOCw3LjgxLTMuODFDMTE3LjQ0LDU0LjczLDExNS43Nyw1My45MiwxMTMuNzMsNTQuOTFaIi8+PC9zdmc+';
        add_menu_page(
          '',                             // Título h1
          __('arnelioconnect', 'arnelioconnect') . $badge,   // titulo sidebar
          'read',
          ARNELIOCONNECT_MENU_URL,  // url de la página principal del menú
          '',
          'data:image/svg+xml;base64,' . $icon,
          30
        );
      }
    }

    /**
     * Registra la subpágina del dashboard.
     *
     * @return void
     */
    public function scfs_dashboard_menusub()
    {

      if (current_user_can('manage_options')) {
        add_submenu_page(
          ARNELIOCONNECT_MENU_URL,
          '',                             // Título h1
          __('Dashboard', 'arnelioconnect'),   // titulo sidebar
          'read',
          ARNELIOCONNECT_MENU_URL,                                        // url de la página principal del menú
          array($this, 'scfs_dashboard_menu_render')  //function
        );
      }
    }

    /**
     * Renderiza el contenido del panel de administración y de la configuración.
     *
     * @return void
     */
    public function scfs_dashboard_menu_render()
    {
      if (current_user_can('publish_posts') || current_user_can('edit_posts') || current_user_can('edit_others_posts')) {

?>
        <form class="wrap-arnelio" method="post" id="<?php echo self::ID_FORM ?>" action="options.php">
          <?php settings_fields(ARNELIOCONNECT_MENU_URL . '_options'); ?>
          <div class="container-page-arnelio">
            <h1 class="screen-reader-text"></h1>
            <?php
            echo '<div class="container-page-save mb-4">';
            echo '<button type="submit" name="submit" id="submit" class="btn btn-primary">' . __('Save Changes') . '</button>';
            echo '</div>';
            echo '<input id="nav-arnelio-current" type="hidden" name="' . ARNELIOCONNECT_MENU_URL . '_options[tab]" value="' . $this->get_options['tab'] . '">';
            // Renderizar el contenido hacia las tabs
            scfs_arnelioconnect_layout_fields($this->tabs, $this->get_options, $this->initial_options, null, null, null, self::NAME_OPTION, null);
            ?>
            <?php do_action('scfs_arnelioconnect_layout_fields_footer'); ?>
          </div>
        </form>
<?php
      }
    }

    /**
     * Registra los avisos para la administración.
     *
     * @return void
     */
    public function register_notices()
    {
      if (class_exists('Scfs_arnelioconnect_banners')) {
        // Scfs_arnelioconnect_banners::scfs_arnelioconnect_classic_notices_all_wordpress( [$this, 'dashboard_notice_prueba'] );
      }
    }

    /**
     * Registra settings y opciones del plugin.
     *
     * @return void
     */
    public function scfs_dashboard_menu_register()
    {
      register_setting(ARNELIOCONNECT_MENU_URL . '_options', ARNELIOCONNECT_MENU_URL . '_options', array($this, 'save_sanitize'));
    }



    /**
     * Sanitiza y guarda las opciones del plugin.
     *
     * @param array $input Datos ingresados a ser sanitizados.
     * @return array Los datos sanitizados.
     */
    public function save_sanitize($input)
    {

      // Sanitizar los campos recursivamente
      $sanitized_input = $this->sanitize_recursive($input);

      // Obtener los valores antiguos antes de la actualización
      $old_values = $this->get_options;


      // Disparar la acción de salvar individualmente y pasar $sanitized_input por referencia
      $this->handle_page_save($sanitized_input, $old_values, ARNELIOCONNECT_MENU_URL);



      return $sanitized_input;
    }

    /**
     * Sanitiza recursivamente el valor dado.
     *
     * @param mixed $value Valor a sanitizar.
     * @param string|null $field_key Clave del campo (opcional).
     * @return mixed Valor sanitizado.
     */
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


    /**
     * Procesa el guardado individual de cada campo.
     *
     * @param array &$new_values Nuevos valores a guardar.
     * @param array $old_values Valores previos.
     * @return void
     */
    private function handle_page_save(&$new_values, $old_values)
    {
      $dateTransientAdmin = $this->dateTransientAdmin;
      $compareTimeField   = $this->compareTimeField;
      $default_options    = $this->default_options;

      foreach ($new_values as $key => &$new_value) {
        $old_value = isset($old_values[$key]) ? $old_values[$key] : null;
        if ($new_value !== $old_value) {

          // Procesar cambios específicos en un archivo individual
          require ARNELIOCONNECT_DIR_PATH . 'src/admin/pages/dashboard/individual-save.php';
          // $new_value se modifica dentro de 'individual-save.php'
        }
      }
      // No es necesario retornar nada ya que $new_values se pasa por referencia
    }

    /**
     * Encola los scripts y estilos necesarios para el panel del plugin.
     *
     * @return void
     */
    function enqueue_scripts()
    {


      
      // Scripts para image wordpress
      //wp_enqueue_media();

      // Scripts para el field Custom CSS
      //scfs_arnelioconnect_custom_css_scripts();


      // CSS
      if (is_rtl()) {
        wp_enqueue_style(ARNELIOCONNECT_MENU_URL, ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . ARNELIOCONNECT_MENU_URL . '-rtl.css', array(), ARNELIOCONNECT_VERSION, 'all');
      } else {
        wp_enqueue_style(ARNELIOCONNECT_MENU_URL, ARNELIOCONNECT_DIR_URL  . 'dist/admin/css/' . ARNELIOCONNECT_MENU_URL . '.css', array(), ARNELIOCONNECT_VERSION, 'all');
      }

      // JS
      wp_enqueue_script(ARNELIOCONNECT_MENU_URL, ARNELIOCONNECT_DIR_URL . 'dist/admin/js/' . ARNELIOCONNECT_MENU_URL . '.js', array('jquery', 'wp-i18n'), ARNELIOCONNECT_VERSION, true);
      wp_set_script_translations(ARNELIOCONNECT_MENU_URL, 'arnelioconnect', ARNELIOCONNECT_DIR_PATH . 'languages');
      wp_localize_script(ARNELIOCONNECT_MENU_URL, ARNELIOCONNECT_MENU_URL, array(
        'ajax_url'            => admin_url('admin-ajax.php'),
        'security'            => wp_create_nonce('arnelioconnect_nonce'),
        'id_form'             => self::ID_FORM,
        'name_field_options'  => ARNELIOCONNECT_MENU_URL . '_options',
        'php_options'         => $this->get_options,
        'auto_save_click'     => $this->auto_save_click,
        'auto_save_change'    => $this->auto_save_change,
        'field_buttons'       => $this->field_buttons,
        'field_buttons_multi' => $this->field_buttons_multi,
        'dateTransientAdmin'  => $this->dateTransientAdmin,
        'compareTimeField'    => $this->compareTimeField
      ));
    }
  } // Final Clase

} // Exist Clase

$scfs_dashboard = new Scfs_arnelioconnect_dashboard($urlPostype, $urlPage, $urlTaxonomy);
