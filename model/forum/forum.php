<?php
/**
 *
 */

namespace model\forum;
class Forum extends \model\base\Base
{

    public function __construct()
    {
        parent::__construct();


    }


    /**
     *
     * HTTP interface for load
     *
     * @param null|string $what
     * @return mixed
     * @code
     *      $config = $this->getConfig( in('id') );
     * @endcode
     */
    public function load( $what = 'NO-ARGUMENT' )
    {
        // If there is any value, then it is not HTTP interface call.

        if ( $what != 'NO-ARGUMENT' ) return parent::load( $what );

        $idx = in('idx_config');
        if ( empty($idx) ) $idx = in('idx_data');
        if ( empty( $idx ) ) return error( ERROR_FORUM_IDX_CONFIG_EMPTY );

        $record = parent::load( $idx );


        return result( $record );
    }



}

