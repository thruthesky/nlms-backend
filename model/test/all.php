<?php
/**
 * @see README.md
 */

namespace model\test;



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


function ok( $re ) {
    return $re['code'] == 0;
}


class All extends \model\base\Base {
    public function __construct()
    {

        parent::__construct();
        $this->style();


        $this->testInstallation();
        $this->testDatabase();
        $this->testBase();
        $this->testMeta();
        $this->testUser();

        exit;

    }

    private function style() {
        echo <<<EOH
<style>
    body { font-size: 8pt; }
    .error { color: darkred; font-weight: bold; }
    .success { color: #555; }
</style>
EOH;

    }


    private function testInstallation() {
        if ( ! db()->tableExists('user') ) {
            echo "
<h1>Backend is not installed.</h1>
To install access to ?mc=system.install
";
            exit;
        }
    }

    private function testDatabase() {



        db()->createTable( 'abc' );

        test( db()->tableExists('abc'), "abc table exists");
        test( db()->columnExists('abc', 'idx'), "abc.idx exists");

        db()->dropTable( 'abc' );
        test( ! db()->tableExists('abc'), "abc table does not exist");



        //
        db()->update('meta', ['a'=>'b'], '; should be error');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for ;");



        db()->update('meta', ['a'=>'b'], 'select should be error');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for select");


        db()->update('meta', ['a'=>'b'], 'Condition cannot have replace ');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for replace");


        db()->update('meta', ['a'=>'b'], ' update should be error');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for update");


        db()->update('meta', ['a'=>'b'], ' delete should be error');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for delete");


        // db()->query("select from where");

    }

    private function testBase() {


        //$this->setTable('meta');

        $this->setTable('meta');
        test( $this->getTable() == 'meta', 'base::setTable()');
        $idx = $this->insert(['model'=>'testBase', 'model_idx'=>1, 'code'=>'testCode', 'data'=>'testData']);
        test( $idx > 0, "base::create() - meta data create: idx=$idx");
        if ( $idx < 0 ) di($GLOBALS['em'][$idx]);


        $cond = " model='testBase' AND model_idx=1 AND code='testCode' ";
        $count = $this->count( $cond );
        test( $count > 0, "base::count() - $count");
        test( $this->countAll() >= $count, "base::countAll()");


        $meta = $this->load( $idx );
        test ( $meta, "Loading a meta. idx: $idx");
        test ( $meta['data'] == 'testData', "meta data check" );

        $this->update( ['data' => 'new data'] );
        $updated = $this->reload();

        test( $meta['idx'] == $updated['idx'], "meta updated" );
        test( $updated['data'] == 'new data', "data updated" );

        $this->destroy();

        $record = $this->load( $meta['idx'] );

        test( empty($record), "meta data destroyed");


    }


    private function testMeta() {
        $idx = meta()->set('abc', 123, 'code-unit-test', 'data');
        test( $idx, "Meta::set() code: code, data: data re: idx: $idx");

        //
        $another_idx = meta()->set('abc', 111, 'code-unit-test', 'another idx');
        test( $another_idx, "meta::set() another idx is okay");

        $new_idx = meta()->set('abc', 123, 'code-unit-test', 'new data');
        test( $new_idx, "Meta::set() code: code, data: new data re: new_idx: $new_idx");

        test( $idx != $new_idx, "Meta::set() new insert. data=new data idx: $idx, new_idx: $new_idx");


        $count = meta()->getCount( 'abc', 123, 'code-unit-test' );
        test( $count == 1, "Meta abc, 123, code-unit-test has only 1 record as it should.");


        meta()->delete( 'abc', 111, 'code-unit-test' );
        $count = meta()->getCount( 'abc', 111, 'code-unit-test');
        test( $count == 0, "Meta abc, 111, code-unit-test has deleted.");


    }

    private function testUser() {
        $id = 'user-' . time();
        $name = 'new user';
        $data = [
            'id'=>$id,
            'name'=>$name,
            'meta' => [
                'age' => 22,
                'classid' => 'my-id'
            ]
        ];
        $session_id = $this->createUser( $data );
        if ( $session_id ) { // create success.
            $session_id = $this->updateUser($session_id, ['name' => 'Updated Name']);

            if ( $session_id ) { // update success.
                $user = $this->getUserData( $session_id );
                test( $user['id'] == $id, "User create() update() ID compare. id should be '$id'");
                test( $user['name'] == 'Updated Name', "name compare. session_id: $session_id");


                // meta test
                test( $user['meta']['age'] == "22", "meta test");



                // user login
                $new_session_id = $this->userLogin( $id, $id );
                test( $session_id != $new_session_id, "User login. session id changed. $session_id != $new_session_id");

                // see if new session id is ok.
                $user = user()->load( $user['idx'] );
                test( $new_session_id == $user['session_id'], "session_id match");



                // user logged.
                $this->userLogout( $new_session_id );

                // see if session id is empty.
                $user = user()->load( $user['idx'] );
                test( empty($user['session_id']), "session is empty since user logged out.");


            }

        }
        else {
            // failed on create a user.
        }

    }

    private function createUser( $params ) {


        $params['password'] = $params['id'];

        $re = $this->ex( "\\model\\user\\Create", $params );

        test($re, "registration: $params[id]");

        if ( ok($re) ) return $re['data']['session_id'];
        else return null;

    }

    private function updateUser( $session_id, $data ) {

        $data['session_id'] = $session_id;
        $re = $this->ex( "\\model\\user\\Update", $data );
        test( $re, "user update: session_id:$session_id");

        if ( ok($re) ) return $re['data']['session_id'];
        else return null;

    }


    private function userLogin( $id, $password ) {
        $params = [
            'id' => $id,
            'password' => $password
        ];
        $re = $this->ex( "\\model\\user\\Login", $params);
        test( $re, "User logged: ");
        if ( ok($re) ) return $re['data']['session_id'];
        else return null;
    }





    private function userLogout( $session_id ) {
        $params = [
            'session_id' => $session_id
        ];
        $re = $this->ex( "\\model\\user\\Logout", $params);
        test( $re, "User logout ");
    }




    private function getUserData( $session_id ) {
        $params = [ 'session_id' => $session_id ];

        $re = $this->ex("\\model\\user\\user::data", $params);
        //di($re);
        test( $re, "user::data() - session_id: $session_id" );
        if ( ok($re) ) return $re['data'];
        else return null;
    }

    /**
     * It runs and returns RESULT ( JSON Decoded Array Value )
     * @param $class_method
     * @param array $params
     * @return array|mixed
     */
    private function ex( $class_method, $params = [] ) {

        $arr = explode('::', $class_method);
        $class = $arr[0];
        $method = null;
        if ( isset($arr[1]) ) $method = $arr[1];

        $_REQUEST = $params;

        $obj = new $class();
        if ( $method && method_exists($obj, $method) ) $obj->$method();

        return $this->result();
    }

    private function result() {

        $re = json_result();
        $json = json_decode( $re, true );

        // if ( isset($json['code']) ) di( $re );

        if ( json_last_error() ) {
            di( $re );
            return ['code' => 1, 'message' => "JSON ERROR: " . json_last_error_msg() ];
        }
        return $json;


    }

}
