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
     * @param $id
     * @return mixed
     * @code
     *      $config = $this->getConfig( in('id') );
     * @endcode
     */
    protected final function get($id)
    {
        return db()->row(" SELECT * FROM {$this->getTable()} WHERE id='$id'");
    }


}

