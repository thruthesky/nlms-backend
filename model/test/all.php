<?php
/**
 * @see README.md
 */

namespace model\test;



function test( $re, $code ) {
    if ( $re['code'] ) echo "<div style='color:darkred;'>ERROR : ( $re[code] ) - $re[message]</div>";
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

        $session_id = $this->createUser();
        $session_id = $this->updateUser($session_id, ['name' => 'Updated Name']);
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

    private function updateUser( $session_id, $data ) {

        $data['session_id'] = $session_id;
        $re = $this->ex( "\\model\\user\\Update", $data );
        test( $re, "user update: session_id:$session_id");
        di($data);

    }

    /**
     * It runs and returns RESULT ( JSON Decoded Array Value )
     * @param $class
     * @param array $params
     * @return array|mixed
     */
    private function ex( $class, $params = [] ) {

        $_REQUEST = $params;



        new $class();

        $re = json_result();
        $json = json_decode( $re, true );


        if ( json_last_error() ) {
            di( $re );
            return ['code' => 1, 'message' => "JSON ERROR: " . json_last_error_msg() ];
        }
        return $json;
    }

}
