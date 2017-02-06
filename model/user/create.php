<?php

include_once 'model/user/user.php';
class Create extends  User {
    public function __construct()
    {

        $data = [];
        $data['id'] = in('id');
        $data['email'] = in('email');

        if ( $this->load( $data['id'] ) ) error("user-exist");

        db()->insert('user', $data);

        success('user created');
    }
}