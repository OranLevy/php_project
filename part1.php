<?php
require_once('includes/survey_part1.php');
require_once('includes/init.php');
include('navbar-menu.html');
global $session;
global $database;

if($database->get_connection()){
	echo "<script>console.log('Connection OK');</script>";
}else{
	die('Connection failed');
}
$user_id = $_SESSION['user_id'];
if(!$session->signed_in){
    header('Location: login.php');
    exit;
}
if(User::is_answered($user_id) == 1){
    header('Location: index.php');
    exit;
}
unset($_SESSION['error']);
if ($_POST) {
    if(isset($_POST['save']) || isset($_POST['save_continue'])){
        if (!$_POST['city_q']) {
            $error = 'Q1 is required.<br>';
        }
        if (!$_POST['age_q'] || $_POST['age_q'] == '-') {
            if(isset($error)){
                $error = $error . 'Q2 is required.<br>';
            }else{
                $error = 'Q2 is required.<br>';
            }

        }
        if (!$_POST['work_in'] || $_POST['work_in'] == '-') {
            if(isset($error)){
                $error = $error . 'Q3 is required.<br>';
            }else{
                $error = 'Q3 is required.<br>';
            }

        }
        if ((!$_POST['new_job'] || $_POST['new_job'] == '-')) {
            if(isset($error)){
                $error = $error . 'Q4 is required.<br>';
            }else{
                $error = 'Q4 is required.<br>';
            }
        }
        if ((!$_POST['work_scope'] || $_POST['work_scope'] == '-') && $_POST['new_job'] == 'yes') {
            if(isset($error)){
                $error = $error . 'Q5 is required.<br>';
            }else{
                $error = 'Q5 is required.<br>';
            }
        }
        if ((!$_POST['work_experience'] || $_POST['work_experience'] == '-') && $_POST['new_job'] == 'yes') {
            if(isset($error)){
                $error = $error . 'Q6 is required.<br>';
            }else{
                $error = 'Q6 is required.<br>';
            }
        }
        if (isset($error)) {
            $_SESSION['error'] = $error;
            unset($_SESSION['success']);
        } else {
            if (!SurveyPart1::check_id_answers($user_id)) {
                $success = SurveyPart1::add_answers($user_id, $_POST['city_q'], $_POST['age_q'], $_POST['work_in'], $_POST['new_job'], $_POST['work_scope'], $_POST['work_experience']);
                $success = 'Answers added.';
            } else {
                $success = SurveyPart1::update_answers($user_id, $_POST['city_q'], $_POST['age_q'], $_POST['work_in'], $_POST['new_job'], $_POST['work_scope'], $_POST['work_experience']);
                $success = $success . 'ID of the answers already exist in DB <br>Updating answers.';
            }
            $_SESSION['success'] = $success;
        }
    }
    if(isset($_POST['save_continue'])){
        if(!isset($error)){
            header('Location: part2.php');
            exit;
        }
    }
}
include('survey_html/part1.html');






