<?php
/**
 * @see README.md
 */

namespace model\user;
class Meta extends User {
    public function __construct()
    {

        parent::__construct();

        if ( empty( in('session_id') ) ) error( ERROR_SESSION_ID_EMPTY );
        $this->load_by_session_id( in('session_id') );

    }

    public function set() {
        $idx = $this->saveMeta( in('code'), in('data') );
        success( ['idx' => $idx ] );
    }


    public function get() {
        $data = $this->getMeta( in('code') );
        success( ['data' => $data ] );
    }
    public function gets() {
        $data = $this->getMetas();
        success( ['data' => $data ] );
    }

}


