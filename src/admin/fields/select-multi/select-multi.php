<?php 
/**
 * Renderiza un campo de selección múltiple (select multiple) personalizado en el panel de administración de WordPress.
 *
 * @param array $arg Parámetros del campo:
 *                   - string $title        Título del campo.
 *                   - array  $initial      Opciones iniciales del campo select múltiple.
 *                   - array  $values       Valores almacenados en las opciones del plugin.
 *                   - string $name_option   Nombre del array de opciones almacenadas.
 *                   - string $name         Nombre específico del campo select múltiple.
 *                   - string $info         Descripción del campo.
 *                   - string $css          Clases CSS adicionales para personalización.
 *                   - bool   $docu         Indica si se muestra el enlace de documentación.
 *
 * @return void
 */
function scfs_arnelioconnect_select_m_field($arg)
{

    // Extraer los argumentos para facilitar el acceso a las variables
    extract($arg);

    // Asegurar que $values es un array
    if (! is_array($values)) {
        $values = [];
    }

    // Sanitizar el nombre del campo para prevenir problemas de seguridad
    $name_sanitized = sanitize_key($name);

    // Obtener los valores actuales del campo select múltiple
    $current_values = isset($values[$name_sanitized]) && is_array($values[$name_sanitized])
        ? array_map('sanitize_text_field', $values[$name_sanitized])
        :  [];
?>
    <div class="layo-field<?php echo $css?>">
        <div class="link-docu-wrapper">
            <?php if (isset($title)): ?>
                <h4><?php echo esc_html__($title, 'arnelioconnect'); ?></h4>
            <?php endif; ?>
            <?php if ($docu !== null): ?>
                <a href="<?php echo esc_attr( $docu ); ?>" id="<?php echo $name_sanitized?>-docu" target="_blank" class="link-docu-field"><i class="bi bi-life-preserver"></i></a>
            <?php endif; ?>
        </div>
        <div class="field-arnelio-select-multi">
            <select
                id="<?php echo esc_attr($name_sanitized); ?>"
                class="form-select"
                name="<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>][]"
                aria-label="<?php echo esc_attr($name_sanitized); ?>"
                multiple>
                <?php foreach ($initial[$name] as $index => $value): ?>
                    <option
                        value="<?php echo esc_attr($index); ?>"
                        <?php echo in_array($index, $current_values, true) ? 'selected="selected"' : ''; ?>>
                        <?php echo esc_html($value); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($info)): ?>
                <div id="<?php echo esc_attr($name_sanitized); ?>-help" class="form-text">
                    <?php echo esc_html__($info, 'arnelioconnect'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
}
