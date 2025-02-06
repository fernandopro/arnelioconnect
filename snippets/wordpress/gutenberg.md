

#### Encolar css y js en el editor de bloques
```php

add_action('enqueue_block_assets', array($this, 'encolar_css_editor_bloques'));
add_action('enqueue_block_editor_assets', array($this, 'encolar_js_editor_bloques'));

// alimentacion item 
function encolar_css_editor_bloques() {

// CSS
if ( is_rtl() ) {
    wp_enqueue_style( self::PAGE_SLUG.'_item', ARNELIOCONNECT_DIR_URL . 'dist/admin/css/'.self::PAGE_SLUG.'_item-rtl.css', array(), ARNELIOCONNECT_VERSION, 'all' );
} else {
    wp_enqueue_style( self::PAGE_SLUG.'_item', ARNELIOCONNECT_DIR_URL . 'dist/admin/css/'.self::PAGE_SLUG.'_item.css', array(), ARNELIOCONNECT_VERSION, 'all' );
}
}

function encolar_js_editor_bloques() {

wp_enqueue_script( self::PAGE_SLUG.'_item', ARNELIOCONNECT_DIR_URL . 'dist/admin/js/'.self::PAGE_SLUG.'_item.js', array('jquery'), ARNELIOCONNECT_VERSION, true );
wp_localize_script(self::PAGE_SLUG.'_item', self::PAGE_SLUG.'_item', array(
    'messages' => array(
    'text1' => __('Texto informativo 1', 'arnelioconnect'),
    'text2' => __('Texto informativo 2', 'arnelioconnect'),
    'text3' => __('Texto informativo 3', 'arnelioconnect')
)
));
}


```
