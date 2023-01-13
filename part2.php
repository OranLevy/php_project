<?php
require_once('includes/survey_part2.php');
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

var_dump($_SESSION);
$user_id = $_SESSION['user_id'];
if ($_POST) {
    if(isset($_POST['save']) || isset($_POST['save_continue'])){
        if (!$_POST['work_city']) {
            $error = 'Q7 is required.<br>';
        }
        if (!$_POST['position_q'] || $_POST['position_q'] == '-') {
            if(isset($error)){
                $error = $error . 'Q8 is required.<br>';
            }else{
                $error = 'Q8 is required.<br>';
            }
        }
        if (!$_POST['work_time'] || $_POST['work_time'] == '-') {
            if(isset($error)){
                $error = $error . 'Q9 is required.<br>';
            }else{
                $error = 'Q9 is required.<br>';
            }
        }
        if (!$_POST['salary']) {
            if(isset($error)){
                $error = $error . 'Q10 is required.<br>';
            }else{
                $error = 'Q10 is required.<br>';
            }
        }
        if (!$_POST['get_job'] || $_POST['get_job'] == '-') {
            if(isset($error)){
                $error = $error . 'Q11 is required.<br>';
            }else{
                $error = 'Q11 is required.<br>';
            }
        }

        if (isset($error)) {
            $_SESSION['error'] = $error;
            unset($_SESSION['success']);
        } else {
            if (!SurveyPart2::check_id_answers($user_id)) {
                $success = SurveyPart2::add_answers($user_id, $_POST['work_city'], $_POST['position_q'], $_POST['work_time'], $_POST['salary'], $_POST['get_job']);
                $success = 'Answers added.';
            } else {
                $success = SurveyPart2::update_answers($user_id, $_POST['work_city'], $_POST['position_q'], $_POST['work_time'], $_POST['salary'], $_POST['get_job']);
                $success = $success . 'ID of the answers already exist in DB <br>Updating answers.';
            }
            $_SESSION['success'] = $success;
        }
    }
    if(isset($_POST['save_continue'])){
        if(!isset($error)){
            header('Location: part3.php');
            exit;
        }
    }
}

include('survey_html/part2.html');