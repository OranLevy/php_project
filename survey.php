<?php
require_once('includes/init.php');
global $database;

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
            $error = 'Q2 is required.<br>';
        }
        if($q3 == '' || $q3 == '-'){
            $error = 'Q3 is required.<br>';
        }
        if($q4 == '' || $q4 == '-'){
            $error = 'Q4 is required.<br>';
        }
        if(($q5 == '-' || $q5 == '-') && $q4 == 'yes'){
            $error = 'Q5 is required.<br>';
        }
        if(($q1 == '' || $q6 == '-')  && $q4 == 'yes'){
            $error = 'Q1 is required.<br>';
        }
    }
}