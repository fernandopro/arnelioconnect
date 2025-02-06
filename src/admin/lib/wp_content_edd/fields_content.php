<?php

class Scfs_fields_content {
    // Estado compartido de la licencia
    protected static $license_status = 'inactive';

    /**
     * Gestiona la validación y activación de licencias
     * @return string|bool El estado de la licencia o false si hay error
     */

     function __construct() {

            // https://arnelio.com - https://stg-arnelio-tarots.kinsta.cloud
            if (!defined('ARNELIOCONNECT_DOMINIO')) {
                define('ARNELIOCONNECT_DOMINIO', 'https://stg-arnelio-tarots.kinsta.cloud');
            }
            if (!defined('ARNELIOCONNECT_ID_PRODUCT')) {
                define('ARNELIOCONNECT_ID_PRODUCT', 123);
            }
            if (!defined('ARNELIOCONNECT_ITEM_NAME')) {
                define('ARNELIOCONNECT_ITEM_NAME', 'arnelioconnect');
            }
            if (!defined('ARNELIOCONNECT_LIC_PAGE')) {
                define('ARNELIOCONNECT_LIC_PAGE', 'scfs_arnelioconnect_license_page');
            }

        add_action('admin_init', [$this, 'checkLicenseStatus']);
    }



    public function checkLicenseStatus() {
        // 1. Intentar obtener licencia en caché
        $pre_mycard_l = get_transient('scfs_arnelioconnect_pre_mycard_l');
        if ($pre_mycard_l) {
            self::$license_status = $pre_mycard_l;
            return self::$license_status;
        }

        // 2. Obtener y validar licencia
        $license = $this->get_sanitized_license();
        if (!$license) {
            $this->log_error('Licencia no válida o vacía');
            return false;
        }

        // 3. Preparar y ejecutar solicitud de activación
        $response = $this->activate_license($license);
        if (is_wp_error($response)) {
            $this->log_error($response->get_error_message());
            return false;
        }

        // 4. Procesar respuesta
        $license_data = $this->process_license_response($response);
        if (!$license_data) {
            return false;
        }

        // 5. Actualizar caché y opciones
        $this->update_license_data($license_data);

        self::$license_status = $license_data->license;
        return self::$license_status;
    }

    /**
     * Obtiene y sanitiza la licencia
     */
    public function get_sanitized_license(): string {
        return sanitize_text_field(trim(get_option('arnelioconnect_license', '')));
    }

    /**
     * Activa la licencia mediante API
     */
    public function activate_license(string $license) {
        $api_params = [
            'edd_action'  => 'activate_license',
            'license'     => $license,
            'item_id'     => ARNELIOCONNECT_ID_PRODUCT,
            'item_name'   => rawurlencode(ARNELIOCONNECT_ITEM_NAME),
            'url'         => home_url(),
            'environment' => wp_get_environment_type()
        ];

        return wp_remote_post(ARNELIOCONNECT_DOMINIO, [
            'timeout' => 15,
            'sslverify' => false,
            'body' => $api_params
        ]);
    }

    /**
     * Procesa la respuesta de la API
     */
    public function process_license_response($response) {
        $license_data = json_decode(wp_remote_retrieve_body($response));
        
        if (!isset($license_data->license)) {
            $error = isset($license_data->error) ? print_r($license_data->error, true) : 'Error desconocido';
            $this->log_error("Error al procesar respuesta de licencia: {$error}");
            return false;
        }

        return $license_data;
    }

    /**
     * Actualiza datos de licencia en la base de datos
     */
    public function update_license_data($license_data) {
        // Guardar en caché temporal
        set_transient(
            'scfs_arnelioconnect_pre_mycard_l', 
            $license_data->license, 
            MINUTE_IN_SECONDS
        );

        // Actualizar array de licencias
        $current_arr = (array) get_option('scfs_arnelioconnect_pre_mycard_arr', []);
        $filtered_arr = array_filter($current_arr); 
        $updated_arr = array_merge($filtered_arr, [
            'arnelioconnect' => $license_data->license
        ]);
        
        update_option('scfs_arnelioconnect_pre_mycard_arr', $updated_arr, 'yes');

        // Gestionar estado
        if ($license_data->license !== 'valid') {
            delete_option('scfs_arnelioconnect_content_id_status');
        }
    }

    /**
     * Registra errores en el log
     */
    public function log_error(string $message): void {
        error_log("arnelioconnect - Error de licencia: {$message}");
    }

    // Método para saber si la licencia está activa
    public static function isLicenseActive(): bool {
        return self::$license_status === 'valid';
    }
}
$Scfs_fields_content = new Scfs_fields_content();