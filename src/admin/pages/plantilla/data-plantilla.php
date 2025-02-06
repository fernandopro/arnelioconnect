<?php
// Configuración de las pestañas
$tabs = [
    [
        'id'    => 'futbol',
        'title' => __('Fútbol', 'arnelioconnect'),
        'items' => [
            'celta' => [
                'name'   => __('Celta', 'arnelioconnect'),
                'url'    => 'src/admin/pages/plantilla/register/futbol/celta.php',
                'fixed'  => false,
                'header' => true
            ],
            'madrid' => [
                'name'   => __('Real Madrid', 'arnelioconnect'),
                'url'    => 'src/admin/pages/plantilla/register/futbol/madrid.php',
                'fixed'  => false,
                'header' => true
            ],
            'barsa' => [
                'name'   => __('Barcelona', 'arnelioconnect'),
                'url'    => 'src/admin/pages/plantilla/register/futbol/barsa.php',
                'fixed'  => false,
                'header' => true
            ],
        ],
    ],
    [
        'id'    => 'peliculas',
        'title' => __('Películas', 'arnelioconnect'),
        'items' => [
            'accion' => [
                'name'   => __('Acción', 'arnelioconnect'),
                'url'    => 'src/admin/pages/plantilla/register/peliculas/accion.php',
                'fixed'  => true,
                'header' => true
            ],
            'comedia' => [
                'name'   => __('Comedia', 'arnelioconnect'),
                'url'    => 'src/admin/pages/plantilla/register/peliculas/comedia.php',
                'fixed'  => false,
                'header' => true
            ]
        ],
    ]
];

// Opciones por defecto
$default_options = [
    'tab'                          => 'futbol',
    'jugadores'                    => 'messi',
    'nombre'                       => '',
    'nombre_descripcion_wp_editor' => '',
    'descripcion'                  => 'hola mundo',
    'number'                       => '34',
    'entrenadores'                 => 'zidane',
    'modo_mantenimiento'           => 0,
    'spreads'                      => '5cards',
    'balon'                        => 0,
    'balon2'                       => 1,
    'balon3'                       => 0,
    'balon4'                       => 1,
    'title_color'                  => '#dd3333',
    'subtitle_color'               => '#8224e3',
    'range_color'                  => '#ff0000',
    'range_bg'                     => '#f0f0f0',
    'range_size'                   => '20',
    'range_size2'                  => '35',
    'range_width'                  => '50',
    'tenistas'                     => ['nadal', 'djokovic'],
    'pilotos_f1'                   => 'hamilton',
    'galicia'                      => 'coruña',
    'aragon'                       => ['zaragoza'],
    'castillaleon'                 => ['avila'],
    'arroz_con_leche'              => ['arroz', 'leche'],
    'helado'                       => 'leche',
    'flan'                         => ['huevos'],
    'nombre_postre'                => 'jujuju',
    'date_transient_admin_comidas' => [
        'check'      => 1,
        'start'      => '',
        'end'        => '',
        'start_date' => '',
        'start_time' => '',
        'end_date'   => '',
        'end_time'   => '',
    ],
    'date_transient_admin_deportes'         => [
        'check'      => 1,
        'start'      => '',
        'end'        => '',
        'start_date' => '',
        'start_time' => '',
        'end_date'   => '',
        'end_time'   => '',
    ],
    'reloj1'         => [
        'start'      => '',
        'end'        => '',
        'start_date' => '',
        'start_time' => '',
        'end_date'   => '',
        'end_time'   => '',
    ],
    'reloj2'         => [
        'start'      => '',
        'end'        => '',
        'start_date' => '',
        'start_time' => '',
        'end_date'   => '',
        'end_time'   => '',
    ],
    'name' => '',
    'descri_peli' => '',
    'descri_wp_editor' => '',
    'edad_max' => '18',
    'actores_accion' => 'stallone',
    'actrices_accion' => ['jolie'],
    'actores_comedia' => 'carrey',
    'superheroes' => 'batman',
    'multi_lang' => 0,
    'duration'   => [
        'start'      => '',
        'end'        => '',
        'start_date' => '',
        'start_time' => '',
        'end_date'   => '',
        'end_time'   => '',
    ],
    'custom_css_textarea' => '.fer{color: red;}',
];

