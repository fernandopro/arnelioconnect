<div class="layo-3box-arnelio mb-4">
    <div class="row gy-4">
        <div class="col-md-4 layo-arnelio_section">
            <div style="width:100%" class="card text-bg-default border rounded h-100">

                <div class="card-header layo-arnelio_section__header px-4 py-3 d-flex align-items-center justify-content-between w-100">
                    <h3><span class="placeholder bg-secondary col-6"></span></h3>
                </div>
                 <div class="card-body layo-arnelio_section__body px-4 py-3">


                 <?php
                        // Custom CSS
                    $arg = [
                        'title'      => __('Custom CSS', 'arnelioconnect'),
                        'name_option' => $name_option,
                        'name'       => 'custom_css_ali'.'_textarea',
                        'initial'    => $initial,
                        'values'     => $values,
                        'docu'       => null,
                        'info'       => __('This is the description of the user information field.','arnelioconnect'),
                        'css'        => ' mb-3',
                        'blo'        => null
                    ];
                    scfs_arnelioconnect_custom_css_field( $arg )
                    ?>



                </div>

            </div>
        </div>
        <div class="col-md-4 layo-arnelio_section">
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
        <div class="col-md-4 layo-arnelio_section">
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