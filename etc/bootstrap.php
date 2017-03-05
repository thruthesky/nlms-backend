<?php

$system = []; // system variable used for holding system data.



if ($_SERVER['REQUEST_METHOD']=='OPTIONS') {
    header('Access-Control-Allow-Origin : *');
    header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers : X-Requested-With, content-type');
    exit;
}


header('Access-Control-Allow-Origin: *');	/** For ajax json calling from outside */
header('P3P: CP="NOI ADM DEV COM NAV OUR STP"'); /** cookie share on iframe */



require __DIR__ . '/helpers.php';
require __DIR__ . '/defines.php';
require __DIR__ . '/config.php';



require __ROOT_DIR__ . "/core/database/database.php";


debug_log(">>>>>>>> Backend begins : " . date('r') );


/**
 *
 *
 *
 * @warning If the class does not exists, it just don't do anything. Do not even return a value.
 * @attention So, you need to check if the class exists or not before you use a class.
 *
 *
 */
spl_autoload_register( function( $what ) {

    $what = str_replace('\\', '/', $what);
    $path = "$what.php";
    $path = strtolower( $path );
    if ( file_exists( $path ) ) {
        require_once $path;
    }

});



/**
 *
 * Returns User object
 *
 * @return \model\user\User
 *
 */
function user() {
    return new \model\user\User();
}

/**
 * Returns user table record currently logged in user.
 */
$_currentUser;
function currentUser() {
    global $_currentUser;
    if ( isset( $_currentUser ) || empty( $_currentUser ) ) $_currentUser = user()->load_by_session_id( in('session_id') );
    $user = user();
    $user->reset( $_currentUser );
    return $user;
}
/**
 *
 *
 * @return \model\meta\Meta
 *
 */
function meta() {
    return new \model\meta\Meta();
}

function forum_config() {
    return new \model\forum\Config();
}

function forum_data() {
    return new \model\forum\Data();
}
