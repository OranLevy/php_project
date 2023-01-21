<?php
require_once('database.php');
class User {
    private $user_id;
    private $first_name;
    private $last_name;
    private $password;
    private $survey_answered;
    private $birthday;
    private $email;

    //  General Getter method
    public function __get($property){
        if(property_exists($this, $property)){
            return $this->$property;
        }
    }

    private function has_attribute($attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($attribute, $object_properties);
    }

    private function instantation($user_array){
        foreach ($user_array as $attribute=>$value){
            if($result=$this->has_attribute($attribute)){
                $this->$attribute = $value;
            }
        }
    }

    public function find_user_by_id_password($user_id, $password){
        global $database;
        $error = null;
        $result = $database->query("SELECT * FROM users WHERE user_id ='" . $user_id . "' AND password = '".$password."'");
        if(!$result){
            $error = 'Cannot find the user. Error is:' . $database->get_connection()->error;
        }elseif($result->num_rows>0){
            $found_user = $result->fetch_assoc();
            $this->instantation($found_user);
        }else{
            $error = "Wrong credentials";
        }
        return $error;
    }
    public function find_user_by_id($user_id){
        global $database;
        $error = null;
        $result = $database->query("SELECT * FROM users WHERE user_id ='" . $user_id . "'");
        if(!$result){
            $error = 'Cannot find the user. Error is:' . $database->get_connection()->error;
        }elseif($result->num_rows>0){
            $found_user = $result->fetch_assoc();
            $this->instantation($found_user);
        }else{
            $error = "Cannot find user by this user_id";
        }
        return $error;
    }
    public static function fetch_users(){
        global $database;
        $result = $database->query("SELECT * FROM users");
        $users = null;
        if($result){
            $i = 0;
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $user = new User();
                    $user->instantation($row);
                    $users[$i] = $user;
                    $i += 1;
                }
            }
        }
        return $users;
    }

    public static function add_user($user_id, $first_name, $last_name, $password, $survey_answered, $birthday, $email){
        global $database;
        $error = Array();
        if(strlen($user_id) < 5){
            $error['error_userid'] = 'User ID needs to be at least 5 characters';
        }
        if(strlen($first_name) == 0){
            $error['error_fname'] = 'First name is required.';
        }
        if(strlen($last_name) == 0){
            $error['error_lname'] = 'Last name is required';
        }
        if(strlen($password) == 0){
            $error['error_password'] = 'Password is required';
        }
        if(strlen($birthday) == 0){
            $error['error_birthday'] = 'Birthday is required';
        }
        if(strlen($email) == 0){
            $error['error_email'] = 'Email is required';
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error['error_email'] = 'Email is not valid';
        }
        $enc_password = md5(md5($user_id) . $password);
        if(!$error){
            $sql = "INSERT INTO users (user_id, first_name, last_name ,password, survey_answered, birthday, email) VALUES ('" . $user_id . "', '" . $first_name . "', '". $last_name ."' ,'" . $enc_password . "', '" . $survey_answered . "', '".$birthday."', '".$email."')";
            $result = $database->query($sql);
            if(!$result){
                $error = 'Cannot add user. Error is' . $database->get_connection()->error;
            }
        }
        return $error;
    }

    public static function is_answered($user_id){
        global $database;
        $sql = "SELECT survey_answered FROM users WHERE user_id = '". $user_id ."'";
        $result = $database->query($sql)->fetch_assoc();
        return $result['survey_answered'];
    }

    public static function survey_answered($user_id){
        global $database;
        $sql = "UPDATE users SET survey_answered = '1'WHERE user_id = '". $user_id ."'";
        $result = $database->query($sql);
        if(!$result){
            $error = 'ERROR! Cannot update user. Error: ' . $database->get_connection()->error;
        }
        return $error;
    }

    public static function user_id_exists($user_id){
        global $database;
        $result = $database->query("SELECT * FROM users WHERE user_id ='" . $user_id . "'");
        if(!$result){
            return false;
        }
        if($result->num_rows>0){
            return true;
        }
    }

}
