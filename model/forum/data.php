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

        $data = [];
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
