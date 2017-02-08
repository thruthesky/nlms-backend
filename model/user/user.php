<?php
/**
 *
 */

class User extends Base {

    public function __construct()
    {
        parent::__construct();

        $this->setTable('user');
    }

    /**
     * @todo make a good session_id
     * @return string
     */
    public function get_session_id() {

        $n = $this->f['idx'];
        $i = $this->f['id'];
        $p = $this->f['password'];
        $r = $this->f['stamp_registration'];
        $t = time();
        $session_id = $n . '-' . md5( "$i,$r,$t,$n,$p" );

        $this->update( ['session_id' => $session_id] );

        return $session_id;
    }



    public function get_user_by_session_id( $session_id ) {
        if ( empty($session_id) ) error( ERROR_SESSION_ID_EMPTY );
        $user = $this->load( "session_id='$session_id'");
        if ( empty($user) ) error( ERROR_WRONG_SESSION_ID );
        return $user;
    }

}