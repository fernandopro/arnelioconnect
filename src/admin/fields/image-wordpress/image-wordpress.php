<?php
          /**
         * Renderiza un campo de subida de imagen en el panel de administración de WordPress.
         *
         * @param array $arg Parámetros del campo: 
         *                   - string $title        Título del campo.
         *                   - array  $values       Valores almacenados en las opciones del plugin.
         *                   - string $name_option  Nombre del array de opciones almacenadas.
         *                   - string $name         Nombre específico del campo.
         *                   - string $info         Descripción del campo.
         *                   - string $css          Clases CSS adicionales para personalización.
         *                   - bool   $docu         Indica si se muestra el enlace de documentación.
         *
         * @return void
         */
        function Scfs_arnelioconnect_image_wordpress_field($arg)
        {
            extract($arg);

              // Asegurar que $values es un array
            if (!is_array($values)) {
                $values = [];
            }

              // Sanitizar el nombre del campo para prevenir problemas de seguridad
            $name_sanitized = sanitize_key($name);

              // Obtener el ID de la imagen almacenada
            $image_id = isset($values[$name_sanitized]) ? intval($values[$name_sanitized]) : '';

              // Obtener la URL de la imagen si hay una imagen seleccionada
            $image_url = $image_id ? wp_get_attachment_url($image_id) : '';

              // Añadir un atributo de datos para identificar el campo de forma única
            $data_field_name = $name_sanitized;

?>
            <div class = "layo-field<?php echo $css ?>">
            <div class = "link-docu-wrapper">
                    <?php if (isset($title)): ?>
                        <h4><?php echo esc_html__($title, 'arnelioconnect'); ?></h4>
                    <?php endif; ?>
                    <?php if ($docu !== null): ?>
                        <a href = "<?php echo esc_attr($docu); ?>" id = "<?php echo $name_sanitized ?>-docu" target = "_blank" class = "link-docu-field"><i class = "bi bi-life-preserver"></i></a>
                    <?php endif; ?>
                </div>
                <div   class = "field-arnelio-image-wordpress" data-field-name = "<?php echo esc_attr($data_field_name); ?>">
                <input type  = "hidden" class                                  = "image-input" name = "<?php echo esc_attr($name_option); ?>[<?php echo esc_attr($name_sanitized); ?>]" value = "<?php echo esc_attr($image_id); ?>">

                    <div class = "image-preview">
                        <?php if ($image_url): ?>
                            <img src = "<?php echo esc_url($image_url); ?>" alt = "" class = "img-thumbnail">
                        <?php endif; ?>
                    </div>
                    <div    class = "field-arnelio-image_content">
                    <div    class = "field-arnelio-image_content__buttons">
                    <button type  = "button" class = "btn btn-box-arnelio upload-button me-3"><?php echo __('Seleccionar imagen', 'arnelioconnect'); ?></button>
                    <button type  = "button" class = "btn btn-box-arnelio remove-button" data-bs-toggle = "tooltip" data-bs-placement = "top" title = "<?php echo __('Delete'); ?>"><i class = "bi bi-trash"></i></button>
                        </div>
                        <?php if (isset($info)): ?>
                            <div id = "<?php echo esc_attr($name_sanitized); ?>-help" class = "form-text">
                                <?php echo esc_html__($info, 'arnelioconnect'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
<?php
        }
