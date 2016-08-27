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
class ClassInspector {

    private static $instent;
    private $ctr_root = "application/controller/";

    public static function get_singolton() {
        if (empty(self::$instent)) {
            $obj = __CLASS__;
            self::$instent = new $obj;
        }
        return self::$instent;
    }

    public function execute($class, $method = "", $para = "") {
	$class = ucfirst($class);
        if (class_exists($class)) {
            $obj = $class;
            $controll = new $obj();
            if (empty($method)) {
                $controll->index();
            } else {
                if (method_exists($controll, $method)) {
                    $met = new ReflectionMethod(ucfirst($class), $method);
                    $arg = $met->getNumberOfRequiredParameters();

                    if ($arg > 0 && !empty($para)) {
                        if ($arg <= count($para)) {
                            $met->invokeArgs($controll, $para);
                        } else {
                            throw new MethodArg_Exception("Require $arg arguments : found " . count($para));
                        }
                    } elseif ($arg == 0) {
                        $met->invoke($controll, $method);
                    } else {
                        throw new MethodArg_Exception("Require $arg arguments");
                    }
                } else {
                    throw new MethodNotFound_Exception("Method '$method' not found on Controll '$obj'");
                }
            }
        } else {
            throw new ControllerNotFound_Exception("Controller '{$class}' Not found");
        }
    }

}

?>