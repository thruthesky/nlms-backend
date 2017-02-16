<?php
/**
 * @see README.md
 */
namespace model\forum;
class Config extends Forum {
    public function __construct()
    {

        parent::__construct();

        $this->setTable('forum_config');


    }


    /**
     *
     *
     * @return void|mixed
     *
     *
     */
    public function create() {


        if( empty( in('id') ) ) return error( ERROR_USER_ID_EMPTY );
        if( empty( in('session_id') ) ) return error( ERROR_SESSION_ID_EMPTY );


        $user = user()->load_by_session_id( in('session_id') );
        if ( empty($user) ) return error( ERROR_USER_NOT_EXIST );
        if( $user['id'] <>  'admin' ) return error( ERROR_PERMISSION_ADMIN );

        $data = [];
        $data['id'] = in('id');
        $data['name'] = in('name');
        $data['description'] = in('description');


        $config = $this->get( in('id') );
        if ( $config ) return error( ERROR_FORUM_CONFIG_EXIST );

        $forum_idx = $this->insert( $data );

        if ( $forum_idx <= 0 ) error( $forum_idx );
        else success( ['idx'=>$forum_idx, 'id'=>$data['id']] );

    }

    /**
     * @return mixed
     */
    public function edit() {
        if( empty( in('idx') ) ) return error( ERROR_IDX_EMPTY );
        if( empty( in('session_id' ) ) ) return( ERROR_SESSION_ID_EMPTY );
        if( empty( in('id') ) ) return error( ERROR_FORUM_ID_EMPTY );

        $user = user()->load_by_session_id( in('session_id') );
        if ( empty($user) ) return error( ERROR_USER_NOT_EXIST );
        if( $user['id'] <>  'admin' ) return error( ERROR_PERMISSION_ADMIN );

        $data = [];
        $data['idx'] = in('idx');
        $data['id'] = in('id');
        $data['name'] = in('name');
        $data['description'] = in('description');

        $config_data = $this->load($data['idx']);
        if( ! $config_data ) return error( ERROR_FORUM_CONFIG_NOT_EXIST );


        unset( $data['idx'] ); //

        $no = $this->update($data);
        if ( $no == 0 ) return error( ERROR_UNKNOWN ); // strange error. this error should not happened here.

        success( ['forum_data' => $this->load( in('idx') ) ] );

    }

    public function delete( $compatibility_arg1 = null ) {
        if( empty( in('session_id') ) ) return error( ERROR_SESSION_ID_EMPTY );

        $user = user()->load_by_session_id( in('session_id') );
        if ( empty($user) ) return error( ERROR_USER_NOT_EXIST );
        if( $user['id'] <>  'admin' ) return error( ERROR_PERMISSION_ADMIN );

        $idx = in('idx');
        if ( empty($idx) ) $idx = "id='".in('id')."'"; // if it is not string, it is id.


        // di($idx);

        $config = $this->load( $idx );
        if( !$config ) error( ERROR_FORUM_CONFIG_NOT_EXIST );

        //$condition = "idx = $idx";
        //$this->delete( $condition );

        $this->destroy();

        success();
    }


    public function getConfig() {
        if( empty( in( 'session_id') ) ) return error( ERROR_SESSION_ID_EMPTY );
        if( empty( in('id') ) ) return error( ERROR_FORUM_ID_EMPTY );

        $config = $this->get( in('id') );
        if( empty( $config ) ) error( ERROR_FORUM_CONFIG_NOT_EXIST );

        success( ['forum_data' => $config]);
    }

}
