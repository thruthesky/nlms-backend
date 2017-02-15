<?php
namespace model\test;
class Forum {


    public function createSampleData() {
        if ( empty(in('forum_id') ) ) return error(-1, "Input forum id");
        $config = forum_config()->load( in('forum_id') );
        if( empty($config) ) return error(-2, "No forum config by that ID - " . in('forum_id') );



        success();


    }

}