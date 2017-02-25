<?php
/**
 * @see README.md
 */
namespace model\user;

class Create extends User {
    public function __construct()
    {

        parent::__construct();

        
        if ( empty( in('id') ) ) return error( ERROR_USER_ID_EMPTY );
        if ( empty( in('password') ) ) return error( ERROR_PASSWORD_EMPTY );



        $data = [];
        $data['id'] = in('id');
        $data['password'] = in( 'password' );

        $data['email'] = in('email');
        $data['nickname'] = in('nickname');
        $data['name'] = in('name');
        $data['birth_day'] = in('birth_day', 0);
        $data['gender'] = in('gender');
        $data['mobile'] = in('mobile');
        $data['landline'] = in('landline');
        $data['country'] = in('country');
        $data['city'] = in('city');
        $data['zipcode'] = in('zipcode');
        $data['province'] = in('province');
        $data['meta'] = in('meta');
        $data['address'] = in('address');


        result( $this->create( $data ) );


    }

}
