<?php
namespace model\test;
class Test {



    /**
     * It runs and returns RESULT ( JSON Decoded Array Value )
     * @param $class_method
     * @param array $params
     * @return array|mixed
     */
    public function ex( $class_method, $params = [] ) {

        $arr = explode('::', $class_method);
        $class = $arr[0];
        $method = null;
        if ( isset($arr[1]) ) $method = $arr[1];

        $_REQUEST = $params;

        $obj = new $class();
        if ( $method && method_exists($obj, $method) ) $obj->$method();

        return $this->result();
    }

    /**
     * this returns random string.
     * @param int $length
     * @return string
     */

    function randomString($length = 1) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z') );
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }


    public function result() {

        $re = json_result();
        $json = json_decode( $re, true );

        // if ( isset($json['code']) ) di( $re );

        if ( json_last_error() ) {
            di( $re );
            return ['code' => 1, 'message' => "JSON ERROR: " . json_last_error_msg() ];
        }
        return $json;


    }



    public function createUser( $params ) {


        $params['password'] = $params['id'];

        $re = $this->ex( "\\model\\user\\Create", $params );

        // test($re, "registration: $params[id]");

        if ( is_success($re) ) return $re['data']['session_id'];
        else return null;

    }





    public function getUserData( $session_id ) {
        $params = [ 'session_id' => $session_id ];

        $re = $this->ex("\\model\\user\\user::data", $params);
        //di($re);
        test( $re, "user::data() - session_id: $session_id" );
        if ( is_success($re) ) return $re['data']['user'];
        else return null;
    }






}