<?php 
/**
 * Renderiza un campo de botones de radio simples en línea en el panel de administración de WordPress.
 *
 * @param array $arg Parámetros del campo:
 *                   - string $title        Título del campo.
 *                   - array  $initial      Opciones iniciales del campo de radio.
 *                   - array  $values       Valores almacenados en las opciones del plugin.
 *                   - string $name_option   Nombre del array de opciones almacenadas.
 *                   - string $name         Nombre específico del campo de radio.
 *                   - string $info         Descripción del campo.
 *                   - string $css          Clases CSS adicionales para personalización.
 *
 * @return void
 */
function scfs_arnelioconnect_button_inline_field($arg)
{

    extract($arg);

    // Asegurar que $values es un array
    if (! is_array($values)) {
        $values = [];
    }

    // Sanitizar el nombre del campo para prevenir problemas de seguridad
    $name_sanitized = sanitize_key($name);

    // Obtener el valor seleccionado actualmente
    $current_value = isset($values[$name_sanitized]) ? sanitize_text_field($values[$name_sanitized]) : '';

?>
    <div class="layo-field<?php echo $css?>">
        <div class="link-docu-wrapper">
            <?php if (isset($title) && $title): ?>
                <h4><?php echo esc_html__($title, 'arnelioconnect'); ?></h4>
            <?php endif; ?>
            <?php if ($docu !== null): ?>
                <a href="<?php echo esc_attr( $docu ); ?>" id="<?php echo $name_sanitized?>-docu" target="_blank" class="link-docu-field"><i class="bi bi-life-preserver"></i></a>
            <?php endif; ?>
        </div>
        <div class="field-arnelio-button_inline">
            <?php foreach ($initial[$name] as $index => $value):
                // Generar un ID único para cada opción de radio
                $radio_id     = $name_sanitized . '_' . $index;
                $active_class = ($current_value === $index) ? ' active' : '';
            ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]" id="<?php echo esc_attr($radio_id); ?>" value="<?php echo esc_html($index); ?>" <?php checked($current_value, $index); ?>>
                    <label class="btn btn-outline-primary<?php echo $active_class; ?>" for="<?php echo esc_attr($radio_id); ?>"><?php echo esc_attr($value); ?></label>
                </div>
            <?php endforeach; ?>
            <?php if (isset($info)): ?>
                <div id="<?php echo esc_attr($name_sanitized); ?>-help" class="form-text">
                    <?php echo esc_html__($info, 'arnelioconnect'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
}