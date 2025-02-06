<?php
if (!class_exists('Scfs_arnelioconnect_compare_time_field_class')) {
    final class Scfs_arnelioconnect_compare_time_field_class
    {

        private $compareTimeField;
        private $name_option;

        public function __construct($compareTimeField, $name_option)
        {
            $this->compareTimeField = $compareTimeField;
            $this->name_option    = $name_option;


            // Registrar hooks de acción para AJAX
            add_action('wp_ajax_scfs_arnelioconnect_delete_compare_time_field', array($this, 'scfs_arnelioconnect_delete_compare_time_field'));
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
        public static function Scfs_arnelioconnect_compare_time_field($arg)
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
            $active = scfs_arnelioconnect_compare_time($compare_start, $compare_end) == true  ? ' btn-date-time' : '';
            $disabled = (scfs_arnelioconnect_compare_time($compare_start, $compare_end) == false && current_time('timestamp', true) > $end_timestamp || scfs_arnelioconnect_compare_time($compare_start, $compare_end) == false && current_time('timestamp', true) < $start_timestamp) ? ' disabled_date' : '';


            // Generar IDs únicos para los elementos
            $start_date_id    = esc_attr($name_sanitized) . '_start_date';
            $start_time_id    = esc_attr($name_sanitized) . '_start_time';
            $end_date_id      = esc_attr($name_sanitized) . '_end_date';
            $end_time_id      = esc_attr($name_sanitized) . '_end_time';
            $delete_button_id = esc_attr($name_sanitized) . '_delete_value';
            $finished_button_id = esc_attr($name_sanitized) . '_finished_value';
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
                        <?php if ( scfs_arnelioconnect_compare_time($compare_start, $compare_end) == true ): ?>
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


                            <?php if (current_time('timestamp', true) > $end_timestamp ): ?>

                                <span class="badge text-bg-warning">
                                    <?php
                                    echo __('Finished', 'arnelioconnect');
                                    ?>
                                </span>
                                <button
                                    id="<?php echo esc_attr($finished_button_id); ?>"
                                    type="button"
                                    class="btn btn-warning"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="<?php echo __('Delete', 'arnelioconnect'); ?>">
                                    <i style="font-size: 1.2rem;" class="bi bi-trash"></i>
                                </button>

                            <?php elseif( current_time('timestamp', true) < $start_timestamp ): ?>

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
                <div class="field-arnelio-compare-time-field">
                    <div class="field-arnelio-compare-time-field__content">
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

                    <div class="field-arnelio-compare-time-field__content">
                        <div class="compare-time-field_end-notification">
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
                <div id="<?php echo esc_attr($name_sanitized); ?>-help" class="form-text compare-time-field-help">
                    <?php echo esc_html($info); ?>
                </div>
            </div>
<?php
        }

        /**
         * Elimina un campo Compare time field específico.
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
        public function scfs_arnelioconnect_delete_compare_time_field()
        {
            // Validar nonce
            check_ajax_referer('arnelioconnect_nonce', 'security');

            // Verificar permisos mínimos
            if (!current_user_can('manage_options')) {
                wp_send_json_error(__('No permissions.', 'arnelioconnect'));
            }

            // Recibir el nombre del campo
            $field_name = isset($_POST['field_name']) ? sanitize_text_field($_POST['field_name']) : '';
            if (!$field_name) {
                wp_send_json_error(__('Field missing.', 'arnelioconnect'));
            }

             // Recibir el nombre del campo
             $name_field_options = isset($_POST['name_field_options']) ? sanitize_text_field($_POST['name_field_options']) : '';
             if (!$name_field_options) {
                 wp_send_json_error(__('Field missing.', 'arnelioconnect'));
             }

            $post_id  =  isset($_POST['post_id'] ) ? absint($_POST['post_id']) : 0;



            if ($post_id !== 0) {
                // Array de opciones en la base de datos
                $database_get_options = maybe_unserialize(get_post_meta($post_id, $name_field_options, true));
                // valor que quiero resetear dentro del array de valores de la base de datos
                $database_get_options[$field_name] = [
                    'start'      => '',
                    'end'        => '',
                    'start_date' => '',
                    'start_time' => '',
                    'end_date'   => '',
                    'end_time'   => '',
                ];

                // Actualizar el campo en la base de datos
                update_post_meta($post_id, $name_field_options, $database_get_options);

            } else {
                // Obtener las opciones de la base de datos y asegurarse de que es un array
                $database_get_options = maybe_unserialize( get_option( $name_field_options ) );
                if ( ! is_array( $database_get_options ) ) {
                    $database_get_options = [];
                }


                // valor que quiero resetear dentro del array de valores de la base de datos
                $database_get_options[$field_name] = [
                    'start'      => '',
                    'end'        => '',
                    'start_date' => '',
                    'start_time' => '',
                    'end_date'   => '',
                    'end_time'   => '',
                ];

                // Guardar el array actualizado en la base de datos
                update_option( $name_field_options, $database_get_options );
            }


            wp_send_json_success(__('Reset done.', 'arnelioconnect'));
        }
    }
}
