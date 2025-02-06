<?php 
/**
 * Renderiza un campo de radio en línea personalizado en el panel de administración de WordPress.
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
function scfs_arnelioconnect_image_radio_field($arg)
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
    <div class="layo-field<?php echo $css ?>">
        <div class="link-docu-wrapper">
            <?php if (isset($title) && $title): ?>
                <h4><?php echo esc_html__($title, 'arnelioconnect'); ?></h4>
            <?php endif; ?>
            <?php if ($docu !== null): ?>
                <a href="<?php echo esc_attr( $docu ); ?>" id="<?php echo $name_sanitized?>-docu" target="_blank" class="link-docu-field"><i class="bi bi-life-preserver"></i></a>
            <?php endif; ?>
        </div>
        <div class="field-arnelio-image-radio">
            <?php foreach ($initial[$name] as $index => $value):
                // Generar un ID único para cada opción de radio
                $radio_id = $name_sanitized . '_' . $index;
            ?>
                <div class="form-check-image-radio">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]"
                        id="<?php echo esc_attr($radio_id); ?>"
                        value="<?php echo esc_attr($index); ?>"
                        <?php checked($current_value, $index); ?>>
                    <label class="form-check-label" for="<?php echo esc_attr($radio_id); ?>">
                        <img class="form-check-image img-fluid img-thumbnail" src="<?php echo esc_attr( $value ) ?>">    
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (isset($info)): ?>
                <div id="<?php echo esc_attr($name_sanitized); ?>-help" class="form-text">
                    <?php echo esc_html__($info, 'arnelioconnect'); ?>
                </div>
            <?php endif; ?>
    </div>
<?php
}
