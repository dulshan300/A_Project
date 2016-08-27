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
function sys_autoload($classname) {     
    $loaded = false;
    
    // Lookup paths
    $paths = array(
        "system/library/",
        "system/core/",
        "application/library/",
        "application/controller/",
        "application/model/",
        "application/library/"
    );
    
    foreach($paths as $path){
    
        if (file_exists($path.$classname.".php")) {
            require_once $path.$classname.".php";
            $loaded = true;
        } 
    }
    
    if(!$loaded){
        throw new ClassNotFound_Exception("Class <u>$classname</u> not found");
    }
}

function vendor_autoload(){
    require_once 'system/library/vendor/autoload.php';
}

spl_autoload_register('vendor_autoload');
spl_autoload_register('sys_autoload');
