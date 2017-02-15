<?php





    function di($o) {
        $re = print_r($o, true);
        $re = str_replace(" ", "&nbsp;", $re);
        $re = explode("\n", $re);
        echo implode("<br>", $re);
    }




    function debug_log( $message ) {
        global $DEBUG, $DEBUG_LOG_FILE_PATH;
        static $count_dog = 0;

        if ( ! $DEBUG ) return;
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

    function debug_database_log( $message ) {
        global $DEBUG, $DEBUG_LOG_DATABASE;
        if ( ! $DEBUG ) return;
        if ( ! $DEBUG_LOG_DATABASE ) return;
        debug_log( $message );
    }

function debug_print( $obj ) {
    global $DEBUG;
    if ( ! $DEBUG ) return;

    echo "<pre style='padding: 1em; background-color: lightgrey;'>
            <div style='font-size: 1.4em;'>DEBUG MESSAGE</div>
";
    print_r($obj);
    echo "</pre>";
}


function in ( $code, $default = null ) {
    if ( isset( $_REQUEST[ $code ] ) ) {
        if ( $_REQUEST[ $code ] ) return $_REQUEST[ $code ];
        else return $default;
    }
    else return $default;
}


/**
 *
 * Saves JSON error info $system['error'];
 *
 * @attention this method does not stop the script. This is for mainly debug/unit test purpose.
 *
 * @param $code
 * @param string $message
 *
 * @code
 *
 *      error('error-code');
 *      error('error-code', 'explanation message');
 *
 * @endcode
 * @return mixed - error code.
 *
 */
function error( $code, $message='' ) {
    global $em, $system;
    if ( empty($message) && isset($em[ $code ]) ) $message = $em[ $code ];
    $system['error'][] = ['code'=>$code, 'message'=>$message];
    debug_log("ERROR >> $code : $message");
    return $code;
}

function error_string( $re ) {
    if ( $re['code'] ) return "ERROR( $re[code] ) - $re[message]";
    else return null;
}

/**
 * @attention when success json data printed out, it does not stop the script. Meaning the script will continue.
 * @param null $data
 */
function success( $data = null ) {
    global $system;
    if ( empty($data) || is_array( $data ) ) { }
    else error( ERROR_MALFORMED_RESPONSE );
    $system['success'] = ['code'=>OK, 'data'=>$data];
}

/**
 * @param $error_code - It gets error code defined in defines.php
 */
function result( $error_code ) {
    if ( $error_code ) error( $error_code );
    else success();
}


/**
 * Returns JSON encoded string.
 *
 * @attention Call this method to get result After a run of 'model\class' or 'model::class->method()'
 *
 * If there is any error
 *      - [code=>'last error code', message=>'last error code', all=>'all error code in array'] will be return.
 */
function json_result() {
    global $system;
    if ( ! isset($system['error']) && ! isset($system['success'] ) ) {
        error( ERROR_NO_RESPONSE );
    }

    if ( isset( $system['error'] ) ) {
        $last = array_shift( $system['error'] );
        $last['all'] = $system['error'];
        $re = $last;
    }
    else {
        $re = $system['success'];
    }

    unset( $system['error'], $system['success'] );
    return json_encode( $re );
}