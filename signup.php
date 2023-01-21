<?php
require_once('includes/init.php');
global $database;

$urlContents = file_get_contents('php://input');
$userArray = json_decode($urlContents, true);
$error = null;
if($userArray){
    $user_id = $userArray['user_id'];
    $f_name = $userArray['f_name'];
    $l_name = $userArray['l_name'];
    $password = $userArray['password'];
    $birthday = $userArray['birthday'];
    $email = $userArray['email'];
    if(!User::user_id_exists($user_id)){
        $error = User::add_user($user_id, $f_name, $l_name, $password, 0, $birthday, $email);
    }else{
        $error = Array('dupp_user'=>'This user ID exists already.');
    }

    if(sizeof($error) == 0){
        $success_response = json_encode(Array('success'=>'User added successfully! Click <a style="font-weight: 600" href="login.php">here</a> to login.'));
        echo $success_response;
    }else{
        $error = json_encode($error);
        echo $error;
    }
}
