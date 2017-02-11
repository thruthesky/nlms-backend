<?php

use core\library as lib;


if ( lib::script() ) { // if "?mc=" requested?

    $path = lib::model_class_path();

    if ( class_exists( $path ) ) {      // if 'model/model-name/class.php' exists?
        $obj = new $path();                 // __constructor() runs.
        $method = lib::script_method();

        if ( $method ) { // if '?mc=model.class.method' request. METHOD to be called exists!
            if ( method_exists( $obj, $method ) ) {
                $obj->$method();
            }
            else error( ERROR_MODEL_CLASS_METHOD_NOT_EXIST );
        }
    }
    else { // model/model-name/class.php does not exists.

        // check if 'model/model-name/model-name-class.php' and 'method' exists?
        $path = lib::model_model_class_path();
        if ( class_exists( $path ) ) {
            $obj = new $path();
            $method = lib::script_class(); // 'class' to be 'method'
            if ( $method ) {
                if ( method_exists( $obj, $method ) ) {
                    $obj->$method();
                }
                else error( ERROR_MODEL_CLASS_METHOD_NOT_EXIST );

            }
        }
        else error( ERROR_MODEL_CLASS_NOT_FOUND );
    }

    // error( ERROR_NO_HANDLER ); // @deprecated since the success json does not stop the script.
}
else {
    error( ERROR_MODEL_CLASS_EMPTY );
}


