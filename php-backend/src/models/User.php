<?php

if(!defined("UserCRUDApp")){
    die("something's fishy");
}

class User {
    private $db;
    private $table = 'users';

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    /**
    * Fetch all users.
    */
    public function getUsers(){
        $query = "SELECT * FROM {$this->table}";
        
        $res = $this->db->querry($query);

        return $this->db->fetch_assoc_all($res);
    }

    /**
    * Fetch a single user by ID.
    */
    public function getUserById($id) {
        $query = "SELECT * FROM {$this->table} WHERE `id` = :id";
        $res = $this->db->querry($query , [':id' => $id]);
        return $this->db->fetch_assoc($res);
    }


    /**
    * Fetch a single user by email.
    */
    public function getUserByEmail($email, $id) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email AND id != :id";
        $res = $this->db->querry($query , [':email' => $email, ':id' => $id]);
        return $this->db->fetch_assoc($res);
    }

    /**
    * Create a new user.
    */
    public function addUser($user_data)    {
        
        $query = "INSERT INTO {$this->table} SET `name` = :name, `email` = :email, `password` = :password, `dob` = :dob";
        
        $this->db->querry($query , [
            ':name' => $user_data['name'],
            ':email' => $user_data['email'],
            ':password' => $user_data['password'],
            ':dob' => $user_data['dob']
        ]);

        return $this->db->get_last_inserted_id();
    }

    /**
    * Update an existing user.
    */
    public function updateUser($id, $user_data)    {
        $query = "UPDATE {$this->table} SET `name` = :name, `email` = :email, `dob` = :dob WHERE `id` = :id";
        
        $this->db->querry($query , [
            ':id' => $id,
            ':name' => $user_data['name'],
            ':email' => $user_data['email'],
            ':dob' => $user_data['dob']
        ]);

        // Update the password at last
        if(!empty($user_data['password'])){
            $query = "UPDATE {$this->table} SET `password` = :password WHERE `id` = :id";
            $this->db->querry($query, [
                ':id' => $id,
                ':password' => $user_data['password']
            ]);
        }

    }

    /**
     * Delete a user.
     */
    public function deleteUser($id){
        
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        return $this->db->querry($query, [':id' => $id]);

    }

}
