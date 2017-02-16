<?php

namespace model\user;
class Create_Test extends \model\test\Test {
    public function run() {


        $n = '-' . date('his');
        $data = [];
        $data['id'] = "id$n";
        $data['password'] = "password";

        $data['email'] = "email";
        $data['nickname'] = "nickname";
        $data['name'] = "name";
        $data['birth_day'] = "19731016";
        $data['gender'] = 'M';
        $data['mobile'] = '09174678000';
        $data['landline'] = '0453224133';
        $data['country'] = 'Korea';
        $data['city'] = 'GimHae';
        $data['zipcode'] = '621050';
        $data['province'] = 'KyungNam';
        $data['meta'] = [ 'weight'=>'80kg', 'height'=>'174cm'];

        $re = user()->create( $data );


        test( is_success($re), "Create_Test: id: $data[id], " . error_string($re) );

        $user = $this->getUserData( $re['session_id'] );

        test( is_success( $user ), "Create_Test: got user data");

        test( $user['id'] == $data['id'], "ID matches");
        test( $user['meta']['weight'] == $data['meta']['weight'], "weight matches");

    }
}