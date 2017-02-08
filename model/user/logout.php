<?php
/**
 * @see README.md
 */

namespace model\user;
class Logout extends User {
    public function __construct()
    {

        parent::__construct();

        if ( empty( in('session_id') ) ) error( ERROR_SESSION_ID_EMPTY );

        $this->load_by_session_id( in('session_id') );

        //$this->reset( $user );
        $this->update( [ 'session_id' => '' ] );
        success();

    }
}
