<?php



class Database extends \PDO {

    private static $db = null;
    private static $db_reset = null;
    private $work_table = null; // remember last create table
    public $type = null;

    public function __construct($dsn=null, $username=null, $password=null) {

        if ( empty($dsn) ) return;

        try {
            parent::__construct($dsn, $username, $password);
        }
        catch (\PDOException $e) {
            echo "<h1>Database Connection Error</h1>";
            echo $e->getMessage();
            echo "
            <ul>
            <li>dsn:$dsn</li>
            <li>username:$username</li>
            <li>password:$password</li>
            <li>Check database configuration file if it has correct information</li>
            </ul>
            ";
            throw new \Exception('Connection failed.');
        }
    }


    public static function mysql($host, $dbname, $username, $password) {
        $db = new Database("mysql:host=$host;dbname=$dbname", $username, $password);
        $db->type = 'mysql';
        $db->setOptions();
        return $db;
    }

    public static function sqlite($path) {
        $db = new Database("sqlite:$path");
        $db->type = 'sqlite';
        $db->setOptions();
        return $db;
    }



    /**
     * Sets PDO Options
     */
    private function setOptions()
    {
        try
        {
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (\PDOException $e)
        {
            die($e->getMessage());
        }
    }

    /**
     *
     * @Attention It only creates a single object and re-use it.
     *
     * @return bool|null|Database
     */
    public static function load()
    {
        if ( self::$db ) return self::$db;


        if ( DATABASE_TYPE == 'sqlite' ) {
            return self::$db = Database::sqlite( DIR_DATA . '/' . DATABASE_NAME . '.sqlite');
        }
        else if ( DATABASE_TYPE == 'mysql' ) {
            return self::$db = Database::mysql(
                DATABASE_HOST,
                DATABASE_NAME,
                DATABASE_USER,
                DATABASE_PASSWORD
            );
        }
        else {



            echo"\n" .  __METHOD__ . '<hr>';
            echo "\nERROR: What is databsase type? : " . DATABASE_TYPE;
            echo "<pre>";
            debug_print_backtrace();
            echo "</pre>";
            exit;
        }
    }

    /**
     * @param $field
     * @return string
     */
    private static function escapeField($field)
    {
        if ( strpos($field,'*') !== false ) return $field;
        else if ( strpos($field, ',') ) return $field;
        else if ( strpos($field, '.') ) return $field;
        else if ( strpos($field, '(') !== false ) return $field;
        else return "`$field`";
    }

    /**
     * @param null $work_table
     * @return $this|null - If $work_table is null, then it returns a string with table name.
     *
     * - If $create_table is null, then it returns a string with table name.
     *
     * - If $create_table is not null, then it returns $this.
     *
     */
    public function table($work_table=null) {
        if ( $work_table ) {
            $this->work_table= $work_table;
            return $this;
        }
        else return $this->work_table;
    }


    /**
     * @param $table
     * @return Database
     */
    public function createTable($table) {
        $this->table($table);
        if ( DATABASE_TYPE == 'mysql' ) {
            $q = "CREATE TABLE $table (idx INT) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;";
            $this->exec($q);
            $this->addPrimaryKey($table, 'idx');
            $this->addAutoIncrement($table, 'idx');
        }
        else if ( DATABASE_TYPE == 'sqlite' ) {
            $q = "CREATE TABLE $table (idx INTEGER PRIMARY KEY);";
            $this->exec($q);
        }

        $this->add('created', 'INT UNSIGNED DEFAULT 0');
        $this->add('updated', 'INT UNSIGNED DEFAULT 0');
        $this->index('created');
        $this->index('updated');


        return $this;
    }

    /**
     * @param $name
     * @return \Database
     */
    public function dropTable($name)
    {
        $q = "DROP TABLE IF EXISTS $name;";
        $this->exec($q);
        return $this;
    }



    public function add($column, $type, $size=0)  {
        $table = $this->table();
        return $this->addColumn($table, $column, $type, $size);
    }
    public function addColumn($table, $column, $type, $size=0)
    {
        if ( empty($size) ) {
            if ( $type == 'varchar' ) $size = 255;
            else if ( $type == 'char' ) $size = 1;
        }
        if ( stripos($type, 'float') !== false ) {
            if ( DATABASE_TYPE == 'sqlite' ) $type = str_ireplace('float', 'real', $type);
        }
        if ( stripos($type, 'double') !== false ) {
            if ( DATABASE_TYPE == 'sqlite' ) $type = str_ireplace('double', 'real', $type);
        }
        if ( stripos($type, 'LONGTEXT') !== false ) {
            if ( DATABASE_TYPE == 'sqlite' ) {
                $type = str_ireplace('LONGTEXT', 'TEXT', $type);
            }
        }

        if ( $size ) $type = "$type($size)";
        $q = "ALTER TABLE `$table` ADD COLUMN `$column` $type";
        $this->exec($q);
        return $this;
    }


    public function log($q) {
        debug_log($q);
    }


    public function query ($q, $mode = PDO::ATTR_DEFAULT_FETCH_MODE, $arg3 = null, array $ctorargs = array()) {

        $this->log($q);


            return parent::query($q);

    }

    public function exec($q) {
        $this->log($q);

        return parent::exec($q);


    }


    /**
     * @param $table
     * @param $column
     * @return $this|bool
     *
     * @Attention - You cannot delete a column with SQLite.
     */
    public function deleteColumn($table, $column) {

        if ( DATABASE_TYPE == 'mysql' ) {
            $q = "ALTER TABLE $table DROP $column";
            $this->exec($q);
            return $this;
        }
        else if ( DATABASE_TYPE == 'sqlite' ) {
            // You can not delete a column in SQLite
            return FALSE;
        }

    }


    /**
     * Adds primary key on the table
     *
     * @param $table
     * @param $fields
     * @return $this
     *
     * @code
     *  $this->addPrimaryKey($name, 'idx');
     *  $this->addPrimaryKey($name, 'idx,name'); // can be two column.
     * @endcode
     */
    public function addPrimaryKey($table, $fields)
    {
        if ( DATABASE_TYPE == 'mysql' ) {
            $q = "ALTER TABLE $table ADD PRIMARY KEY ($fields)";
            $this->exec($q);
            return $this;
        }
        else if ( DATABASE_TYPE == 'sqlite' ) {
            // you alter add primary key in sqlite
            return $this;
        }

    }


    public function unique($fields) {
        return $this->addUniqueKey($this->table(), $fields);
    }
    public function addUniqueKey($table, $fields)
    {
        if ( DATABASE_TYPE == 'mysql' ) {
            $q = "ALTER TABLE $table ADD UNIQUE KEY ($fields)";
            $this->exec($q);
            return $this;
        }
        else if ( DATABASE_TYPE == 'sqlite' ) {
            $index_name = str_replace(',', '_', $fields);
            $q = "CREATE UNIQUE INDEX {$table}_$index_name ON $table ($fields);";
            $this->exec($q);
            return $this;
        }

    }

    public function index($fields) {
        return $this->addIndex($this->table(), $fields);
    }
    public function addIndex($table, $fields) {

        if ( DATABASE_TYPE == 'mysql' ) {
            $q = "ALTER TABLE $table ADD INDEX ($fields)";
        }
        else if ( DATABASE_TYPE == 'sqlite' ) {
            $index_name = str_replace(',', '_', $fields);
            $q = "CREATE INDEX {$table}_$index_name ON $table ($fields);";

        }

        $this->exec($q);
        return $this;

    }



    public function addAutoIncrement($table, $field) {
        if ( DATABASE_TYPE == 'mysql' ) {
            $q = "ALTER TABLE `$table` MODIFY COLUMN `$field` INT AUTO_INCREMENT;";
        }
        else {
            $q = "ALTER TABLE `$table` MODIFY COLUMN `$field` INT AUTO_INCREMENT;";
        }
        $this->exec($q);
        return $this;
    }


    /**
     *
     * Returns the first element of the first row.
     *
     * @param $q
     * @return mixed
     * @code
     *      echo $db->result('sms_numbers'); // return the first element of the first row in the table
     *      echo $db->result('sms_numbers', 'count(*)'); // return the number of record of the table
     *      echo $db->result('sms_numbers', 'count(*)', 'idx >= 123');
     *      echo $db->result('sms_numbers', 'idx, stamp_last_sent', 'idx >= 123'); // return 123
     * @endcode
     */
    public function result( $q ) {
        $row = $this->row( $q );
        if ( $row ) {
            foreach( $row as $k => $v ) {
                return $v;
            }
        }
        return null;
    }




    /**
     *
     *
     * @param $q
     * @return mixed
     *
     * @code
     *      $row = $this->row($this->table()); // returns the first row
     *      $row = $db->row('temp', "name='JaeHo Song'");
     *      $row = $db->row('temp', db_and()->condition('name','JaeHo Song'));
     *      $row = $db->row('temp', db_cond('name','JaeHo Song'));
     * @endcode
     *
     * @Attention it returns false if there is no data.
     */
    public function row($q)
    {
        $re = $this->rows( $q );
        if ( $re && isset($re[0]) ) return $re[0];
        return FALSE;
    }


    /**
     * @param $q
     * @return array|int
     */
    public function rows( $q )
    {

        if ( stripos( $q, 'WHERE ') ) {
            list ( $trash, $where ) = explode( 'where', strtolower( $q ) );
            if ( ! $this->secure_cond( $where ) ) return ERROR_INSCURE_SQL_CONDITION;
        }

        $statement = $this->query($q);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);

    }


