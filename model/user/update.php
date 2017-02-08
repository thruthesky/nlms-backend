<?php

class Update extends User {
    public function __construct()
    {

        parent::__construct();



        if ( in('id') ) error( ERROR_CANNOT_CHANGE_USER_ID );

        $data = [];
        $data['email'] = in('email');
        $data['nickname'] = in('nickname');
        $data['name'] = in('name');


        $user = $this->get_user_by_session_id( in('session_id') );

        $this->reset( $user );
        $this->update( $data );
        success( $this->get_session_id() );
    }
}
