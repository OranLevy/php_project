<?php
require_once('includes/init.php');
require_once('includes/survey_part1.php');
require_once('includes/survey_part2.php');
require_once('includes/survey_part3.php');
global $database;
global $session;
$user_id = $_SESSION['user_id'];
$urlContents = file_get_contents('php://input');
$data = json_decode($urlContents, true);
$error = null;

if($data){
    if($data['part'] == 1){
        $q1 = $data['city_q'];
        $q2 = $data['age_q'];
        $q3 = $data['work_in'];
        $q4 = $data['new_job'];
        $q5 = $data['work_scop'];
        $q6 = $data['work_experience'];
        if($q1 == '' || $q1 == '-'){
            $error = 'Q1 is required.<br>';
        }
        if($q2 == '' || $q2 == '-'){
            if(isset($error)){
                $error = $error . 'Q2 is required.<br>';
            }else{
                $error = 'Q2 is required.<br>';
            }
        }
        if($q3 == '' || $q3 == '-'){
            if(isset($error)){
                $error = $error . 'Q3 is required.<br>';
            }else{
                $error = 'Q3 is required.<br>';
            }
        }
        if($q4 == '' || $q4 == '-'){
            if(isset($error)){
                $error = $error . 'Q4 is required.<br>';
            }else{
                $error = 'Q4 is required.<br>';
            }
        }
        if(($q5 == '' || $q5 == '-') && $q4 == 'yes'){
            if(isset($error)){
                $error = $error . 'Q5 is required.<br>';
            }else{
                $error = 'Q5 is required.<br>';
            }
        }
        if(($q1 == '' || $q6 == '-')  && $q4 == 'yes'){
            if(isset($error)){
                $error = $error . 'Q6 is required.<br>';
            }else{
                $error = 'Q6 is required.<br>';
            }
        }
        if (isset($error)) {
            echo $error;
        } else {
            if (!SurveyPart1::check_id_answers($user_id)) {
                $success = SurveyPart1::add_answers($user_id, $q1, $q2, $q3, $q4, $q5, $q6);
                $success = 'Answers added.';
            } else {
                $success = SurveyPart1::update_answers($user_id, $q1, $q2, $q3, $q4, $q5, $q6);
                $success = $success . 'ID of the answers already exist in DB <br>Updating answers.';
            }
            echo $success;
        }

    }
}