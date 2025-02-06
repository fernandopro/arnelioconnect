<?php
/**
 * Renderiza un campo de edición de texto usando wp_editor() en el panel de administración de WordPress.
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
 *                   - int    $rows         Cantidad de líneas visibles en el editor.
 *                   - bool   $required     Indica si el campo es obligatorio.
 *
 * @return void
 */
function scfs_arnelioconnect_wp_editor_field($arg)
{

    extract($arg);


    // Asegurar que $values es un array
    if (! is_array($values)) {
        $values = [];
    }

    // Sanitizar el nombre del campo para prevenir problemas de seguridad
    $name_sanitized = sanitize_key($name);

    // Obtener el valor actual del campo de texto
    $current_value = isset($values[$name_sanitized]) ? wp_kses_post($values[$name_sanitized]) : '';
    $placeholder = isset($placeholder) ? sanitize_text_field($placeholder) : '';
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
        <div class="field-arnelio-wp-editor">
            <?php
            wp_editor(
                $current_value,
                $name_sanitized,
                array(
                    'textarea_name' => $name_option . '[' . $name_sanitized . ']',
                    'media_buttons' => false,
                    'textarea_rows' => $rows,
                    'teeny'         => false,
                    'quicktags'     => true,
                    'wpautop'       => true, // Evita que se elimine o corrija el HTML
                )
            );
            ?>
            <?php if (isset($info)): ?>
                <div id="<?php echo esc_attr($name_sanitized); ?>-help" class="form-text">
                    <?php echo esc_html__($info, 'arnelioconnect'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
}
