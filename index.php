<?php
/**
 *
 * @file index.php
 * @note starter script
 *
 */

include_once 'etc/bootstrap.php';

use core\library as lib;


if ( lib::script() ) {
    $path = lib::model_class_path();
    $obj = new $path();
    $method = lib::script_method();
    if ( $method ) $obj->$method();


    // error( ERROR_NO_HANDLER ); // @deprecated since the success json does not stop the script.
}
else {
    error( ERROR_MODEL_CLASS_EMPTY );
}
