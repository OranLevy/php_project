<?php
require_once('database.php');
class User {
    private $user_id;
    private $first_name;
    private $last_name;
    private $password;
    private $registration_date;

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
            $error = "Cannot find user by this user_id";
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

    public static function add_user($user_id, $name, $password){
        global $database;
        $error = null;
        $enc_password = md5(md5($user_id) . $password);
        $sql = "INSERT INTO users (user_id, name, password) VALUES ('" . $user_id . "', '" . $name . "', '" . $enc_password . "')";
        $result = $database->query($sql);
        if(!$result){
            $error = 'Cannot add user. Error is' . $database->get_connection()->error;
        }
        return $error;
    }

}


?>

