<?php
// =============================================================
//       			  Plugin Controller - FUNCIONES
// =============================================================

function arnelioconnect_url_and_screen($urlPostype,$urlPage) {

    $urlValues = ['scfs_arnelioconnect','alimentacion'];


    // UTILIZAR EN EL CODIGO DE MI PLUGIN
    // if (defined('IS_URL_ARNELIOCONNECT') && IS_URL_ARNELIOCONNECT) {
    // }

    // Verificar coincidencia exacta o parcial en $urlPostype
    if ($urlPostype) {
        foreach ($urlValues as $value) {
            if (strpos($urlPostype, $value) !== false) {
                if (!defined('IS_URL_ARNELIOCONNECT')) {
                    define('IS_URL_ARNELIOCONNECT', true);
                }
                break;
            }
        }
    }

    // Verificar coincidencia exacta o parcial en $urlPage
    if ($urlPage) {
        foreach ($urlValues as $value) {
            if (strpos($urlPage, $value) !== false) {
                if (!defined('IS_URL_ARNELIOCONNECT')) {
                    define('IS_URL_ARNELIOCONNECT', true);
                }
                break;
            }
        }
    }


}

// Ejecutar la función
arnelioconnect_url_and_screen($urlPostype,$urlPage);
