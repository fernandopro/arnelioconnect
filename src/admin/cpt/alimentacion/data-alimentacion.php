<?php
$tabs = [
    [
        'id'    => 'congelados',
        'title' => __('Congelados', 'arnelioconnect'),
        'items' => [
            'merluza' => [
                'name'  => __('Merluza', 'arnelioconnect'),
                'url'   => 'src/admin/cpt/alimentacion/register/congelados-merluza.php',
                'fixed' => true,
                'header' => true
            ],
            'croquetas' => [
                'name'  => __('Croquetas', 'arnelioconnect'),
                'url'   => 'src/admin/cpt/alimentacion/register/congelados-croquetas.php',
                'fixed' => true
            ],
            'pizza' => [
                'name'  => __('Pizza', 'arnelioconnect'),
                'url'   => 'src/admin/cpt/alimentacion/register/congelados-pizza.php',
                'fixed' => false
            ],
        ]
    ],
    [
        'id'    => 'carnes',
        'title' => __('Carnes', 'arnelioconnect'),
        'items' => [
            'ternera' => [
                'name'  => __('Ternera', 'arnelioconnect'),
                'url'   => 'src/admin/cpt/alimentacion/register/carnes-ternera.php',
                'fixed' => false
            ],
            'cerdo' => [
                'name'  => __('Cerdo', 'arnelioconnect'),
                'url'   => 'src/admin/cpt/alimentacion/register/carnes-cerdo.php',
                'fixed' => false
            ],
            'pollo' => [
                'name'  => __('Pollo', 'arnelioconnect'),
                'url'   => 'src/admin/cpt/alimentacion/register/carnes-pollo.php',
                'fixed' => false
            ],
        ]
    ]
];


// Opciones por defecto
$default_options = [
    'tab'          => 'congelados',
    'nombre'             => '',
    'merluza_tipo' => 'al_horno',
    'merluza_size' => 'mediana',
    'tiempo'         => [
        'start'      => '',
        'end'        => '',
        'start_date' => '',
        'start_time' => '',
        'end_date'   => '',
        'end_time'   => '',
    ],
    'espacio'         => [
        'start'      => '',
        'end'        => '',
        'start_date' => '',
        'start_time' => '',
        'end_date'   => '',
        'end_time'   => '',
    ],
    'tiempo2'         => [
        'start'      => '',
        'end'        => '',
        'start_date' => '',
        'start_time' => '',
        'end_date'   => '',
        'end_time'   => '',
    ],
    'espacio2'         => [
        'start'      => '',
        'end'        => '',
        'start_date' => '',
        'start_time' => '',
        'end_date'   => '',
        'end_time'   => '',
    ],
    'active_time'   => 0,
    'custom_css_ali_textarea' => ''
];

// Opciones iniciales
$initial_options = [
    'merluza_tipo'  => [
        'al_pilpil'   => 'Al pilpil',
        'a_la_marina' => 'A la marinera',
        'al_horno'    => 'Al horno'
    ],
    'merluza_size'  => [
        'pequena' => 'Pequeña',
        'mediana' => 'Mediana',
        'grande'  => 'Grande'
    ]
];



// Configuraciones adicionales
$auto_save_click = [];

$auto_save_change = [];

$field_buttons = [
    'merluza_tipo'
];

$field_buttons_multi = [];

$compareTimeField = [
    'tiempo',
    'tiempo2',
    'espacio',
    'espacio2',
];




// Compare time field
$Scfs_arnelioconnect_compare_time_field_class = new Scfs_arnelioconnect_compare_time_field_class($compareTimeField, self::NAME_OPTION);

// Color picker
$Scfs_arnelioconnect_color_picker_class = new Scfs_arnelioconnect_color_picker_class($this->urlPostype, $this->urlPage, $this->urlTaxonomy, self::NAME_PAGE);

