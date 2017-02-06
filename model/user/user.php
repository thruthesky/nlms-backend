<?php
/**
 *
 */

class User {


    /**
     * Returns user record.
     * @param $idx
     * @return array|null
     */
    public function load( $idx ) {
        if ( is_numeric($idx) ) $where = "idx=$idx";
        else $where = "id='$idx'";
        return db()->get_row("SELECT * FROM user WHERE $where");
    }
}