// Opciones iniciales
$initial_options = [
    'jugadores'  => [
        'messi'   => 'Messi',
        'ronaldo' => 'Ronaldo',
        'neymar'  => 'Neymar',
        'mbappe'  => 'Mbappé',
        'haaland' => 'Haaland'
    ],
    'entrenadores'  => [
        'guardiola' => 'Guardiola',
        'ancelotti' => 'Ancelotti',
        'zidane'    => 'Zidane',
        'simeone'   => 'Simeone',
        'klopp'     => 'Klopp'
    ],
    'tenistas'  => [
        'nadal'    => 'Nadal',
        'djokovic' => 'Djokovic',
        'federer'  => 'Federer',
        'thiem'    => 'Thiem',
        'medvedev' => 'Medvedev'
    ],
    'pilotos_f1'  => [
        'hamilton'   => 'Hamilton',
        'verstappen' => 'Verstappen',
        'norris'     => 'Norris',
        'ricciardo'  => 'Ricciardo',
        'sainz'      => 'Sainz'
    ],
    'galicia'  => [
        'coruña'     => 'Coruña',
        'lugo'       => 'Lugo',
        'ourense'    => 'Ourense',
        'pontevedra' => 'Pontevedra'
    ],
    'aragon'  => [
        'zaragoza' => 'Zaragoza',
        'huesca'   => 'Huesca',
        'teruel'   => 'Teruel'
    ],
    'castillaleon'  => [
        'avila'      => 'Ávila',
        'burgos'     => 'Burgos',
        'leon'       => 'León',
        'palencia'   => 'Palencia',
        'salamanca'  => 'Salamanca',
        'segovia'    => 'Segovia',
        'soria'      => 'Soria',
        'valladolid' => 'Valladolid',
        'zamora'     => 'Zamora'
    ],
    'arroz_con_leche'  => [
        'arroz'  => 'Arroz',
        'leche'  => 'Leche',
        'canela' => 'Canela',
        'azucar' => 'Azúcar',
        'limon'  => 'Limón'
    ],
    'helado'  => [
        'leche'     => 'Leche',
        'nata'      => 'Nata',
        'azucar'    => 'Azúcar',
        'vainilla'  => 'Vainilla',
        'fresa'     => 'Fresa',
        'chocolate' => 'Chocolate'
    ],
    'flan'  => [
        'huevos'   => 'Huevos',
        'leche'    => 'Leche',
        'azucar'   => 'Azúcar',
        'vainilla' => 'Vainilla',
        'caramelo' => 'Caramelo'
    ],
    'spreads' => [
        '1cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/1cards.svg',
        '0cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/0cards.svg',
        '2cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/2cards.svg',
        '3cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/3cards.svg',
        '4cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/4cards.svg',
        '5cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/5cards.svg',
        '6cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/6cards.svg',
        '7cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/7cards.svg',
        '8cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/8cards.svg',
        '9cards'  => ARNELIOCONNECT_DIR_URL . 'img/spreads/9cards.svg',
        '10cards' => ARNELIOCONNECT_DIR_URL . 'img/spreads/10cards.svg'
    ],
    'edad_max' => [
        '18' => '18',
        '16' => '16',
        '13' => '13',
        '7'  => '7',
        '3'  => '3'
    ],
    'actores_accion' => [
        'stallone' => 'Stallone',
        'schwar' => 'Schwarzenegger',
        'willis'   => 'Willis',
        'van'      => 'Van Damme'
    ],
    'actrices_accion' => [
        'jolie' => 'Jolie',
        'johansson' => 'Johansson',
        'theron' => 'Theron',
        'rodriguez' => 'Rodriguez'
    ],
    'actores_comedia' => [
        'carrey' => 'Carrey',
        'sandler' => 'Sandler',
        'ferrell' => 'Ferrell',
        'black' => 'Black'
    ],
    'superheroes' => [
        'batman' => 'Batman',
        'superman' => 'Superman',
        'spiderman' => 'Spiderman',
    ]
];

// Configuraciones adicionales

// Se guarda automáticamente al hacer click. 
//Nombre de un field o valor de una pestaña.
$auto_save_click = [
    'jugadores',
    'galicia',
    'balon3',
    'spreads',
    'peliculas'
];

$auto_save_change = [
    'pilotos_f1',
];

$field_buttons = [
    'entrenadores',
    'helado',
    'actores_accion'
];

$field_buttons_multi = [
    'arroz_con_leche',
    'aragon',
    'castillaleon',
    'actrices_accion'
];


$dateTransientAdmin = [
    'date_transient_admin_comidas',
    'date_transient_admin_deportes'
];

$compareTimeField = [
    'reloj1',
    'reloj2',
    'duration'
];





// Date transient admin
$Scfs_arnelioconnect_date_transient_admin_class = new Scfs_arnelioconnect_date_transient_admin_class($dateTransientAdmin, self::NAME_OPTION);

// Compare time field
$Scfs_arnelioconnect_compare_time_field_class = new Scfs_arnelioconnect_compare_time_field_class($compareTimeField, self::NAME_OPTION);

// Color picker
$Scfs_arnelioconnect_color_picker_class = new Scfs_arnelioconnect_color_picker_class($this->urlPostype, $this->urlPage, $this->urlTaxonomy, self::NAME_PAGE);

