<?php





    function di($o) {
        $re = print_r($o, true);
        $re = str_replace(" ", "&nbsp;", $re);
        $re = explode("\n", $re);
        echo implode("<br>", $re);
    }




    function debug_log( $message ) {
        global $DEBUG_LOG_FILE_PATH;
        static $count_dog = 0;
        if ( ! $DEBUG_LOG_FILE_PATH ) return;

        $count_dog ++;

        if( is_array( $message ) || is_object( $message ) ){
            $message = print_r( $message, true );
        }
        else {

        }

        $message = "[$count_dog] $message\n";


        $fd = fopen( $DEBUG_LOG_FILE_PATH, 'a' );
        if ( $fd ) {
            fwrite( $fd, $message );
            fclose( $fd );
        }

    }




function in ( $code, $default = null ) {
    if ( isset( $_REQUEST[ $code ] ) ) {
        if ( $_REQUEST[ $code ] ) return $_REQUEST[ $code ];
        else return $default;
    }
    else return $default;
}


/**
 * @param $code
 * @param string $message
 *
 * @code
 *
 *      error('error-code');
 *      error('error-code', 'explanation message');
 *
 * @endcode
 */
function error( $code, $message='' ) {
    global $em;
    if ( empty($message) && isset($em[ $code ]) ) $message = $em[ $code ];
    echo json_encode( ['code'=>$code, 'message'=>$message] );
    exit;
}

function success( $data = null ) {
    if ( empty($data) || is_array( $data ) ) { }
    else error( ERROR_MALFORMED_RESPONSE );
    echo json_encode( ['code'=>0, 'data'=>$data]);
    exit;
}

/**
 * @param $error_code - It gets error code defined in defines.php
 */
function result( $error_code ) {
    if ( $error_code ) error( $error_code );
    else success();
}