<?php

if(!defined("UserCRUDApp")){
    die("something's fishy");
}

$config = [
    
    'db_user' => 'root', // Databse Username
    'db_password' => 'root', // Database Password

    // DB connection params
    'database' => [
        'host' => 'localhost', // Everthing Works on local
        'port' => 3306,
        'dbname' => 'user_crud_app',
        'charset' => 'utf8mb4',
    ],


    'log_dir' => '/tmp/UserCRUDApp'
];
