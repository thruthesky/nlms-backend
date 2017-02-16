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
     * @param $data
     * @return array|mixed
     *      - ERROR CODE ( < 0 ) will be return on error.
     *      - Array will be return on success.
     */
    public function create( $data ) {

        if ( empty( $data['id'] ) ) error( ERROR_USER_ID_EMPTY );
        if ( empty( $data['password'] ) ) error( ERROR_PASSWORD_EMPTY );

        $data['password'] = $this->encryptPassword( $data['password'] );

        $user = $this->load( $data['id'] );
        if ( $user ) return error( ERROR_USER_EXIST );


        if ( isset( $data['meta'] ) ) {

            $meta = $data['meta'];
            unset( $data['meta'] );

        }
        $user_idx = $this->insert( $data );
        if ( $user_idx <= 0 ) return error( $user_idx );

        $this->reset( $user_idx );


        if ( isset( $meta ) ) {

            meta()->sets( 'user', $user_idx, $meta );
        }

        return [ 'session_id' => $this->get_session_id() ];

    }






    /**
     *      HTTP INTERFACES
     *
     *
     */

    /**
     * Returns user record and its meta.
     *
     * @attention This is HTTP interface.
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
                     ...
                    [meta] => Array( ... )
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

    /**
     * Returns rows of user information.
     *
     * @attention this is HTTP interface.
     */
    public function search() {
        $page = page_no( in('page') );
        $limit = page_item_limit( in('limit') );
        $from = ( $page - 1 ) * $limit;
        $to = $page * $limit;
        $cond = "1 LIMIT $from, $to";
        $this->loads( $cond );
    }

}
