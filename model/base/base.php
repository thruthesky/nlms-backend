<?php

namespace model\base;
class Base {

    private $table = '';
    private $record = [];

    /**
     * $this->f is just an alias of $this->record for easy to access.
     * @var array
     * @code
     *
            print_r($this->f);
            $n = $this->f['idx'];
            $i = $this->f['id'];
     *
     * @endcode
     */
    public $f;

    public function __construct()
    {
        $this->f = & $this->record;
    }

    protected function setTable( $name ) {
        $this->table = $name;
    }


    /**
     *
     * Sets the record to operate with.
     * @param $idx number|array
     *
     *  if it is a numeric, it assumes as 'idx'. it gets the record of 'idx' on the table and saves the records into $record.
     *  if it is an array, it assumes it is already the record, so it just sets to $record.
     *
     * @return array|null|number
     *  it returns $this->record, meaning,
     *      - if there is no record by 'idx' and null|empty will be return.
     *      - if the $idx is not an array but empty, then it will return empty.
     *
     */
    public function reset( $idx ) {
        $this->record = null;
        if ( is_numeric($idx) ) $this->record = $this->load( $idx );
        else if ( is_array( $idx ) ) $this->record = $idx;
        return $this->record;
    }





    /**
     * Returns a record.
     *
     * @attention @important load() resets the $record.
     *
     * @param $idx - If it is numeric, then it is idx. so, this method will get the record on the idx.
     *  If $idx is a string, then it assumes that is is a WHERE SQL clause.
     * @return array|null
     */
    public function load( $idx ) {
        return self::_load( $idx );
    }
    public function _load( $idx ) {
        if ( is_numeric($idx) ) $where = "idx=$idx";
        else $where = " $idx ";
        $this->record = db()->get_row("SELECT * FROM user WHERE $where", ARRAY_A);
        return $this->record;
    }



    /**
     *
     * This creates a record into a table.
     * @note this always returns success. If there is an error, it does not return. it just stop.
     * @param $kvs
     * @return number - same as parent::insert()
     * @attention If there is any database error, it will just stop running the script and dis play json error
     */
    public function create( $kvs ) {
        $idx = db()->insert( $this->table, $kvs );
        if ( empty($idx) ) error(ERROR_DATABASE_INSERT_FAILED);
        return $idx;
    }


    public function update( $kvs ) {
        return db()->update( $this->table, $kvs, "idx={$this->record['idx']}");
    }



    public function delete() {

    }

    public function encryptPassword( $str ) {
        return md5( $str );
    }

    /**
     * Returns true if password matches.
     *
     * @param $plain_text_password
     * @param $encrypted_password
     * @return bool
     */
    public function checkPassword( $plain_text_password, $encrypted_password ) {
        return $this->encryptPassword( $plain_text_password ) == $encrypted_password;
    }
}