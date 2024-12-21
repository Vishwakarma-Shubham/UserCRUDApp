<?php

// Allow from any origin
header("Access-Control-Allow-Origin: *");


////////////////////////
// some error handling
////////////////////////

// const DEBUG = (isset($_GET['debug']) && $_GET['debug'] == 1) ? true : false;
const DEBUG = true;

if(DEBUG){
    // get the last encountered error
    register_shutdown_function( function ($err) {
        print_r($err);
    }, error_get_last());
}

// Hide errors form the endusers
error_reporting(E_ALL);
ini_set('display_errors', DEBUG ? 'On' : 'Off');


if(!defined("UserCRUDApp")){
    define("UserCRUDApp",1);
}

// Some global variables 
$errors = [];


// get the app globals and required files
require_once '../src/globals.php';
require_once $globals['uitls'].'/commonutils.php';
require_once $globals['config'].'/config.php';
require_once $globals['config'].'/database.php';

r_print($config);

$db = new DataBase($config['database'], $config['db_user'], $config['db_password']);

if(!empty($db->error)){
    $errors[] = $db->error;
}

// require_once $globals['uitls'].'/commonutils.php';

if(!empty($errors)){
    die(r_print($errors));
}


