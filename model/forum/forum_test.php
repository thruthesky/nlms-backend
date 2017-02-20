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

        $forum_config = forum_config()->load( $forum_config_idx );
        test( is_success( $forum_config ) , "Loading Config if Forum Config is successfully created");

        $re = $this->ex( "\\model\\forum\\Config::create", $params );
        test( $re['code'] == ERROR_FORUM_CONFIG_EXIST, "Forum config already exist: $params[id]. " . error_string($re) );

        $editconfig = ['idx'=>$forum_config_idx, 'id'=>'edit-forum', 'name'=>'edit ForumConfig'];
        $re = $this->ex( "\\model\\forum\\Config::edit", $editconfig);
        test( $re['code'] == 0, "Updating Forum config - $params[id]");

        $forum_config = forum_config()->load( $forum_config_idx );
        test( $forum_config['id'] == $editconfig['id'] , "Checking edited ForumConfig id matched " );
        test( $forum_config['id'] == $editconfig['id'] , "Checking edited ForumConfig id matched ");

        $re = $this->ex( "\\model\\forum\\Config::delete", $editconfig );
        test( $re['code'] == 0, "Deleting forum config - $editconfig[id]");

        $re = $this->ex( "\\model\\forum\\Config::edit", $editconfig);
        test( $re['code'] == ERROR_FORUM_CONFIG_NOT_EXIST, "Updating Forum config Not Exist - $params[id] " . error_string($re) );

        $re = $this->ex( "\\model\\forum\\Config::delete", $editconfig );
        test( $re['code'] == ERROR_FORUM_CONFIG_NOT_EXIST, "Forum Config already deleted -" . error_string($re) );



    }




    private function createForumData( $params ) {

        $re = $this->ex( "\\model\\forum\\Config::create", $params );

        $params['config_idx'] = $re['data']['idx'];
        $re = $this->ex( "\\model\\forum\\Data::create", $params );
        test( $re['code'] == ERROR_SESSION_ID_EMPTY, "Creating forum Data without session_id. " . error_string( $re ));


        $params['session_id'] = "-". rand(1, 20);
        $re = $this->ex( "\\model\\forum\\Data::create", $params );
        test( $re['code'] == ERROR_WRONG_SESSION_ID, "Creating forum Data with wrong session_id. " . error_string( $re ));

        $data = [
            'id'=> 'user-id-' . time(),
            'name'=> 'user-name-' . time()
        ];
        $session_id = $this->createUser( $data );
        $params['session_id'] = $session_id;

        $params_2 = $params;
        $params_2['title'] = null;
        $re = $this->ex( "\\model\\forum\\Data::create", $params_2 );
        test( $re['code'] == ERROR_FORUM_DATA_TITLE_EMPTY, "Creating forum Data without title. " . error_string( $re ));

        $params_2['config_idx'] = null;
        $re = $this->ex( "\\model\\forum\\Data::create", $params_2 );
        test( $re['code'] == ERROR_FORUM_CONFIG_IDX_EMPTY , "Creating forum Data without config_idx -". $re['code'] );

        $this->forumDataGets();

        $re = $this->ex( "\\model\\forum\\Config::getconfig", $params );
        test( $re['code'] == 0, "Forum Data gets Test");

        $this->forumConfigGet($params);

        $re = $this->ex( "\\model\\forum\\Config::getconfig", $params );
        test( $re['code'] == 0, "Getconfig test". $re['code']);

        $re = $this->ex( "\\model\\forum\\Data::create", $params );
        test( $re['code'] == 0, "Creating forum Data - $params[title]. " . error_string( $re ));
        $forum_data_idx = $re['data']['forum_data'];

        $forumdata = forum_data()->load( $forum_data_idx );
        test( is_success($forumdata), "Checking posted data idx: $forumdata[idx]");

        $editdata = ['idx'=>$forum_data_idx, 'title'=>'edit-data', 'content' => 'edit ForumData'];
        $re = $this->ex( "\\model\\forum\\Data::edit", $editdata );
        test( $re['code'] == 0, "Updating Forum Data - $editdata[title]");

        $forumdata = forum_data()->load( $forum_data_idx );
        test( $re['data']['forum_data']['title']== $forumdata['title'], "Checking edited, Edited data title matched" );

        $re = $this->ex( "\\model\\forum\\Data::delete", $editdata );
        test( $re['code'] == 0 , "Deleting forum data - $editdata[title]");

        $re = $this->ex( "\\model\\forum\\Data::delete", $editdata );
        test( $re['code'] == ERROR_FORUM_DATA_NOT_EXIST , "Forum Data Already deleted - $editdata[title]");
    }

    private function forumDataGets(){
        $params = [];

        $re = $this->ex( "\\model\\forum\\Data::gets", $params );
        test( $re['code'] == ERROR_FORUM_CONFIG_IDX_EMPTY, "Forum Data gets config_idx empty". $re['code']);

        $params = ['config_idx' => 12312412413 . rand(100, 300)];
        $re = $this->ex( "\\model\\forum\\Data::gets", $params );
        test( $re['code'] == ERROR_FORUM_CONFIG_NOT_EXIST, "Gets Data gets without config". $re['code']);
    }

    private function forumConfigGet( $params ) {
        $params_2 = [];

        $re = $this->ex( "\\model\\forum\\Config::getconfig", $params_2 );
        test( $re['code'] == ERROR_FORUM_CONFIG_IDX_EMPTY, "getconfig test config_idx empty". $re['code']);

        $params_2 = ['config_idx' => rand(100, 300)];
        $re = $this->ex( "\\model\\forum\\Config::getconfig", $params_2 );
        test( $re['code'] == ERROR_FORUM_CONFIG_NOT_EXIST, "Getconfig test Forum config not exist". $re['code']);


        $re = $this->ex( "\\model\\forum\\Config::getconfig", $params );
        test( $re['code'] == 0, "GetConfig Test" );
    }

}