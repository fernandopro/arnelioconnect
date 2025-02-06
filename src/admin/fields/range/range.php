<?php 
/**
 * Renderiza un campo de rango personalizado en el panel de administración de WordPress.
 *
 * @param array $arg Parámetros del campo:
 *                   - string $title         Título del campo.
 *                   - array  $values        Valores almacenados en las opciones del plugin.
 *                   - string $name_option    Nombre del array de opciones almacenadas.
 *                   - string $name          Nombre específico del campo.
 *                   - int    $min           Valor mínimo permitido.
 *                   - int    $max           Valor máximo permitido.
 *                   - int    $step          Incremento del rango.
 *                   - string $info          Descripción del campo.
 *                   - string $css           Clases CSS adicionales para personalización.
 *
 * @return void
 */
function scfs_arnelioconnect_range_field($arg)
{

    // Extraer los argumentos para facilitar el acceso a las variables
    extract($arg);

    // Asegurar que $values es un array
    if (! is_array($values)) {
        $values = [];
    }

    // Sanitizar el nombre del campo para prevenir problemas de seguridad
    $name_sanitized = sanitize_key($name);

    // Obtener el valor actual del campo de rango, asegurando que es numérico
    $current_value = isset($values[$name_sanitized]) ? intval($values[$name_sanitized]) : $min;

    // Valores adicionales con sanitización
    $min         = isset($min) ? intval($min) : 0;
    $max         = isset($max) ? intval($max) : 100;
    $step        = isset($step) ? intval($step) : 1;

?>
    <div class="layo-field<?php echo $css?>">
        <div class="field-arnelio-range form-check">
            <div class="field-arnelio-range-content">
                <div class="link-docu-wrapper">
                    <?php if (isset($title)): ?>
                        <h4><?php echo esc_html__($title, 'arnelioconnect'); ?></h4>
                    <?php endif; ?>
                    <?php if ($docu !== null): ?>
                        <a href="<?php echo esc_attr( $docu ); ?>" id="<?php echo $name_sanitized?>-docu" target="_blank" class="link-docu-field"><i class="bi bi-life-preserver"></i></a>
                    <?php endif; ?>
                </div>
                <?php if (isset($info)): ?>
                    <div class="form-check-label" for="<?php echo esc_attr($name_sanitized); ?>">
                        <?php echo esc_html__($info, 'arnelioconnect'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-range-content d-flex align-items-center justify-content-between w-100">
                <input
                    id="<?php echo esc_attr($name_sanitized); ?>"
                    type="range"
                    min="<?php echo esc_attr($min); ?>"
                    max="<?php echo esc_attr($max); ?>"
                    step="<?php echo esc_attr($step); ?>"
                    name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]"
                    class="form-range"
                    value="<?php echo esc_attr($current_value); ?>">
                <div class="badge-light" id="<?php echo esc_attr($name_sanitized); ?>_value"><?php echo esc_attr($current_value); ?></div>
            </div>
            <script type="module">
                document.addEventListener('DOMContentLoaded', () => {
                    const rangeInput = document.getElementById('<?php echo esc_js($name_sanitized); ?>');
                    const rangeValue = document.getElementById('<?php echo esc_js($name_sanitized); ?>_value');

                    if (rangeInput && rangeValue) {
                        rangeInput.addEventListener('input', () => {
                            rangeValue.textContent = `${rangeInput.value}`;
                        });
                    }
                });
            </script>
        </div>
    </div>
<?php
}
