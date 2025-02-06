<?php
if (!class_exists('Scfs_arnelioconnect_color_picker_class')) {
    final class Scfs_arnelioconnect_color_picker_class
    {

        private $urlPostype;
        private $urlTaxonomy;
        private $urlPage;
        private $name_page;

        public function __construct($urlPostype, $urlPage, $urlTaxonomy, $name_page)
        {

            $this->urlPostype  = $urlPostype;
            $this->urlTaxonomy = $urlTaxonomy;
            $this->urlPage     = $urlPage;
            $this->name_page     = $name_page;

            // Solo se cargan los scripts si se está en la página de configuración del plugin
            if (defined('IS_URL_ARNELIOCONNECT') && IS_URL_ARNELIOCONNECT) {
            }


            // Añadir scripts para los campos Color Picker solo en la pagina
            if ($this->urlPage == $name_page ) {
                add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
            }

        }

        /**
         * Renderiza un campo de selección de color personalizado en el panel de administración de WordPress.
         *
         * @param array $arg Parámetros del campo:
         *                   - string $title         Título del campo.
         *                   - array  $values        Valores almacenados en las opciones del plugin.
         *                   - string $name_option    Nombre del array de opciones almacenadas.
         *                   - string $name          Nombre específico del campo.
         *                   - string $info          Descripción del campo.
         *                   - string $css           Clases CSS adicionales para personalización.
         *
         * @return void
         */
        public static function scfs_arnelioconnect_color_field($arg)
        {

            // Extraer los argumentos para facilitar el acceso a las variables
            extract($arg);

            // Asegurar que $values es un array
            if (! is_array($values)) {
                $values = [];
            }

            // Sanitizar el nombre del campo para prevenir problemas de seguridad
            $name_sanitized = sanitize_key($name);

            // Obtener el valor actual del campo de color, asegurando que es una cadena
            $current_value = isset($values[$name_sanitized]) ? sanitize_text_field($values[$name_sanitized]) : '';

?>
            <div class="layo-field<?php echo $css ?>">
                <div class="field-arnelio-color form-check d-flex align-items-center justify-content-between w-100">
                    <div class="field-arnelio-color-content">
                        <div class="link-docu-wrapper">
                            <?php if (isset($title)): ?>
                                <h4><?php echo esc_html__($title, 'arnelioconnect'); ?></h4>
                            <?php endif; ?>
                            <?php if ($docu !== null): ?>
                                <a href="<?php echo esc_attr($docu); ?>" id="<?php echo $name_sanitized ?>-docu" target="_blank" class="link-docu-field"><i class="bi bi-life-preserver"></i></a>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($info)): ?>
                            <div class="form-check-label" for="<?php echo esc_attr($name_sanitized); ?>">
                                <?php echo esc_html__($info, 'arnelioconnect'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <input
                        type="text"
                        id="<?php echo esc_attr($name_sanitized); ?>"
                        name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]"
                        class="color-picker form-control"
                        data-alpha-enabled="true"
                        data-alpha-color-type="hex"
                        value="<?php echo esc_attr($current_value); ?>">
                </div>
            </div>
<?php
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

            // JS - wp-color-picker-alpha.min // url: https://github.com/kallookoo/wp-color-picker-alpha
            wp_enqueue_style('wp-color-picker');
            wp_register_script('wp-color-picker-alpha', ARNELIOCONNECT_DIR_URL . 'src/admin/lib/wp-color-picker-alpha.min.js', array('wp-color-picker'), ARNELIOCONNECT_VERSION, true);
            wp_add_inline_script(
                'wp-color-picker-alpha',
                'jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
            );
            wp_enqueue_script('wp-color-picker-alpha');
        }
    }
}
