<?php

/**
 * Renderiza un campo de button_toggle clásico en el panel de administración de WordPress.
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
function scfs_arnelioconnect_button_toggle_field($arg)
{

    extract($arg);

    // Asegurar que $values es un array
    if (! is_array($values)) {
        $values = [];
    }

    // Sanitizar el nombre del campo para prevenir problemas de seguridad
    $name_sanitized = sanitize_key($name);

    // Obtener el valor actual del button_toggle
    $current_value = isset($values[$name_sanitized]) ? sanitize_text_field($values[$name_sanitized]) : '0';

    if ($current_value == '0') {
        $text_button = $title;
    }else{
        $text_button= $title2;
    }

?>
<div class="field-arnelio-button_toggle<?php echo $css ?>">
    <input type="hidden" name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]" value="0">
    <input
        class="btn-check"
        type="checkbox"
        name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]"
        id="<?php echo esc_attr($name_sanitized); ?>"
        value="1"
        autocomplete="off"
        <?php checked($current_value, '1'); ?>>
    <label class="btn btn-box-arnelio" data-button-toggle="1" for="<?php echo esc_attr($name_sanitized); ?>">
        <?php echo $text_button ?>
    </label>
</div>
<?php
}
