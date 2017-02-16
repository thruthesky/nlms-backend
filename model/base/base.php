<?php
/**
 *
 * @attention Database Query must be inside this class only.
 *
 *
 *
 */
namespace model\base;
class Base {

    private $table = '';
    public $record = [];



    public function __construct()
    {
        // $this->f = & $this->record;
    }

    protected function setTable( $name ) {
        $this->table = $name;
    }
    public final function getTable() {
        return $this->table;
    }


    /**
     *
     * Sets the record to operate with.
     *
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
     * @code
            $user_idx = $this->create( $data );
            $this->reset( $user_idx );
     * @endcode
     *
     * @code
     *      $this->reset( [ 'a'=>'b' ] );
     * @endcode
     *
     * 
     */
    public function reset( $idx ) {
        $this->record = null;
        if ( is_numeric($idx) ) $this->record = $this->load( $idx );
        else if ( is_array( $idx ) ) $this->record = $idx;
        return $this->record;
    }


    /**
     * @return bool
     *      true if the record has set.
     */
    public function isRecordSet() {
        return $this->record && $this->record['idx'];
    }



    /**
     * Returns a record.
     *
     * @attention @important load() resets the $record.
     *
     * @param $what
     *              - If it is numeric, then it is idx. so, this method will get the record on the idx.
     *              - If it is one word string, then it is an 'ID'
     *              - If it is a string with ' ', =, <, >, then it assumes that is is a WHERE SQL clause.
     * @return array|null
     */
    public function load( $what ) {

        if ( empty($what) ) return ERROR_EMPTY_SQL_CONDITION;

        if ( is_numeric($what) ) $what = "idx=$what";

        else if ( strpos( $what, ' ' ) || strpos( $what, '=' ) || strpos( $what, '<' ) || strpos( $what, '>' ) ) {

        }
        else {
            $what = "id = '$what'";
        }

        if ( ! db()->secure_cond( $what ) ) return ERROR_INSCURE_SQL_CONDITION;

        $this->record = db()->row("SELECT * FROM {$this->getTable()} WHERE $what");
        return $this->record;
    }

    /**
     * Reload the data and reset $record.
     * @return array|null
     */
    public function reload() {
        if ( ! isset( $this->record['idx'] ) ) return null;
        return $this->load( $this->record['idx'] );
    }


    /**
     * Deletes $record from the database and set $record to empty.
     *
     * @return void
     *
     * @waring there is no return value.
     *
     * @see model/test/all.php
     *
     */
    public function destroy() {

        if ( isset( $this->record['idx'] ) ) {
            self::delete( 'idx=' . $this->record['idx'] );
        }
        $this->record = [];

    }

    /**
     * Returns rows of table based on the $cond.
     *
     * @attention All request to get rows from database MUST use this method IF it is only simple 'SELECT', NOT JOIN-SELECT-QUERY.
     *
     * @param $cond
     * @return array|int
     */
    public function loads( $cond )
    {
        if ( empty($cond) ) return ERROR_EMPTY_SQL_CONDITION;
        if ( ! db()->secure_cond( $cond ) ) return ERROR_INSCURE_SQL_CONDITION;
        return db()->rows("SELECT * FROM {$this->getTable()} WHERE $cond");
    }








    /**
     *
     * This creates a record into a table.
     * @note this always returns success. If there is an error, it does not return. it just stop.
     * @param $record
     *
     *
     * @return number - same as parent::insert()
     *
     *
     *
     */
    public function insert( $record ) {
        $record['created'] = time();
        return db()->insert( $this->getTable(), $record );
        /*
        if ( empty($idx) ) error(ERROR_DATABASE_INSERT_FAILED);
        return $idx;
        */
    }


    /**
     * @param $kvs
     *
     * @warning it returns a value now.
     *
     * @return bool|\PDOStatement - same as PDO::query. If there is error, FALSE will be return.
     *
     */
    public function update( $kvs ) {
        $kvs['updated'] = time();
        if ( $this->record && isset( $this->record['idx'] ) ) {
            return db()->update( $this->getTable(), $kvs, "idx={$this->record['idx']}");
        }
    }



    /**
     * @warning No result return.
     * @attention But if there is any error on database query, JSON error message will be saved and displayed to client.
     * @param $cond
     * @return void
     */
    public function delete( $cond ) {
        if ( empty($cond) ) return ERROR_EMPTY_SQL_CONDITION;
        if ( ! db()->secure_cond( $cond ) ) return ERROR_INSCURE_SQL_CONDITION;
        db()->query(" DELETE FROM {$this->getTable()} WHERE $cond ");
    }





    /**
     * Return number of rows in the table.
     * @param $cond
     * @return int|null
     */
    public function count( $cond ) {
        if ( empty($cond) ) return ERROR_EMPTY_SQL_CONDITION;
        if ( ! db()->secure_cond( $cond ) ) return ERROR_INSCURE_SQL_CONDITION;
        return db()->result("SELECT count(*) FROM {$this->getTable()} WHERE $cond" );
    }

    /**
     * Return total number of records in the table.
     * @return null
     */
    public function countAll() {
        return $this->count( 1 );
    }


    public function encryptPassword( $str ) {
        return password_hash( $str, PASSWORD_DEFAULT );
    }

    /**
     * Returns true if password matches.
     *
     * @param $plain_text_password
     * @param $encrypted_password
     * @return bool
     */
    public function checkPassword( $plain_text_password, $encrypted_password ) {
        return password_verify( $plain_text_password, $encrypted_password );
    }


}
