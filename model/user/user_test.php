<?php
namespace model\user;
use model\test\Test;

class User_Test extends Test {

    public function run() {
        $this->testUser();
        $this->testUserSearch();
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


    private function updateUser( $session_id, $data ) {

        $data['session_id'] = $session_id;
        $re = $this->ex( "\\model\\user\\Update", $data );
        test( $re, "user update: session_id:$session_id");

        if ( is_success($re) ) return $re['data']['session_id'];
        else return null;

    }


    private function userLogin( $id, $password ) {
        $params = [
            'id' => $id,
            'password' => $password
        ];
        $re = $this->ex( "\\model\\user\\Login", $params);
        test( $re, "User logged: ");
        if ( is_success($re) ) return $re['data']['session_id'];
        else return null;
    }





    private function userLogout( $session_id ) {
        $params = [
            'session_id' => $session_id
        ];
        $re = $this->ex( "\\model\\user\\Logout", $params);
        test( $re, "User logout ");
    }




    private function testUserSearch()
    {

        // create 10 users.
        $id = null;
        $user_session_id = null;
        for( $i = 0; $i < 10; $i ++ ) {
            $id = "user-$i-" . time();
            $data = [
                'id'=>$id,
                'name'=> "name-$id",
                'meta' => [
                    'age' => $i,
                    'classid' => "classid-$i"
                ]
            ];
            $user_session_id = $this->createUser( $data );
        }


        // search permission error.
        $params = [
            'limit' => 3,
            'session_id' => $user_session_id
        ];
        $re = $this->ex( "\\model\\user\\user::search", $params );
        test( $re['code'] == ERROR_PERMISSION_ADMIN, "User search: " . error_string($re) );


        // search permission ok.
        $admin_session_id = user()->forceLogin('admin');
        test( is_success($admin_session_id), "force log in to admin: $admin_session_id, " . error_string($admin_session_id));


        $params = [
            'limit' => 3,
            'session_id' => $admin_session_id
        ];


        $re = $this->ex( "\\model\\user\\user::search", $params );
        test( is_success($re), "User search: " . error_string($re) );



        if ( $re['code'] ) {

        }
        else {

            $no = count($re['data']['users'] );
            test( $no == 3, "3 should be pulled out. $no users pulled out: " . error_string($re) );

        }

        $params['cond'] = "id='admin'";
        $re = $this->ex( "\\model\\user\\user::search", $params );
        test( $re['code'] == 0, "User search for admin: " . error_string($re) );
        if ( $re['code'] ) {

        }
        else {
            $no = count($re['data']['users'] );
            test( $no == 1, "1 should be pulled out. $no users pulled out: " . error_string($re) );
        }

        // get user data
        list ( $idx, $rest ) = explode('-', $user_session_id );
        $params = [
            'session_id' => $admin_session_id,
            'idx' => $idx
        ];
        $re = $this->ex("\\model\\user\\user::data", $params );
        test( $re['code'] == 0, "Admin got user data: " . error_string($re) );

        // admin update user data
        $user_name = $re['data']['user']['name'];
        $new_name = "new" . time();
        $params = [
            'session_id' => $admin_session_id,
            'idx' => $idx,
            'name' => $new_name

        ];
        $re = $this->ex("\\model\\user\\update", $params );
        test( $re['code'] == 0, "Admin updated user data: " . error_string($re) );




        // get updated user data.
        $params = [
            'session_id' => $admin_session_id,
            'idx' => $idx
        ];
        $re = $this->ex("\\model\\user\\user::data", $params );
        test( $re['code'] == 0, "Admin got user data: " . error_string($re) );
        if ( $re['code'] ) { // update failed

        }
        else { // update success

            $user = $re['data']['user'];

            // compare.
            test( $user['name'] == $new_name, "User updated: " . error_string($re) );
        }



    }


}