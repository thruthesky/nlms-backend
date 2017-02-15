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

        $user = user()->load_by_session_id( in('session_id') );
        if( empty(in('forum_id')) ) return error( ERROR_FORUM_ID_EMPTY );
        $config = forum_config()->load( in('forum_id') );
        if( empty($config) ) return error( ERROR_FORUM_CONFIG_NOT_EXIST );
        if ( empty($user) ) return error( ERROR_USER_NOT_EXIST );
        if( empty( in('title') ) ) return error( ERROR_FORUM_DATA_TITLE_EMPTY );
        if( empty( in('content') ) ) return error( ERROR_FORUM_DATA_CONTENT_EMPTY );

        if( empty(in('title') ) ) return error(-1, 'error-empty-title');
        if( empty(in('content') ) ) return error(-1, 'error-empty-content');
        if( empty( in('forum_id') ) ) return error(-1, 'error-empty-forum_id');
        $config = forum_config()->load( in('forum_id') );
        if( empty( $config ) ) return error( ERROR_FORUM_CONFIG_NOT_EXIST );




        $data = [];
        $data['user_idx'] = in('user_idx');
        $data['title'] = in('title');
        $data['content'] = in('content');


        $forumdata_idx = $this->insert( $data );

        if ( $forumdata_idx <= 0 ) return error( $forumdata_idx );
        success( ['forum_data'=>$forumdata_idx] );
    }

    public function edit() {
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
        if ( empty($idx) ) $idx = "id='".in('id')."'"; // if it is not string, it is id.

        $data = $this->load( $idx );
        if( !$data ) error( ERROR_FORUM_DATA_NOT_EXIST );

        $this->destroy();


        success();
    }
}
