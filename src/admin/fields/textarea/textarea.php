<?php
/**
 * Renderiza un campo de textarea personalizado en el panel de administración de WordPress.
 *
 * @param array $arg Parámetros del campo:
 *                   - array  $initial      Opciones iniciales del campo select múltiple.
 *                   - array  $values       Valores almacenados en las opciones del plugin.
 *                   - string $name_option   Nombre del array de opciones almacenadas.
 *                   - string $name         Nombre específico del campo.
 *                   - string $placeholder   Texto de marcador de posición.
 *                   - string $title        Título del campo.
 *                   - string $info         Descripción del campo.
 *                   - string $css          Clases CSS adicionales para personalización.
 *                   - bool   $docu         Indica si se muestra el enlace de documentación.
 *                   - int $rows            Cantidad de líneas visibles en el textarea.
 *                   - bool   $required     (Nuevo) Indica si el campo es obligatorio.
 *
 * @return void
 */
function scfs_arnelioconnect_textarea_field($arg)
{

    extract($arg);


    // Asegurar que $values es un array
    if (! is_array($values)) {
        $values = [];
    }

    // Sanitizar el nombre del campo para prevenir problemas de seguridad
    $name_sanitized = sanitize_key($name);

    // Obtener el valor actual del campo de texto
    $current_value = isset($values[$name_sanitized]) ? sanitize_textarea_field($values[$name_sanitized]) : '';
    $placeholder = isset($placeholder) ? sanitize_textarea_field($placeholder) : '';
    $rows = isset($rows) ? intval($rows) : 5;

?>
    <div class="layo-field<?php echo $css?>">
        <div class="link-docu-wrapper">
            <?php if (isset($title) && $title): ?>
                <h4>
                    <?php echo esc_html__($title, 'arnelioconnect'); ?>
                    <?php echo ((isset($required) && $required) && empty($current_value)) ? '<span class="badge text-bg-danger">'.__('Required', 'arnelioconnect').'</span>' : ''; ?>
                </h4>
            <?php endif; ?>
            <?php if ($docu !== null): ?>
                <a href="<?php echo esc_attr( $docu ); ?>" id="<?php echo $name_sanitized?>-docu" target="_blank" class="link-docu-field"><i class="bi bi-life-preserver"></i></a>
            <?php endif; ?>
        </div>
        <div class="field-arnelio-textarea">
            <textarea
                class="form-control"
                rows="<?php echo esc_attr($rows); ?>"
                id="<?php echo esc_attr($name_sanitized); ?>"
                aria-describedby="<?php echo esc_attr($name_sanitized); ?>-help"
                name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]"
                placeholder="<?php echo esc_attr($placeholder); ?>"><?php echo esc_textarea($current_value); ?></textarea>
            <?php if (isset($info)): ?>
                <div id="<?php echo esc_attr($name_sanitized); ?>-help" class="form-text">
                    <?php echo esc_html__($info, 'arnelioconnect'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
}
