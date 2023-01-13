<?php
require_once('includes/survey_part3.php');
require_once('includes/init.php');
include('navbar-menu.html');
global $session;
global $database;
if($database->get_connection()){
    echo "<script>console.log('Connection OK');</script>";
}else{
    die('Connection failed');
}
if(!$session->signed_in){
    header('Location: login.php');
    exit;
}

unset($_SESSION['error']);

$user_id = $_SESSION['user_id'];
if ($_POST) {
    if(isset($_POST['save']) || isset($_POST['save_continue'])){
        if (!isset($_POST['search_source'])) {
            $error = 'Q12 is required.<br>';
        }
        if (!$_POST['hour_search']) {
            if(isset($error)){
                $error = $error . 'Q13 is required.<br>';
            }else{
                $error = 'Q13 is required.<br>';
            }
        }
        if (!$_POST['get_accepted'] || $_POST['get_accepted'] == '-') {
            if(isset($error)){
                $error = $error . 'Q14 is required.<br>';
            }else{
                $error = 'Q14 is required.<br>';
            }
        }
        if (!$_POST['hiring_test'] || $_POST['hiring_test'] == '-') {
            if(isset($error)){
                $error = $error . 'Q15 is required.<br>';
            }else{
                $error = 'Q15 is required.<br>';
            }
        }
        if (!$_POST['test_prepared'] || $_POST['test_prepared'] == '-') {
            if(isset($error)){
                $error = $error . 'Q16 is required.<br>';
            }else{
                $error = 'Q16 is required.<br>';
            }
        }

        if (isset($error)) {
            $_SESSION['error'] = $error;
            unset($_SESSION['success']);
        } else {
            if (!SurveyPart3::check_id_answers($user_id)) {
                $success = SurveyPart3::add_answers($user_id, $_POST['search_source'], $_POST['hour_search'], $_POST['get_accepted'], $_POST['hiring_test'], $_POST['test_prepared']);
                $success = 'Answers added.';
            } else {
                $success = SurveyPart3::update_answers($user_id, $_POST['search_source'], $_POST['hour_search'], $_POST['get_accepted'], $_POST['hiring_test'], $_POST['test_prepared']);
                $success = $success . 'ID of the answers already exist in DB <br>Updating answers.';
            }
            $_SESSION['success'] = $success;
        }
    }
    if(isset($_POST['save_continue'])){
        if(!isset($error)){
            header('Location: index.php');
            exit;
        }
    }
}

include('survey_html/part3.html');