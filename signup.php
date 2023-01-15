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
    $error = User::add_user($user_id, $f_name, $l_name, $password, 0);
    if(!$error){
        echo '<div id="php_success">User added successfully! Click <a href="login.php">here</a> to login.</div>';
    }else{
        echo '<div id="php_error">'. $error .'</div>';
    }
}
