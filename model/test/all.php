<?php
/**
 * @see README.md
 */

namespace model\test;



function test( $re, $code ) {
    if ( $re['code'] ) echo "<div>ERROR on $code : $re[message]</div>";
    else echo "<div>SUCCESS on $code</div>";
}
function ok( $re ) {
    return $re['code'] == 0;
}


class All extends \model\base\Base {
    public function __construct()
    {

        parent::__construct();

        $this->testUser();

        exit;

    }



    private function testUser() {

        $this->createUser();
    }

    private function createUser() {


        $id = 'user-' . time();
        $params = [
            'id' => $id,
            'password' => $id
        ];

        $re = $this->ex( "\\model\\user\\Create", $params );

        test($re, "registration: $id");

        if ( ok($re) ) return $re['data']['session_id'];
        else return null;

    }

    private function ex( $class, $params = [] ) {

        $_REQUEST = $params;

        ob_start();
        new $class();
        $re = ob_get_clean();

        $json = json_decode( $re, true );
        if ( json_last_error() ) {
            di( $re );
            return ['code' => 1, 'message' => "JSON ERROR: " . json_last_error_msg() ];
        }
        return $json;
    }

}
