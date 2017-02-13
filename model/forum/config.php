<?php
/**
 * @see README.md
 */
namespace model\forum;
class config extends Forum {
    public function __construct()
    {

        parent::__construct();

        $this->setTable('forum_config');


    }


    public function create() {

        $record = [
            'name' => '',
            'description' => ''
        ];
        $idx = $this->insert( $record );

        success( ['idx'=>$idx] );
    }
}
