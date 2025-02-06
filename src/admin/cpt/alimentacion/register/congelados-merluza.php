<div class="layo-2box-arnelio mb-4">
    <div class="row gy-4">
        <div class="col-lg-6 layo-arnelio_section">
            <div style="width:100%" class="card text-bg-default border rounded h-100">

                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                    <h3>Tipo</h3>
                </div>
                 <div class="card-body layo-arnelio_section__body px-4 py-3">
                    

                 <?php
                // Radio buttons inline
            $arg = [
                'title'      => __('Radio buttons inline', 'arnelioconnect'),
                'name_option' => $name_option,
                'name'       => 'merluza_tipo',
                'initial'    => $initial,
                'values'     => $values,
                'docu'       => null,
                'info'       => __('This is the description of the user information field.','arnelioconnect'),
                'css'        => ' mb-3',
                'blo'        => null,
            ];
            scfs_arnelioconnect_button_inline_field( $arg )
            ?>


                    <?php
                    // Date espacio
                    $arg = [
                        'title'      => __('Espacio', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'espacio',
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
                    // Date espacio2
                    $arg = [
                        'title'      => __('Espacio 2', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'espacio2',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => true,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' layo-field-bg mb-3',
                        'blo'        => null,
                    ];
                    Scfs_arnelioconnect_compare_time_field_class::Scfs_arnelioconnect_compare_time_field( $arg);

                    ?>



                </div>

            </div>
        </div>
        <div class="col-lg-6 layo-arnelio_section">
            <div style="width:100%" class="card text-bg-default border rounded h-100">

                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                    <h3>Ofertas</h3>
                </div>
                 <div class="card-body layo-arnelio_section__body px-4 py-3">
                   


                    <?php
                    // Date tiempo
                    $arg = [
                        'title'      => __('Tiempo', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'tiempo',
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
                    // Date tiempo 2
                    $arg = [
                        'title'      => __('Tiempo 2', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'tiempo2',
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
                          // Button toggle
                        $arg = [
                            'title'       => __('Activar', 'arnelioconnect'),
                            'title2'  => __('Desactivar', 'arnelioconnect'),
                            'name_option' => $name_option,
                            'name'        => 'active_time',
                            'initial'     => $initial,
                            'values'      => $values,
                            'css'         => '',
                            'blo'         => null,
                        ];
                        scfs_arnelioconnect_button_toggle_field( $arg);
                        ?>


                </div>

            </div>
        </div>
    </div>
</div>