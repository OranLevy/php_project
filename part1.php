<?php
require_once('includes/survey_part1.php');
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
	if (!$_POST['city_q']) {
		$error = 'Q1 is required.<br>';
	}
	if (!$_POST['age_q'] || $_POST['age_q'] == '-') {
		$error = $error . 'Q2 is required.<br>';
	}
	if (!$_POST['work_in'] || $_POST['work_in'] == '-') {
		$error = $error . 'Q3 is required.<br>';
	}
	if ((!$_POST['new_job'] || $_POST['new_job'] == '-')) {
		$error = $error . 'Q4 is required.<br>';
	}
	if ((!$_POST['work_scope'] || $_POST['work_scope'] == '-') && $_POST['new_job'] == 'yes') {
		$error = $error . 'Q5 is required.<br>';
	}
	if ((!$_POST['work_experience'] || $_POST['work_experience'] == '-') && $_POST['new_job'] == 'yes') {
		$error = $error . 'Q6 is required.<br>';
	}

	if (isset($error)) {
		$_SESSION['error'] = $error;
		// echo $error;
	} else {
		if (!SurveyPart1::check_id_answers($user_id)) {
			$error_sql = SurveyPart1::add_answers($user_id, $_POST['city_q'], $_POST['age_q'], $_POST['work_in'], $_POST['new_job'], $_POST['work_scope'], $_POST['work_experience']);
            $error_sql = 'Answers added.';
		} else {
			$error_sql = SurveyPart1::update_answers($user_id, $_POST['city_q'], $_POST['age_q'], $_POST['work_in'], $_POST['new_job'], $_POST['work_scope'], $_POST['work_experience']);
			$error_sql = $error_sql . 'ID of the answers already exist in DB <br>Updating answers.';
		}
		if (isset($error_sql)) {
			$_SESSION['error_sql'] = $error_sql;
		}
	}
}


include('part1.html');



