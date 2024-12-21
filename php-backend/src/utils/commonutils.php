<?php

if(!defined("UserCRUDApp")){
    die("something's fishy");
}

function r_print($data){
    echo '<pre>';
    var_export($data);
    echo '</pre>';
}

function sanitize_string($sting){
    return addslashes(stripslashes($sting));
}

///////////////////////
// Get & Post
//////////////////////

function GET($key, $default = ''){

    if(!isset($_GET[$key]) || empty($_GET[$key])) {
        return $default;
    }

    return sanitize_string(trim($_GET[$key]));
}

function POST($key, $error = "", $default = ''){
    
    global $errors;

    if((!isset($_POST[$key]) || empty($_POST[$key]))){
        if(!empty($default)) return $default;
        $errors[] = $error;
        return false;
    }
    
    return sanitize_string(trim($_POST[$key]));
}

function API_Response($data, $code = 200){

    http_response_code($code);
    die(json_encode($data));
}