<?php

namespace model\forum;
class Forum_Test extends \model\test\Test {


    public function run() {
        $this->testForum();
    }
    private function testForum() {
        $this->createForumConfig(['id'=>'test-forum', 'name'=>'Test ForumConfig']);
        $this->createForumData(['title'=>'test-title-form-data', 'content'=>'Test ForumData']);
    }


    private function createForumConfig( $params ) {


        $re = $this->ex( "\\model\\forum\\Config::create", $params );
        if ( $re['code'] == ERROR_FORUM_CONFIG_EXIST ) { // if exists,
            $re = $this->ex( "\\model\\forum\\Config::delete", $params ); // delete
            test( $re['code'] == 0, "Deleteing forum config - $params[id], " . error_string( $re ));
            $re = $this->ex( "\\model\\forum\\Config::create", $params ); // create
        }


        test( is_success($re), "Creating forum config - $params[id], " . error_string( $re ));


        $forum_config_idx = $re['data']['idx'];
        $re = $this->ex( "\\model\\forum\\Config::create", $params );
        test( $re['code'] == ERROR_FORUM_CONFIG_EXIST, "Forum config already exist: $params[id]. " . error_string($re) );
        $editconfig = ['idx'=>$forum_config_idx, 'id'=>'edit-forum', 'name'=>'edit ForumConfig'];
        $re = $this->ex( "\\model\\forum\\Config::edit", $editconfig);
        test( $re['code'] == 0, "Updating Forum config - $params[id]");
        $re = $this->ex( "\\model\\forum\\Config::delete", $editconfig );
        test( $re['code'] == 0, "Deleting forum config - $editconfig[id]");
        $re = $this->ex( "\\model\\forum\\Config::delete", $editconfig );
        test( $re['code'] == ERROR_FORUM_CONFIG_NOT_EXIST, "Forum already deleted - $editconfig[id]");



    }




    private function createForumData( $params ) {

        $data = [
            'id'=> 'user-id-' . time(),
            'name'=> 'user-name-' . time()
        ];
        $session_id = $this->createUser( $data );
        $params['session_id'] = $session_id;
        $re = $this->ex( "\\model\\forum\\Data::create", $params );
        test( $re['code'] == 0, "Creating forum config - $params[title]. " . error_string( $re ));
        $forum_data_idx = $re['data']['forum_data'];
        $editdata = ['idx'=>$forum_data_idx, 'title'=>'edit-data', 'content' => 'edit ForumData'];
        $re = $this->ex( "\\model\\forum\\Data::edit", $editdata );
        test( $re['code'] == 0, "Updating Forum Data - $editdata[title]");
        $re = $this->ex( "\\model\\forum\\Data::delete", $editdata );
        test( $re['code'] == 0 , "Deleting forum data - $editdata[title]");
        $re = $this->ex( "\\model\\forum\\Data::delete", $editdata );
        test( $re['code'] == ERROR_FORUM_DATA_NOT_EXIST , "Forum Data Already deleted - $editdata[title]");
    }

}