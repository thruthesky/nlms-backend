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
     * @attention it does not check if the user has authenticated or not.
     *
     * @work
     *          1. It just generate a new session id based on $this->record
     *          2. save the session id into database table record.
     *          3. return it.
     *
     * @return string
     */
    public function get_session_id() {

        if ( empty($this) || !isset( $this->record['idx']) ) error(ERROR_USER_NOT_SET);
        $n = $this->record['idx'];
        $i = $this->record['id'];
        $p = $this->record['password'];
        $r = $this->record['stamp_registration'];
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
        if ( empty($session_id) ) return ERROR_SESSION_ID_EMPTY;
        $user = $this->load( "session_id='$session_id'");
        if ( empty($user) ) return ERROR_WRONG_SESSION_ID;
        return $user;
    }

    public function login() {
        return !! $this->record;
    }


    /**
     *
     * Returns true if the login user is ADMIN.
     *
     * @return bool
     */
    public function isAdmin() {
        if ( ! $this->login() ) return false;
        if ( array_key_exists( 'id', $this->record ) ) {
            return $this->record['id'] == $GLOBALS['ADMIN_ID'];
        }
        else return false;
    }


    /**
     *
     * Returns a new Session ID of a user.
     *
     * @use this method when you want to login a user without password.
     *
     * @attention It generates a FAKE session id and save it into user record and returns it.
     * @attention It does not check user's password.
     * @attention previous session-id will be invalid.
     *
     * @param $id
     * @return int|string
     *
     *      - int as error code on error
     *      - string as session-id on success.
     *
     *
     * @code
     *      $params['session_id'] = user()->forceLogin('admin');
     * @endcode
     */
    public function forceLogin( $id ) {
        if ( empty($id ) ) return ERROR_USER_ID_EMPTY;
        if ( ! $this->load( $id ) ) return ERROR_USER_NOT_EXIST;
        return $this->get_session_id();
    }

    /**
     * @param $data
     * @return array|mixed
     *      - ERROR CODE ( < 0 ) will be return on error.
     *      - Array will be return on success.
            - Success return format
                    Array
                    (
                        [session_id] => 943-fccb4a3fbfd77f7606289c6437400be8
                    )
     *
     * @see readme for detail.
     */
    public function create( $data ) {

        if ( empty( $data['id'] ) ) error( ERROR_USER_ID_EMPTY );
        if ( empty( $data['password'] ) ) error( ERROR_PASSWORD_EMPTY );

        $data['password'] = $this->encryptPassword( $data['password'] );

        $user = $this->load( $data['id'] );
        if ( $user ) return error( ERROR_USER_EXIST );


        $meta = null;
        if ( array_key_exists( 'meta', $data ) ) {

            $meta = $data['meta'];
            unset( $data['meta'] );

        }

        $user_idx = $this->insert( $data );
        if ( $user_idx <= 0 ) return error( $user_idx );

        $this->reset( $user_idx );


        if ( $meta ) {

            meta()->sets( 'user', $user_idx, $meta );

        }

        return [ 'session_id' => $this->get_session_id() ];

    }


    /**
     * Updates user info.
     * @attention It updates user data based on $this->record. So, before updating a user, the user info must be saved in $this->record.
     * @param $data
     * @return void
     */
    public function update( $data ) {

        $meta = null;
        if ( array_key_exists( 'meta', $data ) ) {
            $meta = $data['meta'];
            unset($data['meta']);
        }

        parent::update( $data );
        if ( $meta ) {
            meta()->sets( 'user', $this->record['idx'], $meta );
        }

    }


    /**
     * @param $users
     */
    public function pres( &$users ) {
        foreach( $users as &$user ) {
            unset( $user['password'], $user['session_id'] );
            $user['meta'] = meta()->gets( 'user', $user['idx'] );
        }
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
     * @attention if the login user is 'admin', then he can get other user's information.
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

        if( empty( in('session_id')) ) return error( ERROR_SESSION_ID_EMPTY );
        $user = $this->load_by_session_id( in('session_id') );
        if ( empty($user) ) return error( ERROR_WRONG_SESSION_ID );


        if ( $this->isAdmin() ) { // if admin,
            if ( ! in('idx') ) return error( ERROR_IDX_EMPTY );
            $user = $this->load( in('idx') ); // load other user.
            if ( $user < 0 ) return error( $user );
            if ( empty($user) ) return error( ERROR_USER_NOT_FOUND );
        }

        unset( $user['password'], $user['session_id'], $user['stamp_registration'] );


        $_meta = meta()->gets( 'user', $user['idx'] );
        $metas = [];
        foreach( $_meta as $arr ) {
            $metas[ $arr['code'] ] = $arr['data'];
        }
        $user['meta'] = $metas;
        success( ['user'=>$user] );
    }

    /**
     * Returns rows of user information.
     *
     * @attention this is HTTP interface.
     */
    public function search() {


        if ( empty( in('session_id') ) ) return error(ERROR_SESSION_ID_EMPTY );
        if ( ! $this->load_by_session_id( in('session_id') ) ) return error( ERROR_USER_NOT_FOUND );
        if ( ! $this->isAdmin() ) return error( ERROR_PERMISSION_ADMIN );


        $cond = in('cond');
        if ( empty($cond) ) $cond = 1;


        $page = page_no( in('page') );
        $limit = page_item_limit( in('limit') );
        $from = (( $page - 1 ) * $limit);
        $cond .= " LIMIT $from, $limit";


        $users = $this->loads( $cond );
        if ( $users < 0 ) return error( $users );


        $this->pres( $users );

        success( ['users' => $users ] );

    }




}
