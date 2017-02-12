<?php
/**
 * @see README.md
 */


namespace model\system;
class Install extends \model\base\Base {
    public function __construct()
    {

        parent::__construct();



        $installs = rsearch( __MODEL_DIR__, '/^.*\/install\.php$/' );
        foreach ( $installs as $install ) {
            if ( strpos( $install, 'system' ) ) continue;

            include $install;
        }


        success( [ "access '?mc=test.all' for test" ] );


    }
}

function rsearch($folder, $pattern) {
    $dir = new \RecursiveDirectoryIterator($folder);
    $ite = new \RecursiveIteratorIterator($dir);
    $files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
    $fileList = array();
    foreach($files as $file) {
        $fileList = array_merge($fileList, $file);
    }
    return $fileList;
}