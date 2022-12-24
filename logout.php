<?php
require_once('includes/init.php');
global $session;
if($session->signed_in){
    $session->logout();
    header('Location: login.php');
}
?>