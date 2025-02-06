# function scfs_arnelioconnect_layout_fields()
```php
function scfs_arnelioconnect_layout_fields( $tabs, $values = null, $initial = null, $default_options = null, $viewMenu = null, $beforeMenu = null, $name_option = null, $post_id = null )
```
#### $tabs
Es donde se insertarán los datos para formar las tabs del menú y los acordeones.

```php
$tabs = [
    [
        'id'          => '',
        'title'       => __('', 'arnelioconnect'),
        'pro'         => true,
        'items'       => [
             '' => [
                'name'       => __('', 'arnelioconnect'),
                'url'        => '',
                'fixed'      => false, // por defecto es false, si cambiamos a true el contenedor del acordeon se transforma en un box y no se puede cerrar. 
                'header'     => true, // por defecto es true, si cambiamos a false se oculta el titulo del header
                'pro'        => false
            ],
        ],
    ],
];
```

---



#### $values
Es el array que trae los valores guardados en la base de datos get_option().


---


#### $initial
Es el array con los valores iniciales para construir los campos tipo checbox o radio mediante un foreach.


---


#### $viewMenu
Añade el valor <code>false</code> para ocultar el menú de las pestañas.


---


#### $beforeMenu
Es la url o ruta absoluta hacia el archivo donde están los valores que queremos antes del menu. si no se usa utiliza <code>null</code>


---


#### $name_option
Es el nombre del array que se guarda en la base de datos.


---


#### $post_id
Es el id de los post de wordpress. si es para una página usa <code>null</code>


---


### Ejemplo $tabs
Se crean varias tabs [] y dentro de cada tab, los items son los acordeones.

Se pueden crear acordeones fijos con el valor <code>fixed = true</code>. Esto emulará a un box que no se cierra y elimina el icon de cierre.

```php
$tabs = [
    [
        'id' => 'bebidas',
        'title' => __('Bebidas', 'arnelioconnect'),
        'items' => [
            'cocacola' => [
                'name' => __('Cocacola', 'arnelioconnect'),
                'url' => 'src/admin/pages/plantilla/bebidas-cocacola.php',
                'fixed' => false
            ],
            'pepsi' => [
                'name' => __('Pepsi', 'arnelioconnect'),
                'url' => 'src/admin/pages/plantilla/bebidas-pepsi.php',
                'fixed' => true
            ],
            'sprite' => [
                'name' => __('Sprite', 'arnelioconnect'),
                'url' => 'src/admin/pages/plantilla/bebidas-sprite.php',
                'fixed' => false
            ],
        ],
    ],
    [
        'id' => 'frutas',
        'title' => __('Frutas', 'arnelioconnect'),
        'items' => [
            'platano' => [
                'name' => __('Platano', 'arnelioconnect'),
                'url' => 'src/admin/pages/plantilla/frutas-platano.php',
                'fixed' => false,
                'pro' => false,
                'header' => true
            ],
            'naranja' => [
                'name' => __('Naranja', 'arnelioconnect'),
                'url' => 'src/admin/pages/plantilla/frutas-naranja.php',
                'fixed' => true
            ],
            'manzana' => [
                'name' => __('Manzana', 'arnelioconnect'),
                'url' => 'src/admin/pages/plantilla/frutas-manzana.php',
                'fixed' => false
            ],
        ],
    ],
    [
        'id' => 'postres',
        'title' => __('Postres', 'arnelioconnect'),
        'pro' => true
        'items' => [
            'arroz_con_leche' => [
                'name' => __('Arroz con leche', 'arnelioconnect'),
                'url' => 'src/admin/pages/plantilla/postres-arroz-con-leche.php',
                'fixed' => false
            ],
            'helado' => [
                'name' => __('Helado', 'arnelioconnect'),
                'url' => 'src/admin/pages/plantilla/postres-helado.php',
                'fixed' => false
            ],
            'flan' => [
                'name' => __('Flan', 'arnelioconnect'),
                'url' => 'src/admin/pages/plantilla/postres-flan.php',
                'fixed' => false
            ],
        ]
    ]
];
```

