<?php
/**
 *
 * @file index.php
 * @note starter script
 *
 */
include_once 'etc/defines.php';
include_once 'etc/core-library.php';
include_once 'etc/helpers.php';
include_once 'etc/config.php';
include_once 'etc/database.php';
include_once 'model/base/base.php';

include_once 'model/user/user.php';


if ( script() ) {
    include script();
    $class = script_class();
    $obj = new $class();
    $method = script_method();
    if ( $method ) $obj->$method();
    error('script-handler-not-found');
}
else {
    error('script-not-found');
}