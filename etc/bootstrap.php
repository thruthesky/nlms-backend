<?php


if ($_SERVER['REQUEST_METHOD']=='OPTIONS') {
    header('Access-Control-Allow-Origin : *');
    header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers : X-Requested-With, content-type');
    exit;
}


header('Access-Control-Allow-Origin: *');	/** For ajax json calling from outside */
header('P3P: CP="NOI ADM DEV COM NAV OUR STP"'); /** cookie share on iframe */



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

