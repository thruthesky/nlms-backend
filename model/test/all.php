<?php
/**
 * @see README.md
 */

namespace model\test;




class All extends Test {

    public function __construct()
    {


        $this->style();



    }

    public function run() {


        /**
         * Move these code into proper test files.
         */

        //$this->testUser();
        //$this->testUserSearch();
        //$this->testForum();

        /**
         * New way of testing.
         */

        $this->testInstallation();

        $this->testDatabase();



        $files = rsearch( __MODEL_DIR__, '_test.php' );

        foreach ( $files as $file ) {


            $file = str_replace(".php", '', $file);
            $arr = array_reverse( preg_split( "/[\\\\\/]/", $file));

            $path = "model\\$arr[1]\\$arr[0]";


            $obj = new $path();

            if ( method_exists( $obj, 'run' ) ) $obj->run();
        }




        exit;


    }

    private function style() {
        echo <<<EOH
<style>
    body { font-size: 10pt; }
    .error { color: darkred; font-weight: bold; }
    .success { color: #555; }
</style>
EOH;

    }


    private function testInstallation() {
        if ( ! db()->tableExists('user') ) {
            echo "
<h1>Backend is not installed.</h1>
To install access to ?mc=system.install
";
            exit;
        }
    }

    private function testDatabase() {



        db()->createTable( 'abc' );

        test( db()->tableExists('abc'), "abc table exists");
        test( db()->columnExists('abc', 'idx'), "abc.idx exists");

        db()->dropTable( 'abc' );
        test( ! db()->tableExists('abc'), "abc table does not exist");

        //
        db()->update('meta', ['a'=>'b'], '; should be error');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for ;");



        db()->update('meta', ['a'=>'b'], 'select should be error');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for select");


        db()->update('meta', ['a'=>'b'], 'Condition cannot have replace ');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for replace");


        db()->update('meta', ['a'=>'b'], ' update should be error');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for update");


        db()->update('meta', ['a'=>'b'], ' delete should be error');
        $re = $this->result();
        test($re['code'], "SHOULD be SQL Condition Not Secure Error for delete");


        // db()->query("select from where");

    }






}
