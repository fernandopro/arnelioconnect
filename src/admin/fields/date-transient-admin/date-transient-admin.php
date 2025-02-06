<?php
if (!class_exists('Scfs_arnelioconnect_date_transient_admin_class')) {
    final class Scfs_arnelioconnect_date_transient_admin_class
    {

        private $dateTransientAdmin;
        private $name_option;

        public function __construct($dateTransientAdmin, $name_option)
        {
            $this->dateTransientAdmin = $dateTransientAdmin;
            $this->name_option    = $name_option;


            // Añadir scripts para los campos Date Transient Admin
            if (defined('IS_URL_ARNELIOCONNECT') && IS_URL_ARNELIOCONNECT) {
            }

            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

            // Registrar hooks de acción para AJAX
            add_action('wp_ajax_scfs_arnelioconnect_delete_date_transient_admin', array($this, 'scfs_arnelioconnect_delete_date_transient_admin'));
        }

        /**
         * Renderiza un campo de fecha con transitorio personalizado en el panel de administración de WordPress.
         *
         * @param array $arg Parámetros del campo: 
         *                   - string $title        Título del campo.
         *                   - string $name_option   Nombre del array de opciones almacenadas.
         *                   - string $name         Nombre específico del campo.
         *                   - array  $initial      Opciones iniciales del campo select múltiple.
         *                   - array  $values       Valores almacenados en las opciones del plugin.
         *                   - string $info         Descripción del campo.
         *                   - string $css          Clases CSS adicionales para personalización.
         *                   - bool   $docu         Indica si se muestra el enlace de documentación.
         *
         * @return void
         */
        public static function Scfs_arnelioconnect_date_transient_admin_field($arg)
        {
            // Extraer los argumentos para facilitar el acceso a las variables
            extract($arg);

            // Obtener la zona horaria configurada en WordPress
            $timezone = wp_timezone();

            // Asegurar que $values es un array
            if (!is_array($values)) {
                $values = [];
            }


            // Sanitizar $name para prevenir problemas de seguridad
            $name_sanitized = sanitize_key($name);

            // Ajustar valores con validaciones
            $compare_start = !empty($values[$name_sanitized]['start']) ? intval($values[$name_sanitized]['start']) : '';
            $compare_end   = !empty($values[$name_sanitized]['end']) ? intval($values[$name_sanitized]['end']) : '';

            // Obtener timestamps de las fechas y horas de inicio y fin
            $start_timestamp = !empty($values[$name_sanitized]['start']) ? intval($values[$name_sanitized]['start']) : current_time('timestamp', true);
            $end_timestamp   = !empty($values[$name_sanitized]['end']) ? intval($values[$name_sanitized]['end']) : current_time('timestamp', true);

            // Crear DateTime para la fecha y hora de inicio
            $start_datetime = new DateTime('@' . $start_timestamp);
            $start_datetime->setTimezone($timezone);
            $start_date = $start_datetime->format('Y-m-d');
            $start_time = $start_datetime->format('H:i');

            // Crear DateTime para la fecha y hora de fin
            $end_datetime = new DateTime('@' . $end_timestamp);
            $end_datetime->setTimezone($timezone);
            $end_date = $end_datetime->format('Y-m-d');
            $end_time = $end_datetime->format('H:i');


            // Determinar clases de estado
            $active = scfs_arnelioconnect_compare_time( $compare_start , $compare_end ) == true && get_transient($name_sanitized)  ? ' btn-date-time' : '';
            $disabled = ( !get_transient($name_sanitized) && current_time('timestamp', true) > $end_timestamp || scfs_arnelioconnect_compare_time( $compare_start , $compare_end ) == false && current_time('timestamp', true) < $start_timestamp ) ? ' disabled_date' : '';

            // Obtener el valor de 'check'
            $checkValue = !empty($values[$name_sanitized]['check']) ? intval($values[$name_sanitized]['check']) : 0;
            $check = scfs_arnelioconnect_compare_time($compare_start, $compare_end) === false ? $checkValue : 0;

            // Generar IDs únicos para los elementos
            $check_id         = esc_attr($name_sanitized) . '_check';
            $start_date_id    = esc_attr($name_sanitized) . '_start_date';
            $start_time_id    = esc_attr($name_sanitized) . '_start_time';
            $end_date_id      = esc_attr($name_sanitized) . '_end_date';
            $end_time_id      = esc_attr($name_sanitized) . '_end_time';
            $delete_button_id = esc_attr($name_sanitized) . '_delete_value';
            $init_button_id   = esc_attr($name_sanitized) . '_init_date';

?>
            <div class="layo-field<?php echo $css ?>">
                <div class="layo-field-name-btns">
                    <div class="link-docu-wrapper">
                        <h4><?php echo esc_html($title); ?></h4>
                        <?php if ($docu !== null): ?>
                            <a href="<?php echo esc_attr($docu); ?>" id="<?php echo $name_sanitized ?>-docu" target="_blank" class="link-docu-field"><i class="bi bi-life-preserver"></i></a>
                        <?php endif; ?>
                    </div>
                    <div class="layo-field-btns">
                        <!-- activate -->
                        <?php if ( scfs_arnelioconnect_compare_time($start_timestamp, $end_timestamp) == true && get_transient($name_sanitized) ): ?>
                            <button
                                id="<?php echo esc_attr($delete_button_id); ?>"
                                type="button"
                                class="btn btn-danger"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="<?php echo __('Stop', 'arnelioconnect'); ?>">
                                <i style="font-size: 1.2rem;" class="bi bi-stop-fill"></i>
                            </button>
                            <div class="spinner-grow text-danger" role="status">
                                <span class="visually-hidden"><?php echo __('Loading...', 'arnelioconnect'); ?></span>
                            </div>
                        <!-- Deactivate -->
                        <?php else: ?>


                            <?php if (current_time('timestamp', true) > $end_timestamp && !get_transient($name_sanitized) ): ?>
                                <?php //echo delete_transient($name_sanitized); ?>
                                <span class="badge text-bg-warning">
                                    <?php
                                    echo __('Finished', 'arnelioconnect');
                                    ?>
                                </span>
                                <button
                                    type="submit"
                                    class="btn btn-warning"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="<?php echo __('Delete', 'arnelioconnect'); ?>">
                                    <i style="font-size: 1.2rem;" class="bi bi-trash"></i>
                                </button>

                            <?php elseif( current_time('timestamp', true) < $start_timestamp && $check == 0 ): ?>

                                <span class="badge text-bg-light">
                                    <?php
                                    echo __('On standby', 'arnelioconnect');
                                    ?>
                                </span>
                                <button
                                    id="<?php echo esc_attr($delete_button_id); ?>"
                                    type="button"
                                    class="btn badge-light"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="<?php echo __('Stop', 'arnelioconnect'); ?>">
                                    <i style="font-size: 1.2rem;" class="bi bi-alarm"></i>
                                </button>

                            <?php else: ?>

                                <button
                                type="submit"
                                name="<?php echo esc_attr($init_button_id); ?>"
                                id="submit"
                                class="btn btn-box-arnelio"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="<?php echo __('Start', 'arnelioconnect'); ?>">
                                <i style="font-size: 1.2rem;" class="bi bi-play-fill"></i>
                            </button>

                            <?php  endif; ?>

                        <?php  endif; ?>
                    </div>
                </div>
                <div class="field-arnelio-date-transient-admin">
                    <!-- Campo hidden para mantener sincronizado el estado en frontend y backend -->
                    <input
                        id="<?php echo esc_attr($check_id); ?>"
                        type="hidden"
                        name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>][check]"
                        value="<?php echo esc_attr($check); ?>">
                    <div class="field-arnelio-date-transient-admin__content">
                        <label for="<?php echo esc_attr($start_date_id); ?>">&nbsp;&nbsp;<?php echo __('Start', 'arnelioconnect'); ?></label>
                        <div class="date-wrapper">
                            <input
                                id="<?php echo esc_attr($start_date_id); ?>"
                                class="form-control<?php echo esc_attr($active . $disabled); ?>"
                                type="date"
                                name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>][start_date]"
                                value="<?php echo esc_attr($start_date); ?>"
                                data-field="date">
                            <input
                                id="<?php echo esc_attr($start_time_id); ?>"
                                class="form-control<?php echo esc_attr($active . $disabled); ?>"
                                type="time"
                                name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>][start_time]"
                                value="<?php echo esc_attr($start_time); ?>"
                                data-field="time">
                        </div>
                    </div>

                    <div class="field-arnelio-date-transient-admin__content">
                        <div class="date-transient-admin_end-notification">
                            <label for="<?php echo esc_attr($end_date_id); ?>">&nbsp;&nbsp;<?php echo __('End', 'arnelioconnect'); ?></label>
                        </div>
                        <div class="date-wrapper">
                            <input
                                id="<?php echo esc_attr($end_date_id); ?>"
                                class="form-control<?php echo esc_attr($active . $disabled); ?>"
                                type="date"
                                name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>][end_date]"
                                value="<?php echo esc_attr($end_date); ?>"
                                data-field="date">
                            <input
                                id="<?php echo esc_attr($end_time_id); ?>"
                                class="form-control<?php echo esc_attr($active . $disabled); ?>"
                                type="time"
                                name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>][end_time]"
                                value="<?php echo esc_attr($end_time); ?>"
                                data-field="time">
                        </div>
                    </div>
                </div>
                <div id="<?php echo esc_attr($name_sanitized); ?>-help" class="form-text date-transient-admin-help">
                    <?php echo esc_html($info); ?>
                </div>
            </div>
