<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//Setup the PATH Path

$filePath = $_SERVER['SCRIPT_NAME'];
$base = "/" . basename($filePath);
$filePath = str_replace($base, "", $filePath);

define("BASE_PATH", $filePath); //For Sever Path
define("APP_PATH", BASE_PATH . "/application");
define("SYS_PATH", BASE_PATH . "/system");

//For system and application library folders
define("APP_LIB_PATH", APP_PATH . "/library/");
define("SYS_LIB_PATH", SYS_PATH . "/library/");

define("CTR_ROOT", "application/controller/");
define("MOD_ROOT", "application/model/");

define("VIEW_PATH", APP_PATH . '/view/'); //For View Path
define("ASSETS_PATH", VIEW_PATH . 'assets/'); //For View Path
define("CSS_PATH", ASSETS_PATH . "css/"); //For css Path
define("JS_PATH", ASSETS_PATH . "js/"); //For js Path
define("IMAGE_PATH", ASSETS_PATH . "img/"); // For image Path
define("UPLOAD_PATH", APP_PATH . "/upload/"); // For Upload Path
?>
