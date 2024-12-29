<?php

if(!defined("UserCRUDApp")){
    die("something's fishy");
}

require_once $globals['models'].'/User.php';

class UserController {
    private $user;

    private $messages = [
        'users_list' => 'Users List',
        'user_details' => 'Users Details',
        'err_get_users' => 'Error in getting user List',
        'err_get_user' => 'Error in getting user details',
        'user_created' => 'User Created Successfully',
        'user_updated' => 'User Updated Successfully',
        'user_deleted' => 'User Deleted Successfully',
        'err_user_delete' => 'Failed to delete the user',
        'err_user_update' => 'Failed to update the user',
        'mandatory_fields_missing' => 'User Mandatory fields Missing', 
        'no_name' => 'Please provide Name',
        'no_email' => 'Please provide Email Address',
        'no_pass' => 'Please provide Password',
        'no_dob' => 'Please provide DOB',
        'err_user_details' => 'Error in user details',
        'err_user_exsits' => 'User Already Exsits',
        'err_user_creation' => 'Error in user Creation',
    ];

    private $error_messages = [
        0 => 'No users Found',
        1 => 'Please provide a valid user id',
        2 => 'NO user found with the given user id',
        3 => 'There was some error in deleting the user',
        4 => 'Invalid Name Provided',
        5 => 'Invalid Email Address Provided',
        6 => 'Invalid Dob Provided',
        7 => 'Date of birth cannot be in the future.',
        8 => 'Age must be above 18',
        9 => 'User with given email ID already exsits',
        10 => 'Password must be at least 8 characters'
    ];

    public function __construct() {
        $this->user = new User();
    }

    public function getUsers(){
        $users = $this->user->getUsers();

        if(empty($users)) {
            API_Response($this->messages['err_get_users'],[],$this->error_messages[0]);
        }
        
        API_Response($this->messages['users_list'], $users);

    }

    public function getUser($id) {

        $id = (int) $id;

        if($id < 1) {
            API_Response($this->messages['err_get_user'],[], $this->error_messages[1]);
        }

        $userById = $this->user->getUserById($id);

        if(empty($userById)){
            API_Response($this->messages['err_get_users'],[], $this->error_messages[2], true, 404);
        }
        
        API_Response($this->messages['user_details'], $userById);
    }

    public function addUser() {

        global $errors;

        $new_user = [];

        $new_user['name'] = GetData('name', $this->messages['no_name']);
        $new_user['email'] = GetData('email', $this->messages['no_email']);
        $new_user['password'] = GetData('password', $this->messages['no_pass']);
        $new_user['dob'] = GetData('dob', $this->messages['no_dob']);


        if(!empty($errors)){
            API_Response($this->messages['mandatory_fields_missing'],[], $errors, false);
        }

        if (!preg_match('/^[A-Za-z ]+$/', $new_user['name'])) {
            $errors[] = $this->error_messages[4];
        }

        if(!filter_var($new_user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = $this->error_messages[5];
        }

        if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $new_user['dob'])){
            $errors[] = $this->error_messages[6];
        } else {

            $dob_date = DateTime::createFromFormat('Y-m-d', $new_user['dob']);
            $current_date = new DateTime();
        
            if (!$dob_date || $dob_date->format('Y-m-d') !== $new_user['dob']) {
                $errors[] = $this->error_messages[6];
            } else {

                if ($dob_date > $current_date) {
                    $errors[] = $this->error_messages[7]; // DOb can't be in future
                } else {
                    // Calculate the age
                    $age = $dob_date->diff($current_date)->y;
                    if ($age < 18 ){
                        $errors[] = $this->error_messages[8];
                    }
                }
            }
        }

        if(!empty($errors)){
            API_Response($this->messages['err_user_details'],[], $errors, false);
        }

        $userByEmail = $this->user->getUserByEmail($new_user['email'], 0);

        if(!empty($userByEmail)){
            API_Response($this->messages['err_user_exsits'],[], $this->error_messages[9], false);
        }

        $new_user['name'] = preg_replace('/\s+/', ' ', $new_user['name']);
        $new_user['password'] = password_hash($new_user['password'], PASSWORD_BCRYPT);

        if(strlen($new_user['password']) < 8){
            API_Response($this->messages['err_user_details'],[], $this->error_messages[10], false);
        }

        $insertedID = $this->user->addUser($new_user);id: 
        $userById = $this->user->getUserById($insertedID);
        

        if(empty($userById)){
            API_Response($this->messages['err_user_creation'],[], [], false);
        }

        API_Response($this->messages['user_created'], data: $userById);
    }

    public function updateUser($id) {

        global $errors;

        $id = (int) $id;

        if($id < 1) {
            API_Response($this->messages['err_user_update'],[], $this->error_messages[1]);
        }

        $userById = $this->user->getUserById($id);

        if(empty($userById)){
            API_Response($this->messages['err_user_update'],[], $this->error_messages[2], true, 404);
        }
        
        $update_user = [];

        $update_user['name'] = GetData('name', $this->messages['no_name'], $userById['name']);
        $update_user['email'] = GetData('email', $this->messages['no_email'], $userById['email']);
        $update_user['dob'] = GetData('dob', $this->messages['no_dob'], $userById['dob']);


        if (!preg_match('/^[A-Za-z ]+$/', $update_user['name'])) {
            $errors[] = $this->error_messages[4];
        }

        if(!filter_var($update_user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = $this->error_messages[5];
        }

        if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $update_user['dob'])){
            $errors[] = $this->error_messages[6];
        } else {

            $dob_date = DateTime::createFromFormat('Y-m-d', $update_user['dob']);
            $current_date = new DateTime();
        
            if (!$dob_date || $dob_date->format('Y-m-d') !== $update_user['dob']) {
                $errors[] = $this->error_messages[6];
            } else {

                if ($dob_date > $current_date) {
                    $errors[] = $this->error_messages[7]; // DOb can't be in future
                } else {
                    // Calculate the age
                    $age = $dob_date->diff($current_date)->y;
                    if ($age < 18 ){
                        $errors[] = $this->error_messages[8];
                    }
                }
            }
        }

        if(!empty($errors)){
            API_Response($this->messages['err_user_details'],[], $errors, false);
        }

        $userByEmail = $this->user->getUserByEmail($update_user['email'], $id);

        if(!empty($userByEmail)){
            API_Response($this->messages['err_user_exsits'],[], $this->error_messages[9], false);
        }

        $update_user['name'] = preg_replace('/\s+/', ' ', $update_user['name']);

        $update_user['password'] = '';
        if(array_key_exists('password', $_POST) && !empty($_POST['password'])){
            $update_user['password'] = GetData('password');

            if(strlen($update_user['password']) < 8){
                API_Response($this->messages['err_user_details'],[], $this->error_messages[10], false);
            }
            
            $update_user['password'] = password_hash($update_user['password'], PASSWORD_BCRYPT);
        }

        $this->user->updateUser($id, $update_user);

        $userById = $this->user->getUserById($id);

        API_Response($this->messages['user_updated'], data: $userById);
    }

    public function deleteUser($id) {

        $id = (int) $id;

        if($id < 1) {
            API_Response($this->messages['err_user_delete'],[], $this->error_messages[1]);
        }

        $userById = $this->user->getUserById($id);

        if(empty($userById)){
            API_Response($this->messages['err_user_delete'],[], $this->error_messages[2], true, 404);
        }

        $result = $this->user->deleteUser($id);

        if (!$result) {
            API_Response($this->messages['err_user_delete'],[], $this->error_messages[3]);
        }

        API_Response($this->messages['user_deleted'], []);

    }
}
