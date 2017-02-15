<?php
namespace model\user;
class Update extends User {
    public function __construct()
    {

        parent::__construct();


        if( empty( in('session_id') ) ) return error( ERROR_SESSION_ID_EMPTY );
        if ( in('id') ) return error( ERROR_CANNOT_CHANGE_USER_ID );

        $data = [];
        $data['email'] = in('email');
        $data['nickname'] = in('nickname');
        $data['name'] = in('name');
        $data['birth_day'] = in('birthday');
        $data['gender'] = in('gender');
        $data['mobile'] = in('mobile');
        $data['landline'] = in('landline');
        $data['country'] = in('country');
        $data['city'] = in('city');
        $data['zipcode'] = in('zipcode');
        $data['province'] = in('province');


        $this->load_by_session_id( in('session_id') );
        $this->update( $data );
        success( [ 'session_id' => $this->get_session_id() ] );
    }
}
