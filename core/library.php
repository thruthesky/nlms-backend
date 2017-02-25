<?php

namespace core;

class library {


    /**
     *
     * Returns model, class, method.
     *
     * @return array|null
     */
    public final static function mcm() {
        if ( in('mc') ) {
            return explode('.', in('mc') );
        }
        else return null;
    }

    public final static function script() {
        $mcm = self::mcm();
        if ( $mcm && isset( $mcm[1])) return "../model/$mcm[0]/$mcm[1].php";
        else return null;
    }




    /**
     * Returns class name.
     * @return null|string
     */
    public final static function script_model() {
        if ( $mcm = self::mcm() ) {
            return $mcm[0];
        }
        return null;
    }




    /**
     * Returns class name.
     * @return null|string
     */
    public final static function script_class() {
        if ( $mcm = self::mcm() ) {
            return $mcm[1];
        }
        return null;
    }



    public final static function script_method() {
        if ( $mcm = self::mcm() ) {
            if ( isset($mcm[2]) && $mcm[2] ) return $mcm[2];
            else return null;
        }
        return null;
    }



    public final static function model_class_path()
    {
        $model = self::script_model();
        $class = self::script_class();
        return "model\\$model\\$class";
    }

    /**
     * @see readme
     * @return string
     */
    public static function model_model_class_path()
    {

        $model = self::script_model();
        return "model\\$model\\$model";
    }


}
