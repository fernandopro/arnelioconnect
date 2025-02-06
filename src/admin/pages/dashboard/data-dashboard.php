<?php
// Configuración de las pestañas
$tabs = [
    [
        'id'    => 'dashboard',
        'title' => __('Dashboard', 'arnelioconnect'),
        'items' => [
            'dashboard' => [
                'name'       => __('Dashboard', 'arnelioconnect'),
                'url'        => 'src/admin/pages/dashboard/register/dashboard.php',
                'fixed'      => true,
                'header'     => false
            ]
        ]
    ]
];

// Opciones por defecto
$default_options = [
    'tab' => 'dashboard',
    'custom_css_textarea' => ''
];

// Opciones iniciales
$initial_options = [];


// Configuraciones adicionales
$auto_save_click = [];

$auto_save_change = [];

$field_buttons = [];

$field_buttons_multi = [];

$dateTransientAdmin = [];

$compareTimeField = [];




// Date transient admin
$Scfs_arnelioconnect_date_transient_admin_class = new Scfs_arnelioconnect_date_transient_admin_class($dateTransientAdmin, self::NAME_OPTION);

// Compare time field
$Scfs_arnelioconnect_compare_time_field_class = new Scfs_arnelioconnect_compare_time_field_class($compareTimeField, self::NAME_OPTION);

// Color picker
$Scfs_arnelioconnect_color_picker_class = new Scfs_arnelioconnect_color_picker_class($this->urlPostype, $this->urlPage, $this->urlTaxonomy, ARNELIOCONNECT_MENU_URL);

