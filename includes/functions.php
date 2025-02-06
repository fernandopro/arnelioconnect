<?php


// Muestra la pantalla actual
function scfs_arnelioconnect_show_current_screen()
{
  $screen = get_current_screen();
  if ($screen) {
    echo '<pre style="padding:15px;background:#333;color:#fff;z-index:99999;position:relative">';
    // print_r  -  var_dump
    $php = $screen->id;
    $descripcion = 'Pantalla actual';
    echo '<span style="color:#2eff2e">' . $descripcion . '</span>' . '<br>';
    print_r($php);
    echo '<br>';
    echo '</pre>';
  }
}

// Descomenta la siguiente línea para ejecutar la función
//add_action('current_screen', 'scfs_arnelioconnect_show_current_screen');


// Función para obtener la fecha actual formateada según la configuración de WordPress
function scfs_arnelioconnect_date_wordpress()
{
  $current_timestamp = current_time('timestamp');

  return wp_date(get_option('date_format') . ' ' . get_option('time_format'), $current_timestamp);
}



// Muestra el footer del plugin
function scfs_arnelioconnect_page_footer()
{
?>

  <div class="arnelioconnect-footer-promotion">
    <p><?php echo __('__________ by the Arnelio team', 'arnelioconnect') ?></p>
    <ul class="arnelioconnect-footer-promotion-links">
      <li>
        <a
          class="link-secondary"
          href="#"
          target="_blank"
          rel="noopener noreferrer"><?php echo __('Support', 'arnelioconnect') ?></a><span>/</span>
      </li>
      <li>
        <a
          class="link-secondary"
          href="#"
          target="_blank"
          rel="noopener noreferrer"><?php echo __('Docs', 'arnelioconnect') ?></a><span>/</span>
      </li>
      <li>
        <a
          class="link-secondary"
          href="#"
          target="_blank"><?php echo __('Free Plugins', 'arnelioconnect') ?>
        </a>
      </li>
    </ul>
    <ul class="arnelioconnect-footer-promotion-social">
      <li>
        <a
          href="#"
          target="_blank"
          rel="noopener noreferrer">
          <i style="font-size: 1rem;" class="bi bi-facebook"></i>
          <span class="screen-reader-text">Facebook</span>
        </a>
      </li>
      <li>
        <a
          href="#"
          target="_blank"
          rel="noopener noreferrer">
          <i class="bi bi-twitter-x"></i>
          <span style="font-size: 1.1rem;" class="screen-reader-text">X</span>
        </a>
      </li>
      <li>
        <a
          href="#"
          target="_blank"
          rel="noopener noreferrer">
          <i style="font-size: 1.2rem;" class="bi bi-youtube"></i>
          <span class="screen-reader-text">YouTube</span>
        </a>
      </li>
    </ul>
    </br>
    <div class="container container-page-arnelio"><?php do_action('scfs_arnelioconnect_banner_all_footer'); ?></div>

  </div>
<?php
}


