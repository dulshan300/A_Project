<?php

/**
 * CodeDlab
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeDlab
 * @author		CodeDlab Dev A.G.D.Madusanka.
 * @copyright	Copyright (c) 2012 - 2013, DLab, Digital X Design.
 * @since		Version 1.0
 * 
 */
class Form {

    private $out = "";

    function __construct($id, $action, $method, $class = "") {
        $this->out.="<form id='$id' " . $this->have_class($class) . " action='$action' method='$method' >";
    }

    function have_class($class) {
        if (strlen($class) > 0) {
            return "class = '$class'";
        }
        return "";
    }

    function add_textbox($id, $type) {
        $this->out.= "<input type='$type' name = '$id'/>";
    }

    function view() {
        $this->out.="</form>";
        return $this->out;
    }

}

?>
