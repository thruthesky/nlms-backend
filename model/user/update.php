<?php
namespace model\user;
class Update extends User {
    public function __construct()
    {

        parent::__construct();



        if ( in('id') ) error( ERROR_CANNOT_CHANGE_USER_ID );

        $data = [];
        $data['email'] = in('email');
        $data['nickname'] = in('nickname');
        $data['name'] = in('name');


        $this->load_by_session_id( in('session_id') );
        $this->update( $data );
        success( [ 'session_id' => $this->get_session_id() ] );
    }
}
