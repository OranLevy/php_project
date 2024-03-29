<?php
require_once('init.php');
class Session {
    private $signed_in;
    private $user_id;
    private function check_login(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        }else{
            unset($this->user_id);
            $this->signed_in = false;
        }
    }
    public function __construct(){
        session_start();
        $this->check_login();
    }
    public function __get($property){
        if(property_exists($this, $property)){
            return $this->$property;
        }
    }
    public function login($user){
        if($user){
            $this->user_id = $user->user_id;
            $_SESSION['user_id']=$user->user_id;
            $this->signed_in = true;
            setcookie('signed_in', 'true', 0, '/');
        }
    }
    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
        setcookie('signed_in', 'true', time() - 3600, '/');
    }
    
}

$session = new Session();
