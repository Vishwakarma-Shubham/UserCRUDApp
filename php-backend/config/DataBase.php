<?php

if(!defined("UserCRUDApp")){
    die("something's fishy");
}

class DataBase {

    public $conn = null;

    public $error = '';

    private $error_messages = [
        0 => 'Missing database configuration',
        1 => 'There was some error in connection with the DataBase!',
        2 => 'An unexpected error occurred',
        3 => 'Database connection not established. Please check the configuration'
    ];

    private $MandatoryFields = ['host', 'port', 'dbname', 'charset'];

    public function __construct($config, $username = 'root' , $password = ''){

        global $DEBUG;
        
        foreach($this->MandatoryFields as $field){
            if(!isset($config[$field])){
                $this->error = $this->error_messages[0] .' : '.$field;
                return;
            }
            $config[$field] = sanitize_string($config[$field]); 
        }
        
        try {
            
            $dsn = "mysql:".http_build_query($config, '', ';');

            $this->conn = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

        } catch(PDOException $e) {

            $this->error = $DEBUG ? $e->getMessage() : $this->error_messages[1];
            return;
            
        } catch (Exception $e) {

            $this->error = $DEBUG ? $e->getMessage() : $this->error_messages[2];
            return;
        }

        if(!isset($this->conn)){
            $this->error = $this->error_messages[3];
        }

    }

    function querry($querry, $params = []){
    
        $stmt = $this->conn->prepare($querry);
        
        if(!empty($params) && is_array($params)){
            
            foreach($params as $key => $val){
                $stmt->bindValue($key,$val, (is_int($val) ? PDO::PARAM_INT : PDO::PARAM_STR)); 
            }
        }
    
        $stmt->execute();
        return $stmt;
    
    }

    function num_rows($res){
        return $res->rowCount();
    }
    
    function fetch_assoc($res){
        return $res->fetch();
    }

    function fetch_assoc_all($res){
        return $res->fetchAll();
    }

    function get_last_inserted_id(){
        return $this->conn->lastInsertId();
    }

}
