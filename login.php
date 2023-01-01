<?php
require_once('includes/init.php');
global $session;
$error = "";
$info = '';
    if(!$_POST['user']){
        $info = 'User is required';
    }else if(!$_POST['password']){
        $info = 'Password is required';
    }
    else{
        $user_id = $_POST['user'];
        $password = $_POST['password'];
        $user = new User();
        $error = $user->find_user_by_id_password($user_id, $password);
        if(!$error){
            $session->login($user);
            header('Location: homepage.php');
        }else{
            $info = 'User or password are incorrect';
        }
    }
    echo $info;

?>