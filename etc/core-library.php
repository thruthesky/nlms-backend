<?php
/**
 *
 * @note this file holds only methods that are directly related to New LMS.
 */

function mcm() {
    if ( in('mc') ) {
        return explode('.', in('mc') );
    }
    else if ( in('mcm') ) {
        return explode( '.', in('mcm') );
    }
    else return null;
}
function script() {
    $mcm = mcm();
    if ( $mcm ) return "model/$mcm[0]/$mcm[1].php";
    else return null;
}


/**
 * Returns class name.
 * @return null|string
 */
function script_class() {
    if ( $mcm = mcm() ) {
        return $mcm[1];
    }
    return null;
}


function script_method() {
    if ( $mcm = mcm() ) {
        if ( isset($mcm[2]) && $mcm[2] ) return $mcm[2];
        else return null;
    }
    return null;
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