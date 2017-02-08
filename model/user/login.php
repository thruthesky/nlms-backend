<?php
/**
 * @see README.md
 */
class Login extends User {
    public function __construct()
    {

        parent::__construct();

        if ( empty( in('id') ) ) error( ERROR_USER_ID_EMPTY );
        if ( empty( in('password') ) ) error( ERROR_PASSWORD_EMPTY );

        $user = $this->load( in('id') );
        if ( empty( $user ) ) error( ERROR_USER_NOT_FOUND );


        if ( ! $this->checkPassword( in('password'), $user['password'] ) ) error( ERROR_WRONG_PASSWORD );

        $this->reset( $user );
        success( $this->get_session_id() );

    }
}