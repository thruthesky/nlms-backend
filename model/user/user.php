<?php
/**
 *
 */

namespace model\user;
class User extends \model\base\Base {

    public function __construct()
    {
        parent::__construct();

        $this->setTable('user');
    }

    /**
     *
     * Return unique session id for each user.
     *
     * @return string
     */
    public function get_session_id() {

        if ( empty($this) || !isset( $this->f['idx']) ) error(ERROR_USER_NOT_SET);
        $n = $this->f['idx'];
        $i = $this->f['id'];
        $p = $this->f['password'];
        $r = $this->f['stamp_registration'];
        $t = md5(uniqid(rand(), true));

        $session_id = $n . '-' . md5( "$i,$r,$t,$n,$p" );


        $this->update( ['session_id' => $session_id] );

        return $session_id;
    }

    /**
     *
     * loads a user by session id.
     * @warning it does what 'load()' does.
     * @param $session_id
     * @return array|null
     * @code
     *         $this->load_by_session_id( in('session_id') );
     * @endcode
     */
    public function load_by_session_id( $session_id ) {
        if ( empty($session_id) ) error( ERROR_SESSION_ID_EMPTY );
        $user = $this->load( "session_id='$session_id'");
        if ( empty($user) ) error( ERROR_WRONG_SESSION_ID );
        return $user;
    }


    /**
     *
     * @attention it stop the script if there is no user by $idx(condition)
     *
     *          SO, If you need not to stop the script,
     *          YOU MUST use '_load()' instead of 'load()'
     *
     * @param $idx - if it is a number, it assumes as user.idx
     *              - or else if it has '=' or 'like' then, it assumes as user.id.
     *              - or else if it assumes as user.id
     * @return array|null
     *
     *
     * @code
     *      $user = $this->load( 123 );
     *      $user = $this->load( in('id') );
     *      $user = $this->load( "session_id='$session_id'");
     * @endcode
     */
    public function load( $idx ) {
        if ( is_numeric( $idx ) ) {
            $idx = "idx=$idx";
        }
        else if ( strpos( $idx, '=' ) || stripos( $idx, ' LIKE ') ) {

        }
        else {
            $idx = "id = '$idx'";
        }
        $user = parent::load( $idx );
        if ( empty( $user ) ) error( ERROR_USER_NOT_FOUND );
        return $user;
    }


    /**
     *      HTTP INTERFACES
     */

    public function data() {
        success( $this->load_by_session_id( in('session_id') ) );
    }


}