<?php
        }

        /**
         * Elimina un campo Date transient admin específico.
         *
         * Maneja la solicitud AJAX para eliminar el transient especificado.
         * Realiza las siguientes acciones:
         * 1. Verifica el nonce para asegurar la legitimidad de la solicitud.
         * 2. Comprueba que el usuario tiene los permisos adecuados para realizar la acción.
         * 3. Obtiene y sanitiza el nombre del transient desde la solicitud AJAX.
         * 4. Elimina el transient y devuelve una respuesta JSON indicando el resultado.
         *
         * @return void
         */
        public function scfs_arnelioconnect_delete_date_transient_admin()
        {
            // Verificar el nonce para seguridad
            check_ajax_referer('arnelioconnect_nonce', 'security');

            // Verificar que el usuario tenga permisos adecuados
            if (!current_user_can('manage_options')) {
                wp_send_json_error('Permisos insuficientes.');
            }

            // Obtener el nombre del transient desde la solicitud AJAX
            $transient_name = isset($_POST['transient_name']) ? sanitize_text_field($_POST['transient_name']) : '';

            if (empty($transient_name)) {
                wp_send_json_error('Nombre de transient no válido.');
            }

            // Eliminar el transient
            $deleted = delete_transient($transient_name);

            if ($deleted) {
                wp_send_json_success('Transient eliminado con éxito.');
            } else {
                wp_send_json_error('No se pudo eliminar el transient.');
            }

        }

        /**
         * Encola los estilos y scripts necesarios para los campos Date Transient Admin en el panel de administración.
         *
         * Esta función recorre cada transient definido en `$this->dateTransientAdmin`. Si el transient existe,
         * encola los archivos CSS y JavaScript correspondientes para gestionar los campos Date Transient Admin.
         * Además, establece las traducciones para los scripts y localiza los datos PHP necesarios para
         * la interacción en el archivo javascript.
         *
         * @return void
         */
        public function enqueue_scripts()
        {
            // Estilos y scripts para el campo Date Transient Admin
            foreach ($this->dateTransientAdmin as $key) {
                if (get_transient($key)) {

                    // Array de opciones en la base de datos
                    $php_options = maybe_unserialize(get_option($this->name_option));


                    wp_enqueue_style($key, ARNELIOCONNECT_DIR_URL  . 'src/admin/modules/date_transient_admin/' . $key . '/' . $key . '.css', array(), ARNELIOCONNECT_VERSION, 'all');
                    wp_enqueue_script($key, ARNELIOCONNECT_DIR_URL . 'src/admin/modules/date_transient_admin/' . $key . '/' . $key . '.js', array('jquery', 'wp-i18n'), ARNELIOCONNECT_VERSION, true);
                    wp_set_script_translations($key, 'arnelioconnect', ARNELIOCONNECT_DIR_PATH . 'languages');
                    wp_localize_script($key, $key, array(
                        'php_options'    => $php_options,
                        'dateTransientAdmin' => $this->dateTransientAdmin,
                    ));
                }
            }
        }
    }
}
