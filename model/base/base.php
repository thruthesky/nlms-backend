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
    protected function getTable() {
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
        $this->record = db()->get_row("SELECT * FROM {$this->getTable()} WHERE $where", ARRAY_A);
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
            $this->delete( 'idx=' . $this->record['idx'] );
        }
        $this->record = [];

    }



    /**
     *
     * This creates a record into a table.
     * @note this always returns success. If there is an error, it does not return. it just stop.
     * @param $kvs
     *
     *
     * @return number - same as parent::insert()
     *
     *
     *
     */
    public function create( $kvs ) {
        return db()->insert( $this->getTable(), $kvs );
        /*
        if ( empty($idx) ) error(ERROR_DATABASE_INSERT_FAILED);
        return $idx;
        */
    }


    /**
     * @param $kvs
     *
     * @warning No return value.
     */
    public function update( $kvs ) {
        if ( $this->record && isset( $this->record['idx'] ) ) {
            db()->update( $this->getTable(), $kvs, "idx={$this->record['idx']}");
        }
    }


    /**
     * @warning No result return.
     * @attention But if there is any error on database query, JSON error message will be saved and displayed to client.
     * @param $cond
     * @return void
     */
    public function delete( $cond ) {
        if ( empty($cond) ) return;
        db()->query(" DELETE FROM {$this->getTable()} WHERE $cond ");
    }


    /**
     * Return number of rows in the table.
     * @param $cond
     * @return int|null
     */
    public function count( $cond ) {
        if ( empty($cond) ) return ERROR_EMPTY_SQL_CONDITION;
        return db()->get_var("SELECT count(*) FROM {$this->getTable()} WHERE $cond" );
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


    /**
     *
     * Saves a meta data.
     *
     * @warning if there is an error on saving meta data, it stops the script with json error.
     *
     * @param $code
     * @param $data
     *
     *
     * @return mixed - on error it stops with json error.
     *              - idx of meta record on success.
     */
    public function saveMeta( $code, $data ) {
        if ( ! $this->isRecordSet() ) error( ERROR_RECORD_NOT_SET );
        debug_log("Base::saveMetas( $code, $data )");
        $kvs = [
            'model' => $this->getTable(),
            'model_idx' => $this->record['idx'],
            'code' => $code,
            'data' => $data
        ];
        $idx = db()->insert( 'meta', $kvs );
        if ( empty($idx) ) error(ERROR_DATABASE_INSERT_FAILED);
        return $idx;
    }

    /**
     *
     *
     * Saves an array of meta data.
     *
     * @attention It does not stop the script even if there is an error ( insdie the self ). It may stop the script if there is an error in a child method( deeper method )
     *
     * @see readme
     * @param array $arr
     *
     *
     * @return bool
     *      - true on success
     *      - false on failure.
     *
     */
    public function saveMetas( $arr ) {
        if ( ! $this->isRecordSet() ) return false;
	if ( empty( $arr ) ) return false;
        debug_log("Base::saveMetas()");
        debug_log($arr);
        if ( ! is_array( $arr ) ) {
            debug_log("saveMetas() arr is not an array");
            return false;
        }
        foreach ( $arr as $code => $data ) {
            $this->saveMeta( $code, $data );
        }
        return true;
    }


    /**
     * Returns the meta data of the code.
     *
     * @warning if there is more than one code, it is unsure which data among the code will be returned.
     *      So, keep it unique if you need.
     *
     * @param $code
     * @return mixed
     *  null - if $record is not set or there is no data.
     */
    public function getMeta( $code ) {
        if ( ! $this->isRecordSet() ) return null;
        $model = $this->getTable();
        $model_idx = $this->record['idx'];
        debug_log("SELECT * FROM meta WHERE model='$model' AND model_idx=$model_idx AND code='$code'");
        $row = db()->get_row("SELECT * FROM meta WHERE model='$model' AND model_idx=$model_idx AND code='$code'", ARRAY_A);
        if ( empty($row) ) return null;
        return $row['data'];
    }


    /**
     * Returns all the metas of the model and its idx.
     *
     * @return mixed
     *  null - if $record is not set or there is no data.
     */
    public function getMetas() {

        if ( ! $this->isRecordSet() ) return null;
        $model = $this->getTable();
        $model_idx = $this->record['idx'];
        $rows = db()->get_results("SELECT code, data FROM meta WHERE model='$model' AND model_idx=$model_idx", ARRAY_A);
        if ( empty($rows) ) return null;

        return $rows;
    }

    /**
     * @warning there is no return value.
     * @param $code
     */
    public function deleteMata( $code ) {
        if ( ! $this->isRecordSet() ) return;
        $model = $this->getTable();
        $model_idx = $this->record['idx'];
        db()->query("DELETE FROM meta WHERE model = $model AND modex_idx = $model_idx AND code = '$code'");
    }


    /**
     * Delete meta data of the 'model' & 'model_idx'
     *
     * @warning there is no return data.
     */
    public function deleteMetas() {

        if ( ! $this->isRecordSet() ) return;
        $model = $this->getTable();
        $model_idx = $this->record['idx'];
        db()->query("DELETE FROM meta WHERE model = $model AND modex_idx = $model_idx");

    }
}
