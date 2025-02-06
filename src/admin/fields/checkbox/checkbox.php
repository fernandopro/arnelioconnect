<?php 
/**
 * Renderiza un campo de checkbox clásico en el panel de administración de WordPress.
 *
 * @param array $arg Parámetros del campo:
 *                   - string $title        Título del campo.
 *                   - array  $values       Valores almacenados en las opciones del plugin.
 *                   - string $name_option   Nombre del array de opciones almacenadas.
 *                   - string $name         Nombre específico del campo.
 *                   - string $info         Descripción del campo.
 *                   - string $css          Clases CSS adicionales para personalización.
 *
 * @return void
 */
function scfs_arnelioconnect_checkbox_field($arg)
{

    extract($arg);

    // Asegurar que $values es un array
    if (! is_array($values)) {
        $values = [];
    }

    // Sanitizar el nombre del campo para prevenir problemas de seguridad
    $name_sanitized = sanitize_key($name);

    // Obtener el valor actual del checkbox
    $current_value = isset($values[$name_sanitized]) ? sanitize_text_field($values[$name_sanitized]) : '0';

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
        <div class="field-arnelio-checkbox">
            <div class="form-check">
                <input type="hidden" name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]" value="0">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]"
                    id="<?php echo esc_attr($name_sanitized); ?>"
                    value="1"
                    <?php checked($current_value, '1'); ?>>
                <label class="form-check-label" for="<?php echo esc_attr($name_sanitized); ?>">
                    <?php echo esc_html__($info, 'arnelioconnect'); ?>
                </label>
            </div>
        </div>
    </div>
<?php
}
