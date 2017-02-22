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
        $data = [];
        $data['id'] = in('id');
        $data['name'] = in('name');
        $data['description'] = in('description');
        if( strlen( in('id') ) > 64 ) return error( ERROR_FORUM_CONFIG_ID_IS_TOO_LONG );
        if( strlen( in('name') ) >128) return error( ERROR_FORUM_CONFIG_NAME_IS_TOO_LONG );
        $config = $this->get( in('id') );
        if ( $config ) return error( ERROR_FORUM_CONFIG_EXIST );
        $forum_idx = $this->insert( $data );
        if ( $forum_idx <= 0 ) error( $forum_idx );
        else success( ['idx'=>$forum_idx] );
    }
    /**
     * @return mixed
     */
    public function edit() {
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

    /**
     * HTTP interface
     * @param null $compatibility_arg1
     * @return mixed|void
     */
    public function delete( $compatibility_arg1 = null ) {


        $idx = in('idx');
        if ( empty($idx) ) $idx = "id='".in('id')."'"; // if it is not string, it is id.
        if ( empty( $idx ) ) return error( ERROR_IDX_EMPTY );
        if ( ! $this->load( $idx ) ) return error ( ERROR_FORUM_CONFIG_NOT_EXIST );
        $this->destroy();
        return success();
        
        /*

        // di($idx);
        $config = $this->load( $idx );
        if( !$config ) error( ERROR_FORUM_CONFIG_NOT_EXIST );
        //$condition = "idx = $idx";
        //$this->delete( $condition );
        $this->destroy();
        success();
        */
    }

    public function getConfig( ) {
        if( empty( in('config_idx') ) ) return error( ERROR_FORUM_CONFIG_IDX_EMPTY );
        $idx = in('config_idx');
        $config = $this->load( $idx );
        if( empty( $config ) ) return error( ERROR_FORUM_CONFIG_NOT_EXIST );
        success($config);
        return $config;
    }
}