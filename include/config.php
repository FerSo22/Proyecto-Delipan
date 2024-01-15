<?php
    /*
    // DESHABILITAR CACHÉ
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    */
    // EXPRESIONES REGULARES
    define("INVALID_CHARS", "/[<>=]/");
    define("KEYWORDS", "/\b(AND|OR)\b/i");
    define("VALID_NUMBERS", "/^[0-9]+$/");

    // CARPETA RAÍZ
    define("ROOT_PATH", "/Proyecto_ADS/");

    // ASSETS Y SUBCARPETAS
    define("ASSETS_PATH", ROOT_PATH . "assets/");
    define("CSS_PATH", ASSETS_PATH . "css/");
    define("ICON_PATH", ASSETS_PATH . "icons/");
    define("IMG_PATH", ASSETS_PATH . "img/");
    define("JS_PATH", ASSETS_PATH . "js/");

    // ENTITIES
    define("ENTITIES_PATH", ROOT_PATH . "entities/");

    // MÓDULO VENTAS
    define("SALES_MODULE_PATH", ROOT_PATH . "salesModule/");

    // MÓDULO SEGURIDAD
    define("SECURITY_MODULE_PATH", ROOT_PATH . "securityModule/");

    // MÓDULO USUARIO
    define("USER_MODULE_PATH", ROOT_PATH . "userModule/");

    // INCLUDES
    define("INCLUDE_PATH", ROOT_PATH . "include/");

    // AJAX
    define("AJAX_PATH", ROOT_PATH . "scriptsAjax/");

    // JQUERY
    define("JQUERY_FILE", JS_PATH . "jquery-3.7.1.min.js");
?>