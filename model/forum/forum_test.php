<?php

namespace model\forum;
class Forum_Test extends \model\test\Test {


    public function run() {
        $this->testForum();
    }
    private function testForum() {
        $this->createForumConfig(['id'=>'test-forum', 'name'=>'Test ForumConfig']);
        $this->createForumData(['id'=>'test-forum-data', 'title'=>'test-title-form-data', 'content'=>'Test ForumData']);
    }




    private function createForumConfig( $params ) {


        $params2 = $params;



        $params2['id'] = $this->randomString(65);
        $re = $this->ex( "\\model\\forum\\Config::create", $params2 );
        test( $re['code'] == ERROR_FORUM_CONFIG_ID_IS_TOO_LONG ,"Forum Config create test with id more than 64 characters" . $re['code']);
        $params2 = $params;
        $params2['name'] = $this->randomString(129);
        $re = $this->ex( "\\model\\forum\\Config::create", $params2 );
        test( $re['code'] == ERROR_FORUM_CONFIG_NAME_IS_TOO_LONG , "Forum Config create test with name more than 128 characters" . $re['code']);


        $re = $this->ex( "\\model\\forum\\Config::create", $params );


        if ( is_error( $re ) == ERROR_FORUM_CONFIG_EXIST ) {

            $re = $this->ex( "\\model\\forum\\Config::delete", $params ); // delete
            test( $re['code'] == 0, "Deleting forum config - $params[id], " . error_string( $re ));
            $re = $this->ex( "\\model\\forum\\Config::create", $params ); // create
        }


        test( is_success($re), "Creating forum config - $params[id], " . error_string( $re ));



        $forum_config_idx = $re['data']['idx'];
        $forum_config = forum_config()->load( $forum_config_idx );
        test( is_success( $forum_config ) , "Loading Config if Forum Config is successfully created");


        $re = $this->ex( "\\model\\forum\\Config::create", $params );
        di($re);
        test( $re['code'] == ERROR_FORUM_CONFIG_EXIST, "Forum config already exist: $params[id]. " . error_string($re) );

        $editconfig = ['idx'=>$forum_config_idx, 'id'=>'edit-forum', 'name'=>'edit ForumConfig'];
        $re = $this->ex( "\\model\\forum\\Config::edit", $editconfig);
        test( $re['code'] == 0, "Updating Forum config - $params[id]");

        $forum_config = forum_config()->load( $forum_config_idx );
        test( $forum_config['id'] == $editconfig['id'] , "Checking edited ForumConfig id matched " );


        $re = $this->ex( "\\model\\forum\\Config::delete", $editconfig );
        test( $re['code'] == 0, "Deleting forum config - $editconfig[id]");

        $re = $this->ex( "\\model\\forum\\Config::edit", $editconfig);
        test( $re['code'] == ERROR_FORUM_CONFIG_NOT_EXIST, "Updating Forum config Not Exist - $params[id] " . error_string($re) );

        $re = $this->ex( "\\model\\forum\\Config::delete", $editconfig );
        test( $re['code'] == ERROR_FORUM_CONFIG_NOT_EXIST, "Forum Config already deleted -" . error_string($re) );



    }