// Función para generar un page-accordion dinámico
function scfs_arnelioconnect_layout_fields($tabs, $values = null, $initial = null, $default_options = null, $viewMenu = null, $beforeMenu = null, $name_option = null, $post_id = null)
{
  $badge_pro = '<span class="badge-pro badge text-bg-secondary">PRO</span>';
  $viewMenu = ($viewMenu == null) ? ' nomenu-arnelio' : '';
  if ($beforeMenu !== null) {
    require_once ARNELIOCONNECT_DIR_PATH . $beforeMenu;
  }
  // Generar las tabs
  echo '<ul class="nav nav-arnelio' . $viewMenu . ' bg-body border rounded mb-4" role="tablist">';
  foreach ($tabs as $tab) {
    $active = $tab['id'] == $values['tab'] ? ' active' : '';
    $ariaSelected = $tab['id'] == $values['tab'] ? 'true' : 'false';
    echo '<li class="nav-item">';
    echo '<a class="nav-link' . $active . '" id="' . esc_attr($tab['id']) . '-tab" data-toggle="tab" href="#' . esc_attr($tab['id']) . '" role="tab" aria-controls="' . esc_attr($tab['id']) . '" aria-selected="' . $ariaSelected . '">';
    echo esc_html($tab['title']);
    // Agregar el badge "PRO" si la tab tiene 'pro' => true
    if (isset($tab['pro']) && $tab['pro']) {
      echo ' ' . $badge_pro;
    }
    echo '</a>';
    echo '</li>';
  }
  echo '</ul>';
  do_action('scfs_arnelioconnect_layout_fields_header');
  // Generar el contenido de las tabs
  echo '<div class="tab-content">';
  foreach ($tabs as $tab) {

    $active = $tab['id'] == $values['tab'] ? ' active show' : '';
    echo '<div class="tab-pane fade' . $active . '" id="' . esc_attr($tab['id']) . '" role="tabpanel" aria-labelledby="' . esc_attr($tab['id']) . '-tab">';
    if (!empty($tab['items'])) {
      echo '<div class="accordion-arnelio' . ' accordion accordion-flush" id="page-' . esc_attr($tab['id']) . '">';
      $firstItem = true; // Variable para identificar el primer elemento
      foreach ($tab['items'] as $key => $item) {
        $title = isset($item['name']) && $item['name'] ? $item['name'] : '';
        $item_pro = isset($item['pro']) && $item['pro'] ? $badge_pro : '';
        $url = $item['url'];


        $fixed_header = isset($item['fixed']) && $item['fixed'] ? ' fixed-header-arnelio' : '';
        $fixed_body = isset($item['fixed']) && $item['fixed'] ? ' fixed-body-arnelio' : '';
        $hidden_header = isset($item['header']) && $item['header'] == false ? ' hidden-header-arnelio' : '';


        $collapseId = 'flush-collapse' . md5($tab['id'] . $key);
        $collapseButon = ' collapsed';
        $collapseClass = 'accordion-collapse collapse';
        if ($firstItem) {
          $collapseClass .= ' show';
          $collapseButon = '';
          $firstItem = false; // Actualizamos la variable para los siguientes elementos
        }
        echo '<div class="accordion-item">';
        echo '<div class="accordion-header">';
        echo '<button class="accordion-button' . $collapseButon . $fixed_header . $hidden_header . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . esc_attr($collapseId) . '" aria-expanded="false" aria-controls="' . esc_attr($collapseId) . '">';
        echo esc_html($title);
        echo $item_pro;
        echo '</button>';
        echo '</div>';
        echo '<div id="' . esc_attr($collapseId) . '" class="' . esc_attr($collapseClass) . $fixed_body . '">';
        echo '<div class="accordion-body accordion-body-arnelio">';
        require ARNELIOCONNECT_DIR_PATH . $url;
        echo '</div>'; // Cerrar accordion-body
        echo '</div>'; // Cerrar accordion-collapse
        echo '</div>'; // Cerrar accordion-item
      }
      echo '</div>'; // Cerrar accordion
    }
    echo '</div>'; // Cerrar tab-pane
  }
  echo '</div>'; // Cerrar tab-content
}


/**
 * Función para generar contenido basado en un transient de fecha en una página.
 *
 * @param string $name Nombre del transient.
 * @return string|null Contenido a mostrar o null si no corresponde mostrar nada.
 */
