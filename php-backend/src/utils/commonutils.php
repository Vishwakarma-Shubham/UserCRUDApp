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
    return addslashes($sting);
}

function GetData($key, $error = "", $default = ''){
    
    global $errors;

    $_DATA = json_decode(file_get_contents('php://input'), true);

    if((!isset($_DATA[$key]) || empty($_DATA[$key]))){ 
        if(!empty($default)) return $default;
        $errors[] = $error;
        return false;
    }
    
    return sanitize_string(trim($_DATA[$key]));
}

function API_Response($messsage, $data, $errors = [], $success = true, $code = 200){

    header('Content-Type: application/json');
    http_response_code($code);

    $response = [
        'success' => $success,
        'messsage' => $messsage,
        'errors' => $errors,
    ];

    if(!$success) {
        die(json_encode(value: $response));
    }
    
    $response['data'] = $data;
    die(json_encode(value: $response));
}