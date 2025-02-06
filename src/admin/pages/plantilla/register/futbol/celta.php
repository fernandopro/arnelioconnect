<div class="layo-1box-arnelio mb-4">
    <div class="row gy-4">
        <div class="col layo-arnelio_section">
            <div style="width:100%" class="card text-bg-default border rounded h-100">

                <div class="layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100 rounded">
                    <h3><i class="bi bi-wordpress"></i> Versión de WordPress</h3>
                    <div class="badge-light">6.7.1</div>
                </div>

            </div>
        </div>
    </div>
</div>




<div class="layo-2box-arnelio mb-4">
    <div class="row gy-4">
        <div class="col-lg-6 layo-arnelio_section">
            <div style="width:100%" class="card text-bg-default border rounded h-100">

                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                    <h3>Título box 1</h3>
                </div>
                <div class="card-body layo-arnelio_section__body px-4 py-3">

                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo optio error necessitatibus, dolores molestias accusamus minus, officia consequuntur eaque nam commodi animi sequi quod omnis consequatur sit eos earum vitae.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque iure deserunt in magnam, velit quos voluptatum alias ea tenetur ullam fuga impedit pariatur ipsa cum quae saepe earum minima. Totam?</p>


                    <?php
                        // Pilotos de la Fórmula 1
                    $arg = [
                        'title'      => __('Pilotos de la Fórmula 1', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'pilotos_f1',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => 'https://www.formula1.com/',
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_select_field( $arg )
                    ?>


                    <?php
                        // Tenistas
                    $arg = [
                        'title'      => __('Tenistas', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'tenistas',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_select_m_field( $arg )
                    ?>


                    <?php
                        // Spreads
                    $arg = [
                        'title'      => __('Spreads', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'spreads',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_image_radio_field( $arg )
                    ?>


                </div>

            </div>
        </div>
        <div class="col-lg-6 layo-arnelio_section">
            <div style="width:100%" class="card text-bg-default border rounded h-100">

                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                    <h3>Probando Varios Fields</h3>
                </div>
                <div class="card-body layo-arnelio_section__body px-4 py-3">

                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores possimus nostrum velit, rem in maxime sequi. Aliquam architecto quas pariatur reiciendis, porro laborum tempora saepe, qui dolorum sapiente itaque minima.</p>


                    <?php
                        // Jugadores
                    $arg = [
                        'title'      => __('Jugadores', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'jugadores',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_radio_inline_field( $arg )
                    ?>



                    <?php
                        // Arroz con leche
                    $arg = [
                        'title'      => __('Arroz con leche', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'arroz_con_leche',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_button_inline_m_field( $arg )
                    ?>



                     <?php
                        // Flan
                    $arg = [
                        'title'      => __('Flan', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'flan',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_checkbox_m_field( $arg )
                    ?>



                    <?php
                        // Balon 4
                    $arg = [
                        'title'      => null,
                        'name_option' => $name_option,
                        'name'       => 'balon4',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_checkbox_field( $arg )
                    ?>


                </div>

            </div>
        </div>
    </div>
</div>




<div class="layo-2box-arnelio mb-4">
    <div class="row gy-4">
        <div class="col-lg-6 layo-arnelio_section">
            <div style="width:100%" class="card text-bg-default border rounded h-100">

                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                    <h3>Title para el swictch</h3>
                </div>
                <div class="card-body layo-arnelio_section__body px-4 py-3">

                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus dolore quo totam in nostrum consequuntur expedita consectetur dicta, debitis delectus accusantium, exercitationem porro. Similique, pariatur. Laudantium consequatur ut rerum repellendus?</p>



                    <?php
                        // Title field switch
                    $arg = [
                        'title'      => __('Title field switch', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'balon',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, molestias nobis, qui illo est nesciunt quod cum consequuntur eos quia adipisci.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_switch_field( $arg )
                    ?>
                    


                    <?php
                        // Activar modo Pro
                    $arg = [
                        'title'      => __('Activar modo Pro', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'balon2',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, molestias nobis, qui illo est nesciunt quod cum consequuntur eos quia adipisci.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_switch_field( $arg )
                    ?>

                    
                    <?php
                        // Activar extras
                    $arg = [
                        'title'      => __('Activar Extras', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'balon3',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, molestias nobis, qui illo est nesciunt quod cum consequuntur eos quia adipisci.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_switch_field( $arg )
                    ?>



                    <?php
                        // Title Color Pro
                    $arg = [
                        'title'      => __('Title Color Pro', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'title_color',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, molestias nobis, qui illo est nesciunt quod cum consequuntur eos quia adipisci.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                    ];
                    Scfs_arnelioconnect_color_picker_class::scfs_arnelioconnect_color_field( $arg )
                    ?>

                    <?php
                        // SubTitle Color Pro
                    $arg = [
                        'title'      => __('SubTitle Color Pro', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'subtitle_color',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, molestias nobis, qui illo est nesciunt quod cum consequuntur eos quia adipisci.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                    ];
                    Scfs_arnelioconnect_color_picker_class::scfs_arnelioconnect_color_field( $arg )
                    ?>



                    <?php
                        // Tamaño del contenedor
                    $arg = [
                        'title'      => __('Tamaño del contenedor', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'range_size',
                        'initial'    => $initial,
                        'values'     => $values,
                        'min'        => 0,
                        'max'        => 100,
                        'step'       => 1,
                        'docu'       => null,
                        'info'       => __('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, molestias nobis, qui illo est nesciunt quod cum consequuntur eos quia adipisci.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                        'placeholder' => '20',
                    ];
                    scfs_arnelioconnect_range_field( $arg )
                    ?>



                    <?php
                    // Date Deporte
                    $arg = [
                        'title'      => __('Date Deporte', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'date_transient_admin_deportes',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, molestias nobis, qui illo est nesciunt quod cum consequuntur eos quia adipisci.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                    ];
                    Scfs_arnelioconnect_date_transient_admin_class::Scfs_arnelioconnect_date_transient_admin_field( $arg)
                    ?>


                    <?php
                    // Date reloj 1 in page
                    $arg = [
                        'title'      => __('Reloj 1', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'reloj1',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => true,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    Scfs_arnelioconnect_compare_time_field_class::Scfs_arnelioconnect_compare_time_field( $arg);


                    ?>

                    <?php
                    // Date reloj 2 in page
                    $arg = [
                        'title'      => __('Reloj 2', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'reloj2',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => true,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    Scfs_arnelioconnect_compare_time_field_class::Scfs_arnelioconnect_compare_time_field( $arg);


                    ?>



                    <?php
                        // Image upload
                    $arg = [
                        'title'      => __('Image upload', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'image_portada',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                    ];
                   Scfs_arnelioconnect_image_wordpress_field( $arg )
                    ?>


                </div>
            </div>
        </div>
        <div class="col-lg-6 layo-arnelio_section">
            <div style="width:100%" class="card text-bg-default border rounded h-100">

                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                    <h3>Entrenadores</h3>
                </div>
                <div class="card-body layo-arnelio_section__body px-4 py-3">

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos soluta, laborum cum nemo ut similique repellat porro quis odio quam consequuntur perferendis adipisci fugit autem eius reiciendis? Fugit, magnam maxime.</p>


                    <?php
                        // Nombre
                    $arg = [
                        'title'      => __('Nombre', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'nombre',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => true,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                        'required'   => true,
                        'placeholder' => '...',
                    ];
                    scfs_arnelioconnect_text_field( $arg )
                    ?>


                    <?php
                        // Nombre descripción
                    $arg = [
                        'title'      => __('Descripción Wp_editor', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'nombre_descripcion'.'_wp_editor',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                        'placeholder' => '...',
                        'required'   => true,
                        'rows'       => 5,
                    ];
                    scfs_arnelioconnect_wp_editor_field( $arg )
                    ?>


                    <?php
                        // Textarea
                    $arg = [
                        'title'      => __('Textarea', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'descripcion',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                        'placeholder' => '...',
                        'required'   => true,
                        'rows'       => 5,
                    ];
                    scfs_arnelioconnect_textarea_field( $arg )
                    ?>


<?php
                        // Custom CSS
                    $arg = [
                        'title'      => __('Custom Css', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'custom_css'.'_textarea',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null
                    ];
                    scfs_arnelioconnect_custom_css_field( $arg )
                    ?>



                    <?php
                        // Number
                    $arg = [
                        'title'      => __('Number', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'number',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                        'required'   => true,
                    ];
                    scfs_arnelioconnect_number_field( $arg )
                    ?>



                    <?php
                        // Entrenadores
                    $arg = [
                        'title'      => __('Entrenadores', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'entrenadores',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                        'required'   => true,
                    ];
                    scfs_arnelioconnect_button_inline_field( $arg )
                    ?>



                    <?php
                        // Helado
                    $arg = [
                        'title'      => __('Helado', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'helado',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_button_inline_field( $arg )
                    ?>



                    <?php
                    // Date Comidas
                    $arg = [
                        'title'      => __('Date Comidas', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'date_transient_admin_comidas',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => true,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    Scfs_arnelioconnect_date_transient_admin_class::Scfs_arnelioconnect_date_transient_admin_field( $arg);

                    ?>




                    <?php
                        // Tamaño del contenedor
                    $arg = [
                        'title'      => __('Volumen', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'range_size2',
                        'initial'    => $initial,
                        'values'     => $values,
                        'min'        => 0,
                        'max'        => 100,
                        'step'       => 1,
                        'docu'       => null,
                        'info'       => __('Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, molestias nobis, qui illo est nesciunt quod cum consequuntur eos quia adipisci.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                        'placeholder' => '20',
                    ];
                    scfs_arnelioconnect_range_field( $arg )
                    ?>


                    <?php
                        // Subir imagen
                    $arg = [
                        'title'      => __('Subir imagen', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'image_fondo',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                    ];
                    Scfs_arnelioconnect_image_wordpress_field( $arg )
                    ?>



                </div>

            </div>
        </div>
    </div>
</div>