function scfs_arnelioconnect_date_transient_admin($name = null)
{
  $transient = get_transient($name);

  if ($transient) {

    $timezone = wp_timezone();

    // Crear objetos DateTime desde los timestamps UTC y convertirlos a la zona horaria local
    $start_datetime = new DateTime('@' . $transient['date']['start'], $timezone);
    $start_datetime->setTime($start_datetime->format('H'), $start_datetime->format('i'), 0);
    $start_datetime->setTimezone($timezone);

    $end_datetime = new DateTime('@' . $transient['date']['end'], $timezone);
    $end_datetime->setTime($end_datetime->format('H'), $end_datetime->format('i'), 0);
    $end_datetime->setTimezone($timezone);


    // Obtener el timestamp actual según la zona horaria de WordPress
    $current_date = new DateTime('now', $timezone);
    $current_date->setTime($current_date->format('H'), $current_date->format('i'), 0);


    // Verificar el rango de fechas...
    if (
      $current_date->getTimestamp() >= $start_datetime->getTimestamp() &&
      $current_date->getTimestamp() <= $end_datetime->getTimestamp()
    ) {


      // Si el contenido aún no ha sido generado, generarlo y almacenarlo en el transient
      if (empty($transient['content'])) {
        ob_start();

        // Incluir el contenido correspondiente
        include ARNELIOCONNECT_DIR_PATH . 'src/admin/modules/date_transient_admin/' . $name . '/' . $name . '.php';

        $output = ob_get_clean();
        $content = [
          'date'    => $transient['date'],
          'content' => $output,
        ];

        // Calcular la duración restante en segundos
        $remaining_seconds = $end_datetime->getTimestamp() - $current_date->getTimestamp();

        // Actualizar el transient con el nuevo contenido y duración restante
        set_transient($name, $content, $remaining_seconds);

        return $output;
      } else {
        // Si el contenido ya está generado, devolverlo
        return $transient['content'];
      }
    } else {
      if ($current_date->getTimestamp() > $end_datetime->getTimestamp()) {
        // Si no está dentro del rango, eliminar el transient
        delete_transient($name);
      }
    }
  }

  // Si no hay contenido o no está dentro del rango, devolver null
  return null;
}





function scfs_arnelioconnect_compare_time($start, $end)
{
  $timezone = wp_timezone();

  // Verificar si 'start' y 'end' están presentes y no están vacíos
  if (empty($start) || empty($end)) {
    return false; // Retorna false si alguno de los valores está vacío
  }

  // Crear objetos DateTime desde los timestamps UTC y convertirlos a la zona horaria local
  $start_datetime = new DateTime('@' . $start, $timezone);
  $start_datetime->setTime($start_datetime->format('H'), $start_datetime->format('i'), 0);
  $start_datetime->setTimezone($timezone);

  $end_datetime = new DateTime('@' . $end, $timezone);
  $end_datetime->setTime($end_datetime->format('H'), $end_datetime->format('i'), 0);
  $end_datetime->setTimezone($timezone);

  // Obtener el timestamp actual según la zona horaria de WordPress
  $current_date = new DateTime('now', $timezone);
  $current_date->setTime($current_date->format('H'), $current_date->format('i'), 0);

  // Verificar el rango de fechas
  if (
    $current_date->getTimestamp() >= $start_datetime->getTimestamp() && $current_date->getTimestamp() <= $end_datetime->getTimestamp()
  ) {
    return true;
  } else {
    return false;
  }
}



/**
 * Encola los estilos y scripts necesarios para el campo de custom css.
 * Se utiliza el editor de código CodeMirror.
 * Se añade un script en línea para inicializar el editor.
 * 
 *
 * @return void
 */
function scfs_arnelioconnect_custom_css_scripts()
{

  // Enqueue CodeMirror
  $settings = array(
    'type' => 'text/css',
  );
  wp_enqueue_code_editor($settings);

  // Inline script to initialize CodeMirror
  $script = '
            document.addEventListener("DOMContentLoaded", function() {
                    var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
                    editorSettings.codemirror = _.extend(
                        {},
                        editorSettings.codemirror,
                        {
                            indentUnit: 2,
                            tabSize: 2,
                            mode: "css",
                            lineNumbers: true,
                            lineWrapping: true,
                        }
                    );
                    var textarea = document.getElementById("scfs_codemirror_css");
                    var editor = wp.codeEditor.initialize(textarea, editorSettings);
                });
            ';
  wp_add_inline_script('wp-codemirror', $script);
}
