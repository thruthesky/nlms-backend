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
     * HTTP interface
     *
     * @return mixed
     *
     *
     */
    public function create() {

        if ( empty(in('id') ) ) return error( ERROR_FORUM_ID_EMPTY ); // @fixed. put right error message.

        $data = [];
        $data['id'] = in('id');
        $data['name'] = in('name');
        $data['description'] = in('description');
        if( strlen( in('id') ) > 64 ) return error( ERROR_FORUM_CONFIG_ID_IS_TOO_LONG );
        if( strlen( in('name') ) >128) return error( ERROR_FORUM_CONFIG_NAME_IS_TOO_LONG );


        if ( ! currentUser()->isAdmin() ) return error( ERROR_PERMISSION_ADMIN );

        $config = $this->load( in('id') );



        if ( is_error($config) ) return error( $config ); // @fixed by Mr. Song. Right error should be returned.
        if ( $config ) return error( ERROR_FORUM_CONFIG_EXIST ); //
        $forum_idx = $this->insert( $data );
        if ( $forum_idx <= 0 ) error( $forum_idx );
        else success( ['idx'=>$forum_idx] );
        return OK;
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
        return OK;
    }

    /**
     * HTTP interface
     * @param null $compatibility_arg1
     * @return mixed
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


    /**
     * @deprecated Use 'load()'
     *
     * Unnecessary function.
     * @return array|mixed|null
     */

    public function getConfig( ) {
        return $this->load();
    }


}