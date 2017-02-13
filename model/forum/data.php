<?php
/**
 * @see README.md
 */
namespace model\forum;
class data extends Forum {
    public function __construct()
    {

        parent::__construct();

        $this->setTable('forum_data');


    }


    public function create() {

        $data = [];
        $data['title'] = in('title');
        $data['content'] = in('content');

        $forum = $this->insert( $data );

        if ( $forum <= 0 ) return error( $forum );
        success( ['forum_data'=>$forum] );
    }

    public function edit() {
        $data = [];
        $data['idx'] = in('idx');
        $data['title'] = in('title');
        $data['content'] = in('content');

        $datas = $this->load($data['idx']);
        if( ! $datas ) error( ERROR_POST_NOT_EXIST );
        $forum = $this->update($data);
        success( ['forum_data'=>$forum] );
    }


    public function remove() {
        $idx = in('idx');
        $data = $this->load( $idx );
        if( !$data ) error( ERROR_POST_NOT_EXIST );
        $condition = "idx = $idx";
        $this->delete( $condition );


        success( ['deleted' => $idx] );
    }
}
