<?php
require_once('includes/survey_part3.php');
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
    var_dump($_POST);
    if (!$_POST['search_source']) {
        $error = 'Q12 is required.<br>';
    }
    if (!$_POST['hour_search']) {
        $error = $error . 'Q13 is required.<br>';
    }
    if (!$_POST['get_accepted'] || $_POST['get_accepted'] == '-') {
        $error = $error . 'Q14 is required.<br>';
    }
    if (!$_POST['hiring_test'] || $_POST['hiring_test'] == '-') {
        $error = $error . 'Q15 is required.<br>';
    }
    if (!$_POST['test_prepared'] || $_POST['test_prepared'] == '-') {
        $error = $error . 'Q16 is required.<br>';
    }


    if (isset($error)) {
        $_SESSION['error'] = $error;
        // echo $error;
    } else {
        if (!SurveyPart3::check_id_answers($user_id)) {
            $error_sql = SurveyPart3::add_answers($user_id, $_POST['search_source'], $_POST['hour_search'], $_POST['get_accepted'], $_POST['hiring_test'], $_POST['test_prepared']);
            $error_sql = 'Answers added.';
        } else {
            $error_sql = SurveyPart3::update_answers($user_id, $_POST['search_source'], $_POST['hour_search'], $_POST['get_accepted'], $_POST['hiring_test'], $_POST['test_prepared']);
            $error_sql = $error_sql . 'ID of the answers already exist in DB <br>Updating answers.';
        }
        if (isset($error_sql)) {
            $_SESSION['error_sql'] = $error_sql;
        }
    }
}

include('part3.html');