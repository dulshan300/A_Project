<?php

/**
 * CodeDlab
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeDlab
 * @author		CodeDlab Dev A.G.D.Madusanka
 * @copyright	Copyright (c) 2012 - 2013, DLab, Digital X Design.
 * @since		Version 1.0
 * 
 */
class Register {

    private static $instances = array();

    public static function __autoload() {
        global $autoload;
        foreach ($autoload['library'] as $lib) {
            $obj = ucfirst($lib);
            if (class_exists($obj)) {
                self::set($lib, new $obj);
            } else {
                throw new ClassNotFound_Exception("Library $obj not found at Framwork");
            }
        }
    }

    public function __clone() {
        
    }

    public static function get($key, $default = FALSE) {
        if (isset(self::$instances[$key])) {
            return self::$instances[$key];
        } else {
                      
            self::set($key,new $key);
            return self::$instances[$key];           
        }
    }

    public static function set($key, $instance) {
        self::$instances[$key] = $instance;
    }

    public static function have($key) {
        if (isset(self::$instances[$key])) {
            return true;
        }
        return false;
    }

}

?>