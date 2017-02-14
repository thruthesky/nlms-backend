<?php
/**
 * @see README.md
 */
namespace model\user;

class Create extends User {
    public function __construct()
    {

        parent::__construct();


        if ( empty( in('id') ) ) error( ERROR_USER_ID_EMPTY );
        if ( empty( in('password') ) ) error( ERROR_PASSWORD_EMPTY );


        $data = [];
        $data['id'] = in('id');
        $data['email'] = in('email');
        $data['nickname'] = in('nickname');
        $data['name'] = in('name');
        $data['password'] = $this->encryptPassword( in('password') );

        $user = $this->load( in('id') );

        if ( $user ) return error( ERROR_USER_EXIST );
        $user_idx = $this->insert( $data );

        if ( $user_idx <= 0 ) return error( $user_idx );

        $this->reset( $user_idx );

        meta()->sets( 'user', $user_idx, in('meta') );

        success( ['session_id'=>$this->get_session_id()] );

    }

}
