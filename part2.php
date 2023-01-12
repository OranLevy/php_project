<?php
require_once('includes/survey_part2.php');
require_once('includes/database.php');
include('navbar-menu.html');
session_start();
global $database;
if($database->get_connection()){
    echo "<script>console.log('Connection OK');</script>";
}else{
    die('Connection failed');
}
unset($_SESSION['error']);
unset($_SESSION['error_sql']);
$user_id = $_SESSION['user_id'];

if ($_POST) {
    if (!$_POST['work_city']) {
        $error = 'Q7 is required.<br>';
    }
    if (!$_POST['position_q'] || $_POST['position_q'] == '-') {
        $error = $error . 'Q8 is required.<br>';
    }
    if (!$_POST['work_time'] || $_POST['work_time'] == '-') {
        $error = $error . 'Q9 is required.<br>';
    }
    if (!$_POST['salary']) {
        $error = $error . 'Q10 is required.<br>';
    }
    if (!$_POST['get_job'] || $_POST['get_job'] == '-') {
        $error = $error . 'Q11 is required.<br>';
    }


    if (isset($error)) {
        $_SESSION['error'] = $error;
        // echo $error;
    } else {
        if (!SurveyPart2::check_id_answers($user_id)) {
            $error_sql = SurveyPart2::add_answers($user_id, $_POST['work_city'], $_POST['position_q'], $_POST['work_time'], $_POST['salary'], $_POST['get_job']);
            $error_sql = 'Answers added.';
        } else {
            $error_sql = SurveyPart2::update_answers($user_id, $_POST['work_city'], $_POST['position_q'], $_POST['work_time'], $_POST['salary'], $_POST['get_job']);
            $error_sql = $error_sql . 'ID of the answers already exist in DB <br>Updating answers.';
        }
        if (isset($error_sql)) {
            $_SESSION['error_sql'] = $error_sql;
        }
    }
}

include('part2.html');