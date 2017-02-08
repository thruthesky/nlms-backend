<?php
/**
 * @see README.md
 */
class Logout extends User {
    public function __construct()
    {

        parent::__construct();

        if ( empty( in('session_id') ) ) error( ERROR_SESSION_ID_EMPTY );

        $user = $this->get_user_by_session_id( in('session_id') );
        if ( empty( $user ) ) error( ERROR_USER_NOT_FOUND );


        $this->reset( $user );
        $this->update( [ 'session_id' => '' ] );
        success();

    }
}
