<?php

// Init Dependency injuction
$GLOBALS['DI'] = $DI = new SDI();

// For Router Configuration
$router['startup'] = "welcome";

// For Autoload Libraries;
$autoload['library'] = array();

// For Databae Configuration
$GLOBALS['setting'] = [

    'startup'  => "welcome",

    //  Database Configuration
    'db'       => [
        'host'     => 'localhost',
        'username' => 'admin',
        'password' => 'admin300',
        'dbname'   => 'gamekade',
    ],

    'site'     => [
        'name'         => "New Structure",
        'description'  => "This is a Full featured Student Planning System", // This description for landing page;
        'date_of_init' => "2016-08-22",
        'author'       => "Webhash Developmet",

    ],

    'security' => [
        'autho_req'        => false,
        'controller'       => "welcome",
        'login_controller' => "site",
    ],

];

// Database Connection with DI
$DI->db = function () {
    $db    = $GLOBALS['setting']['db'];
    $mysql = new Database_Mysql($db);
    return $mysql;

};

// Twig Template engine configuration with DI
$DI->view = function () {
    $loader = new Twig_Loader_Filesystem('application/view');
    $twig   = new Twig_Environment($loader);
    return $twig;
};

if (!isset($_SESSION['login_status'])) {
    $_SESSION['login_status'] = false;
}
