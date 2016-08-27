<?php

/**
 * CodeDlab
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package        CodeDlab
 * @author        CodeDlab Dev A.G.D.Madusanka
 * @copyright    Copyright (c) 2012 - 2013, DLab, Digital X Design.
 * @since        Version 1.0
 *
 */

require 'ClassInspector.php';
require 'register.php';
require 'controller.php';
require 'model.php';
include 'system/helper/globel_functions.php';

$security = $GLOBALS['setting']['security'];

// Create ClassInspactor Object
$inspect = new ClassInspector();

// start the app
if (!isset($_GET['query'])) {
    redirect_to($GLOBALS['setting']['startup'] . "/");
}
// Query like controll/method/pra/pra/
$query_data = explode("/", $_GET['query']);

$controller = "";
$method     = "";
$para       = "";

if (!empty($query_data)) {
    $controller = array_shift($query_data);
    if (!empty($query_data)) {
        $method = array_shift($query_data);
        if (!empty($query_data)) {
            $para = $query_data;
        }
    }
    try {
        Register::__autoload();
        if ($security['autho_req']) {
            if ($controller == $security['controller']) {
                $inspect->execute($controller, "authorize");
            }
        }
        $inspect->execute($controller, $method, $para);
    } catch (Exception $ex) {
        error_page($ex->getMessage());
        exit();
    }
} else {
    error_page();
}