    /**
     * @param $table
     * @param array $keys_and_values
     * @return string
     *
     * @Attention When a value of a string is longer than then field character limit, it will cut off the last part of the string.
     *      - This is the nature of PDO.
     */
    public function insert($table, array $keys_and_values)
    {
        $key_list = [];
        $value_list = [];
        foreach($keys_and_values as $k => $v ) {
            $key_list[] = "`$k`";

            if ( $v === NULL ) {
                $value_list[] = "NULL";
            }
            else {
                $value_list[] = $this->quote($v);
            }
        }
        $keys = implode(",", $key_list);
        $values = implode(",", $value_list);
        $q = "INSERT INTO `{$table}` ({$keys}) VALUES ({$values})";
        $count = $this->exec($q);
        if ( $count == 0 ) {
            return FALSE;
        }
        else {

        }
        $insert_id = $this->lastInsertId();
        return $insert_id;
    }

    /**
     * @param $table
     * @param $fields
     * @param int $cond
     * @return \PDOStatement|bool
     *
     *      - ERROR_INSCURE_SQL_CONDITION on condition error.
     */
    public function update($table, $fields, $cond=null)
    {


        if ( ! $this->secure_cond( $cond ) ) return ERROR_INSCURE_SQL_CONDITION;

        $sets = [];
        foreach($fields as $k => $v) {
            $sets[] = "`$k`=" . $this->quote($v);
        }
        $set = implode(", ", $sets);
        $where = null;
        if ( $cond ) $where = "WHERE $cond";
        $q = "UPDATE $table SET $set $where";
        $statement = $this->query($q);
        return $statement;
    }


