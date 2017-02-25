<?php
/**
 * @see README.md
 */
namespace model\forum;
class Data extends Forum {
    public function __construct()
    {
        parent::__construct();
        $this->setTable('forum_data');
    }
    public function create() {
        if ( empty( in('session_id') ) ) return error( ERROR_SESSION_ID_EMPTY );
        if( empty( in('idx_config') ) ) return error( ERROR_FORUM_IDX_CONFIG_EMPTY );
        if( ! is_numeric( in('idx_config') ) ) return error( ERROR_IDX_CONFIG_NOT_NUMBER );
        $config = forum_config()->getConfig();
        if( empty( $config ) ) return error( ERROR_FORUM_CONFIG_NOT_EXIST );
        $user = user()->load_by_session_id( in('session_id') );
        if ( empty($user) ) return error( ERROR_USER_NOT_EXIST );
        if( empty( in('idx_user') ) ) return error( ERROR_USER_IDX_EMPTY );
        if( !is_numeric( in('idx_user') ) ) return error( ERROR_USER_IDX_NOT_NUMBER);

        $data = [];
        $data['idx_user'] = in('idx_user');
        $data['title'] = in('title');
        $data['content'] = in('content');
        $data['idx_config'] = in('idx_config');
        if( empty( $data['title'] ) ) return error( ERROR_FORUM_DATA_TITLE_EMPTY );
        if( strlen( $data['title'] ) > 256 ) return error( ERROR_TITLE_TOO_LONG );
        $forumdata_idx = $this->insert( $data );
        if ( $forumdata_idx <= 0 ) return error( $forumdata_idx );
        success( ['forum_data'=>$forumdata_idx] );
    }
    public function edit() {
        if( empty( in('session_id') ) ) return error( ERROR_SESSION_ID_EMPTY );
//        if( empty( in('idx_user') ) ) return error( ERROR_IDX_EMPTY );
        if( !is_numeric(in('idx_user') ) ) return error( ERROR_USER_IDX_NOT_NUMBER );
        if( strlen( in('title') ) > 256 ) return error( ERROR_TITLE_TOO_LONG );
        $user = user()->load_by_session_id( in('session_id') );
        if( empty( $user ) ) return error( ERROR_USER_NOT_EXIST );
        $data = [];
        $data['idx'] = in('idx');
        $data['title'] = in('title');
        $data['content'] = in('content');
        $datas = $this->load($data['idx']);
        if( ! $datas ) error( ERROR_FORUM_DATA_NOT_EXIST );
        unset( $data['idx'] ); //
        $no = $this->update($data);
        if ( $no == 0 ) return error( ERROR_UNKNOWN ); // strange error. this error should not happened here.
        success( ['forum_data'=> $this->load( in('idx') )] );
    }
    public function delete( $compatibility_arg1 = null ) {
        $idx = in('idx');
        if( empty( in('session_id') ) ) return error( ERROR_SESSION_ID_EMPTY );
        if ( empty($idx) ) $idx = "id='".in('id')."'"; // if it is not string, it is id.
        $data = $this->load( $idx );
        $user = user()->load_by_session_id( in('session_id') );
        if( !$data ) error( ERROR_FORUM_DATA_NOT_EXIST );
        if( $data['idx_user'] != $user['idx'] ) return error( ERROR_USER_IDX_NOT_MATCHED );
        $this->destroy();
        success();
    }

    public function gets() {
        if( empty( in( 'idx_config' ) ) ) return error( ERROR_FORUM_IDX_CONFIG_EMPTY );
        $data['idx_config'] = in('idx_config');
        $config = forum_config()->load( $data['idx_config']);
        if( empty($config) ) return error( ERROR_FORUM_CONFIG_NOT_EXIST );


        $cond = "idx_config=$data[idx_config]";
        $forum_data = $this->loads($cond);

        success(['forum_data' => $forum_data]);
    }
}