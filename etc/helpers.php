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
    if ( is_error( $re ) ) {
        return "ERROR( $re[code] ) - <b>$re[message]</b>";
    }
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
 * @param $re - It gets error code defined in defines.php
 */
function result( $re ) {
    if ( isset($re['code'] ) && $re['code'] ) error( $re );
    else success( $re );
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


/**
 * Returns page no.
 *
 * @param $n
 * @return int
 */
function page_no( $n ) {
    if ( ! is_numeric( $n ) ) return 1;
    else if ( $n < 1 ) return 1;
    else return $n;
}

function page_item_limit( $n ) {
    global $DEFAULT_NO_OF_PAGE_ITEMS;
    if ( ! is_numeric( $n ) ) return $DEFAULT_NO_OF_PAGE_ITEMS;
    else if ( $n < 1 ) return $DEFAULT_NO_OF_PAGE_ITEMS;
    else return $n;
}


/**
 *
 * Search files based on $pattern and Return it.
 *
 * @param $folder
 * @param $pattern
 * @return array
 */
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




function test( $re, $code ) {
    static $count = 0;
    $count ++;
    if ( is_array($re) ) {
        if ( isset($re['code']) && ! isset($re['idx']) ) { // server data.
            if ( $re['code'] ) echo "<div class='error'>$count - ERROR : ( $re[code] ) - $re[message]</div>";
            else echo "<div class='success'>$count - SUCCESS: $code</div>";
        }
        else { // unknown data.
            if ( $re ) echo "<div class='success'>$count - SUCCESS: $code</div>";
            else echo "<div class='error'>$count - ERROR : $code</div>";
        }
    }
    else { //
        if ( $re ) echo "<div class='success'>$count - SUCCESS: $code</div>";
        else echo "<div class='error'>$count - ERROR : $code</div>";
    }
}



function is_success( $re ) {
    if ( is_array( $re ) ) {
        if ( array_key_exists( 'code', $re ) ) {
            if ( $re['code'] ) return false;
        }
    }
    return true;
}
function is_error( $re ) {
    return ! is_success( $re );
}