    private function createForumData( $params ) {


        $params['id'] = 'id-' . time();


        $re = $this->ex( "\\model\\forum\\Config::create", $params );
        if ( is_success($re) ) {
            test( is_success($re), "createForumData::config::create() " . error_string($re) );
        }
        else {

            if ( $re['code'] == ERROR_FORUM_CONFIG_EXIST ) {

            }
            else test( is_success($re), "createForumData::config::create() " . error_string($re) );
        }

        $params['idx_config'] = $re['data']['idx'];
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
        $user = user()->load_by_session_id($session_id);
        $params['session_id'] = $session_id;
        $params['idx_user'] = $user['idx'];

        $params_2 = $params;
        $params_2['idx_user'] = $this->randomString(5);
        $re = $this->ex( "\\model\\forum\\Data::create", $params_2 );
        test( $re['code'] == ERROR_USER_IDX_NOT_NUMBER, "Forum Data create test user_idx not number");

        $params_2 = $params;
        $params_2['idx_config'] = $this->randomString(3);
        $re = $this->ex( "\\model\\forum\\Data::create", $params_2 );
        test( $re['code'] == ERROR_IDX_CONFIG_NOT_NUMBER, "Forum Data create test config_idx not number");

        $params_2 = $params;
        $params_2['title'] = null;
        $re = $this->ex( "\\model\\forum\\Data::create", $params_2 );
        test( $re['code'] == ERROR_FORUM_DATA_TITLE_EMPTY, "Creating forum Data without title. " . error_string( $re ));

        $params_2['idx_config'] = null;
        $re = $this->ex( "\\model\\forum\\Data::create", $params_2 );
        test( $re['code'] == ERROR_FORUM_IDX_CONFIG_EMPTY , "Creating forum Data without config_idx: ". $re['code'] );
        $params_2 = $params;

        $params_2['title'] = $this->randomString(257);
        $re = $this->ex( "\\model\\forum\\Data::create", $params_2 );
        test( is_error( $re ), "Forum Data create test with title more than 256 characters: " . error_string( $re ));
        $this->forumDataGets();



        $re = $this->ex( "\\model\\forum\\Config::load", $params );
        test( is_success( $re ), "Config load - $params[id]. " . error_string( $re ));

        $this->forumConfigGet($params);

        $re = $this->ex( "\\model\\forum\\Config::getconfig", $params );
        test( $re['code'] == 0, "Getconfig test". $re['code']);


        $params['idx_user'] = $user['idx'];
        $re = $this->ex( "\\model\\forum\\Data::create", $params );
        test( $re['code'] == 0, "Creating forum Data - $params[title]. " . error_string( $re ));
        $forum_data_idx = $re['data']['forum_data'];

        $forumdata = forum_data()->load( $forum_data_idx );
        test( is_success($forumdata), "Checking posted data idx: $forumdata[idx]");

        $editdata = ['idx'=>$forum_data_idx, 'title'=>'edit-data', 'content' => 'edit ForumData'];

        $re = $this->ex( "\\model\\forum\\Data::edit", $editdata );
        test( $re['code'] == ERROR_SESSION_ID_EMPTY, "Updating Forum Data without session_id - $editdata[title]");

        $editdata['session_id'] = $this->randomString(18);
        $editdata['idx_user'] = $user['idx'];
        $re = $this->ex( "\\model\\forum\\Data::edit", $editdata );
        test( $re['code'] == ERROR_WRONG_SESSION_ID , "Update Forum Data with wrong session_id");

        $editdata['session_id'] = $session_id;
        $editdata['idx_user'] = null;
        $re = $this->ex( "\\model\\forum\\Data::edit", $editdata );
        test( $re['code'] == ERROR_USER_IDX_NOT_NUMBER  ,"Forum Data update test with not numeric user_idx" . $re['code']);



        $editdata['idx_user'] = $user['idx'];
        $editdata2 = $editdata;
        $editdata2['title'] = $this->randomString(257);
        $re = $this->ex( "\\model\\forum\\Data::edit", $editdata2 );
        test( $re['code'] == ERROR_TITLE_TOO_LONG, "Forum Data edit test with more than 256 characters". $re['code']);

        $re = $this->ex( "\\model\\forum\\Data::edit", $editdata );
        test( $re['code'] == 0, "Update Forum Data");
        $forumdata = forum_data()->load( $forum_data_idx );
        test( $re['data']['forum_data']['title']== $forumdata['title'], "Checking edited, Edited data title matched" );

        $deletedata= $editdata;
        $deletedata['session_id'] = $this->randomString(5);
        $re = $this->ex( "\\model\\forum\\Data::delete", $deletedata );
        test( $re['code'] == ERROR_WRONG_SESSION_ID , "Forum Data delete test with wrong session_id" . $re['code']);

        $deletedata['session_id'] = null;
        $re = $this->ex( "\\model\\forum\\Data::delete", $deletedata );
        test( $re['code'] == ERROR_SESSION_ID_EMPTY , "Forum Data delete test with empty sesion_id" . $re['code']);

        $re = $this->ex( "\\model\\forum\\Data::delete", $editdata );
        test( $re['code'] == 0 , "Deleting forum data - $editdata[title]");

        $re = $this->ex( "\\model\\forum\\Data::delete", $editdata );
        test( $re['code'] == ERROR_FORUM_DATA_NOT_EXIST , "Forum Data Already deleted - $re[code]");
    }

    private function forumDataGets() {
        $params = [];

        $re = $this->ex( "\\model\\forum\\Data::gets", $params );
        test( $re['code'] == ERROR_FORUM_IDX_CONFIG_EMPTY, "Forum Data gets config_idx empty". $re['code']);

        $params = ['idx_config' => 12312412413 . rand(100, 300)];
        $re = $this->ex( "\\model\\forum\\Data::gets", $params );
        test( $re['code'] == ERROR_FORUM_CONFIG_NOT_EXIST, "Gets Data gets without config". $re['code']);
    }

    private function forumConfigGet( $params ) {
        $params_2 = [];

        $re = $this->ex( "\\model\\forum\\Config::getconfig", $params_2 );
        test( $re['code'] == ERROR_FORUM_IDX_CONFIG_EMPTY, "getconfig test config_idx empty". $re['code']);

        $params_2 = ['idx_config' => rand(100, 300)];
        $re = $this->ex( "\\model\\forum\\Config::getconfig", $params_2 );

        test( is_success($re) && empty($re['data']), "Getconfig test Forum config not exist". $re['code']);


        $re = $this->ex( "\\model\\forum\\Config::getconfig", $params );
        test( $re['code'] == 0, "GetConfig Test" );
    }

}