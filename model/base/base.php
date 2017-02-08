<?php


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
     * Quotes database identifier, e.g. table name or column name.
     * For instance:
     * tablename -> `tablename`
     * @param  string $field
     * @return string
     */
    function escape($field) {

        /*
        static $grammar = false;
        if (!$grammar) {
            $grammar = DB::table('user')->getGrammar(); // The table name doesn't matter.
        }
        return $grammar->wrap($field);
        */
        return $field;
    }




    /**
     * Returns user record.
     * @param $idx - If it is numeric, then it is idx. so, this method will get the record on the idx.
     *  If $idx is a string, then it assumes that is is a WHERE SQL clause.
     * @return array|null
     */

    public function load( $idx ) {
        if ( is_numeric($idx) ) $where = "idx=$idx";
        else $where = " $idx ";
        return db()->get_row("SELECT * FROM user WHERE $where", ARRAY_A);
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


    /*

    public function update( $kvs, $cond ) {



        foreach($kvs as $k => $v) {
            $v = $this->escape($v);
            $k = $this->escape($k);
            $sets[] = "$k='$v'";
        }
        $set = implode(", ", $sets);
        $q = "UPDATE {$this->table} SET $set WHERE $cond";

        print_r($q);
        try {
            db::update( $q );
        }
        catch ( QueryException $e ) {
            if ( $e->errorInfo[0] == ERROR_KEY_EXISTS ) return ERROR_KEY_EXISTS;
            else return ERROR_UNKNOWN;
        }
        return OK;

    }
    */


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