    /**
     * @param $table
     * @param $cond
     * @return int
     */
    public function delete($table, $cond)
    {
        $q = "DELETE FROM $table WHERE $cond";
        $statement = $this->query($q);
        return OK;
    }



    /**
     * @param $field
     * @return bool
     *  - TRUE if the key exists on the table
     *
     * @code
     *      Database::load()->columnExists('temp', 'idx')
     * @endcode
     */
    public function columnExists($table, $field=null) {
        if ( empty($field) ) {
            $field = $table;
            $table = $this->table();
        }
        try {
            $this->query("SELECT $field FROM $table LIMIT 1");
            return TRUE;
        }
        catch(\PDOException $e) {
            return FALSE;
        }
    }
    public function tableExists($table) {
        try {
            $this->query("SELECT * FROM $table");
            return TRUE;
        }
        catch(\PDOException $e) {
            return FALSE;
        }
    }


    /*
    private function adjustCondition($cond)
    {
        if ( $cond === null ) $cond = null;
        else {
            $cond = trim($cond);
            if ( stripos($cond, 'ORDER') === 0 || stripos($cond, 'GROUP') === 0 || stripos($cond, 'LIMIT') === 0 ) {

            }
            else {
                $cond = "WHERE $cond";
            }
        }
        return $cond;
    }
    */

    public function reset()
    {
        Database::$db_reset = Database::$db;
        Database::$db = $this;
    }

    public function restore()
    {
        Database::$db = Database::$db_reset;
    }



    public function secure_cond( $cond ) {
        $secure = true;
        if ( stripos( $cond, ';' ) !== false ) $secure = false;
        if ( stripos( $cond, 'SELECT ') !== false ) $secure = false;
        if ( stripos( $cond, 'replace ') !== false ) $secure = false;
        if ( stripos( $cond, 'UPDATE ') !== false ) $secure = false;
        if ( stripos( $cond, 'DELETE ') !== false ) $secure = false;
        if ( $secure === false ) error( ERROR_INSCURE_SQL_CONDITION );

        return $secure;
    }


}


/**
 * @return \Database
 */
function db() {
    return Database::load();
}
