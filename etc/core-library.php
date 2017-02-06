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
    echo json_encode( ['code'=>$code, 'message'=>$message] );
    exit;
}

function success( $data ) {
    echo json_encode( ['code'=>'', 'data'=>$data]);
    exit;
}