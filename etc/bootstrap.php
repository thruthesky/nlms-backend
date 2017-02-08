<?php



require __DIR__ . '/defines.php';
require __DIR__ . '/config.php';
require __DIR__ . '/database.php';
require __DIR__ . '/helpers.php';


spl_autoload_register( function( $what ) {

    $what = str_replace('\\', '/', $what);
    $path = "$what.php";
    if ( file_exists( $path ) ) require_once $path;
    else error(ERROR_WRONG_MODEL_CLASS);

});

