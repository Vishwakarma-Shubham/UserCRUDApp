<?php

// Allow CORS headers
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


////////////////////////
// some error handling
////////////////////////

$DEBUG = (array_key_exists('debug', $_GET) && $_GET['debug'] == 1) ? true : false;

if($DEBUG){
    // get the last encountered error
    register_shutdown_function( function ($err) {
        print_r($err);
    }, error_get_last());
}

// Hide errors form the endusers
error_reporting(E_ALL);
ini_set('display_errors', $DEBUG ? 'On' : 'Off');

if(!defined("UserCRUDApp")){
    define("UserCRUDApp",1);
}

// Some global variables 
$errors = [];

// get the app globals and required files
require_once '../src/globals.php';
require_once $globals['uitls'].'/commonutils.php';
require_once $globals['config'].'/config.php';
require_once $globals['config'].'/DataBase.php';

// Get The DB object 
$db = new DataBase($config['database'], $config['db_user'], $config['db_password']);

if(!empty($db->error)){
    API_Response("Eroor in DB", [], $db->error, false, 500);
}

require_once $globals['core'].'/Router.php';




