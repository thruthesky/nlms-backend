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
     * @Attention it does not stop the script. it just return empty if there is no user by that $idx.
     *
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
    /*
    public function load( $idx ) {


        if ( is_numeric( $idx ) ) {
            $idx = "idx=$idx";
        }
        else if ( strpos( $idx, '=' ) || stripos( $idx, ' LIKE ') ) {

        }
        else {
            $idx = "id = '$idx'";
        }
        return parent::load( $idx );

        
    }
*/


    /**
     *      HTTP INTERFACES
     *
     *
     */

    /**
     * Returns user record and its meta.
     *
     *
     *
     * @return void
     *
     * @expected JSON return.
    Array
    (
    [code] => 0
    [data] => Array
    (
    [idx] => 14
    [id] => user-1486979723
     *
    [domain] =>
    [name] => Updated Name
    [middle_name] =>
    [last_name] =>
    [nickname] =>
    [email] =>
    [gender] =>
    [birth_year] =>
    [birth_month] =>
    [birth_day] =>
    [landline] =>
    [mobile] =>
    [address] =>
    [country] =>
    [province] =>
    [city] =>
    [zipcode] =>
     *
    [stamp_resign] => 0
    [block] => 0
    [block_reason] =>
    [resign_reason] =>
    [meta] => Array
    (
    [age] => '22'
    [classid] => 'my-id'
    )

    )

    )
     *
     */
    public function data() {
        $user = $this->load_by_session_id( in('session_id') );
        unset( $user['password'], $user['session_id'], $user['stamp_registration'] );
        $_meta = meta()->gets( 'user', $user['idx'] );
        $metas = [];
        foreach( $_meta as $arr ) {
            $metas[ $arr['code'] ] = $arr['data'];
        }
        $user['meta'] = $metas;
        success( $user );
    }


}
