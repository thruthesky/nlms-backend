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
        if( strlen( in('id') ) >64 ) return error( ERROR_ID_IS_TOO_LONG );
        if ( empty( in('password') ) ) return error( ERROR_PASSWORD_EMPTY );
        if( strlen( in('password') ) > 255 ) return error( ERROR_PASSWORD_TOO_LONG );


        $mobile = in('mobile');
        if ( $mobile ) {
            if ( ! is_numeric( $mobile ) ) return error( ERROR_MOBILE_NOT_NUMERIC );
            if( strlen( $mobile ) > 32 ) return error( ERROR_MOBILE_TOO_LONG );
        }



        $data = [];
        $data['id'] = in('id');
        $data['password'] = in( 'password' );

        $data['email'] = in('email');
        $data['nickname'] = in('nickname');
        $data['name'] = in('name');
        $data['birth_day'] = in('birth_day', 00);
        $data['birth_month'] = in('birth_month', 00);
        $data['birth_year'] = in('birth_year', 0000);
        $data['gender'] = in('gender');
        $data['mobile'] = $mobile;
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
