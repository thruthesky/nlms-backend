<?php
/**
 *
 * Configuration File
 *
 * @warning do not put any data here that changes laster. ( Do not put dynamic variable here )
 * This file meant to hold static variables only.
 *
 */


$DATABASE_USER          = 'root';
$DATABASE_PASSWORD      = '';
$DATABASE_NAME          = 'nlms';
$DATABASE_HOST          = 'localhost';
$DATABASE_TYPE          = 'mysqli';


/**
 * If 'DEBUG_LOG_FILE_PATH' is false, then debug data will not be saved.
 */
$DEBUG_LOG_FILE_PATH = "/data/debug.log";

if ( file_exists("my-config.php") ) require "my-config.php";



