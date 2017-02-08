<?php
/**
 * @see README.md
 */
class Create extends User {
    public function __construct()
    {

        parent::__construct();

        $data = [];
        $data['id'] = in('id');
        $data['email'] = in('email');
        $data['nickname'] = in('nickname');
        $data['name'] = in('name');

        $user_idx = $this->create( $data );


        $this->reset( $user_idx );

        success( $this->get_session_id() );


    }
}
