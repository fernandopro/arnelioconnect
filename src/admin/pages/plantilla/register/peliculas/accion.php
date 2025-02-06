<div class="layo-2box-arnelio mb-4">
    <div class="row gy-4">
        <div class="col-md-4 layo-arnelio_section">
            <!-- Sidebar -->
            <div class="card text-bg-default border rounded h-100">
                <!-- Contenido del sidebar -->

                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                    <i class="bi bi-layout-text-sidebar-reverse"></i>
                </div>
                <div class="card-body layo-arnelio_section__body px-4 py-3">


                    <?php
                    // Name
                    $arg = [
                        'title'      => __('Nombre', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'name',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.', 'arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                        'required'   => null,
                        'placeholder' => '...',
                    ];
                    scfs_arnelioconnect_text_field($arg)
                    ?>


                    <?php
                    // Descripcion
                    $arg = [
                        'title'      => __('Textarea', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'descri_peli',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.', 'arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                        'required'   => true,
                        'placeholder' => '...',
                    ];
                    scfs_arnelioconnect_textarea_field($arg)
                    ?>


                    <?php
                    // Descri Wp Editor
                    $arg = [
                        'title'      => __('Wp Editor', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'descri'.'_wp_editor',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.', 'arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null,
                        'placeholder' => '...',
                        'required'   => true,
                    ];
                    scfs_arnelioconnect_wp_editor_field($arg)
                    ?>


                    <?php
                        // Switch
                    $arg = [
                        'title'      => __('Multi lenguaje', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'multi_lang',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    scfs_arnelioconnect_switch_field( $arg )
                    ?>


                </div>

            </div>
        </div>
        <div class="col-md-8 layo-arnelio_section">
            <!-- Área de contenido -->
            <div class="row">
                <div class="layo-2box-arnelio mb-4">
                    <div class="row gy-4">
                        <div class="col-lg-6 layo-arnelio_section">
                            <div style="width:100%" class="card text-bg-default border rounded h-100">

                                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                                    <h3>Edad máxima</span></h3>
                                </div>
                                <div class="card-body layo-arnelio_section__body px-4 py-3">

                                    <?php
                                    // Edad máxima
                                    $arg = [
                                        'title'      => null,
                                        'name_option' => $name_option,
                                        'name'       => 'edad_max',
                                        'initial'    => $initial,
                                        'values'     => $values,
                                        'docu'       => null,
                                        'info'       => __('This is the description of the user information field.', 'arnelioconnect'),
                                        'css'        => ' mb-3',
                                        'blo'        => null,
                                    ];
                                    scfs_arnelioconnect_radio_inline_field($arg)
                                    ?>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 layo-arnelio_section">
                            <div style="width:100%" class="card text-bg-default border rounded h-100">

                                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                                    <h3>Actores de Acción</h3>
                                </div>
                                <div class="card-body layo-arnelio_section__body px-4 py-3">

                                    <?php
                                    // Actores de Acción 
                                    $arg = [
                                        'title'      => null,
                                        'name_option' => $name_option,
                                        'name'       => 'actores_accion',
                                        'initial'    => $initial,
                                        'values'     => $values,
                                        'docu'       => null,
                                        'info'       => __('This is the description of the user information field.', 'arnelioconnect'),
                                        'css'        => ' mb-3',
                                        'blo'        => null,
                                    ];
                                    scfs_arnelioconnect_button_inline_field($arg)
                                    ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <!-- Fila 2 del contenido -->
                    <div class="card text-bg-default border rounded h-100">

                        <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                            <h3>Actrices</h3>
                        </div>
                        <div class="card-body layo-arnelio_section__body px-4 py-3">

                        <?php
                            // actrices
                        $arg = [
                            'title'      => null,
                            'name_option' => $name_option,
                            'name'       => 'actrices_accion',
                            'initial'    => $initial,
                            'values'     => $values,
                            'docu'       => null,
                            'info'       => __('This is the description of the user information field.','arnelioconnect'),
                            'css'        => ' mb-3',
                            'blo'        => null,
                        ];
                        scfs_arnelioconnect_button_inline_m_field( $arg )
                        ?>

                        </div>

                    </div>
                </div>
                <div class="col-12 mb-4">
                    <!-- Fila 3 del contenido -->
                    <div class="card text-bg-default border rounded h-100">

                        <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                            <h3>Duración</h3>
                        </div>
                        <div class="card-body layo-arnelio_section__body px-4 py-3">

                        <?php
                        // Duración
                        $arg = [
                            'title'      => null,
                            'name_option' => $name_option,
                            'name'       => 'duration',
                            'initial'    => $initial,
                            'values'     => $values,
                            'docu'       => null,
                            'info'       => __('This is the description of the user information field.','arnelioconnect'),
                            'css'        => ' mb-3',
                            'blo'        => null,
                        ];
                        Scfs_arnelioconnect_compare_time_field_class::Scfs_arnelioconnect_compare_time_field( $arg);
                        ?>

                        </div>

                    </div>
                </div>
                <div class="col-12">
                    <!-- Fila 4 del contenido -->
                    <div class="layo-2box-arnelio mb-4">
                        <div class="row gy-4">
                            <div class="col-lg-6 layo-arnelio_section">
                                <div style="width:100%" class="card text-bg-default border rounded h-100">

                                    <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                                        <h3>
                                            Subir imagen
                                        </h3>
                                    </div>
                                    <div class="card-body layo-arnelio_section__body px-4 py-3">
                                        <?php
                                            // Image upload
                                        $arg = [
                                            'title'      => null,
                                            'name_option' => $name_option,
                                            'name'       => 'subir_img',
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
                                        <h3><span class="placeholder bg-secondary col-6"></span></h3>
                                    </div>
                                    <div class="card-body layo-arnelio_section__body px-4 py-3">
                                        <span class="placeholder bg-secondary col-6"></span>
                                        <span class="placeholder bg-secondary col-7"></span>
                                        <span class="placeholder bg-secondary col-4"></span>
                                        <span class="placeholder bg-secondary col-4"></span>
                                        <span class="placeholder bg-secondary col-6"></span>
                                        <span class="placeholder bg-secondary col-8"></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>