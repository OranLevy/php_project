<?php
require_once('../includes/init.php');
require_once('../includes/survey_part1.php');
require_once('../includes/survey_part2.php');
require_once('../includes/survey_part3.php');
global $session;
global $database;
$user_id = $_SESSION['user_id'];

$urlContents = file_get_contents('php://input');
$answers = json_decode($urlContents, true);
$error = array();
if($answers){
    if($answers['action'] == 'part1'){
        if(!$answers['q1'] || $answers['q1'] == ' '){
            $error['q1_error'] = 'Q1 is required';
        }
        if(!$answers['q2'] || $answers['q2'] == '-'){
            $error['q2_error'] = 'Q2 is required';
        }
        if(!$answers['q3'] || $answers['q3'] == '-'){
            $error['q3_error'] = 'Q3 is required';
        }
        if(!$answers['q4'] || $answers['q4'] == '-'){
            $error['q4_error'] = 'Q4 is required';
        }
        if((!$answers['q5'] || $answers['q5'] == '-') && $answers['q4'] == 'Yes'){
            $error['q5_error'] = 'Q5 is required';
        }
        if((!$answers['q6'] || $answers['q6'] == '-') && $answers['q4'] == 'Yes'){
            $error['q6_error'] = 'Q6 is required';
        }
        if(sizeof($error) > 0){
            $error = json_encode(array('error'=>$error));
            echo $error;
        }else{
            if(!SurveyPart1::check_id_answers($user_id)){
                $resp = SurveyPart1::add_answers($user_id, $answers['q1'], $answers['q2'], $answers['q3'],$answers['q4'], $answers['q5'], $answers['q6']);
                echo json_encode(array('success'=>'Part 1: Answers added successfully'));
            }else{
                $resp = SurveyPart1::update_answers($user_id, $answers['q1'], $answers['q2'], $answers['q3'],$answers['q4'], $answers['q5'], $answers['q6']);
                echo json_encode(array('success'=>'Part 1: Answers updated successfully'));
            }
        }
    }
    if($answers['action'] == 'part2'){
        if(!$answers['q7'] || $answers['q7'] == ' '){
            $error['q7_error'] = 'Q7 is required';
        }
        if(!$answers['q8'] || $answers['q8'] == '-'){
            $error['q8_error'] = 'Q8 is required';
        }
        if(!$answers['q9'] || $answers['q9'] == '-'){
            $error['q9_error'] = 'Q9 is required';
        }
        if($answers['q10'] == ' '){
            $error['q10_error'] = 'Q10 is required';
        }else if(is_numeric($answers['q10'])){
            $q10 = (int)$answers['q10'];
            if($q10 < 0){
                $error['q10_error'] = 'Salary needs to be greater than 0';
            }
        }
        if(!$answers['q11'] || $answers['q11'] == '-'){
            $error['q11_error'] = 'Q11 is required';
        }
        if(sizeof($error) > 0){
            $error = json_encode(array('error'=>$error));
            echo $error;
        }else{
            if(!SurveyPart2::check_id_answers($user_id)){
                $resp = SurveyPart2::add_answers($user_id, $answers['q7'], $answers['q8'], $answers['q9'],$answers['q10'], $answers['q11']);
                echo json_encode(array('success'=>'Part 2: Answers added successfully'));
            }else{
                $resp = SurveyPart2::update_answers($user_id, $answers['q7'], $answers['q8'], $answers['q9'],$answers['q10'], $answers['q11']);
                echo json_encode(array('success'=>'Part 2: Answers updated successfully'));
            }
        }
    }
    if($answers['action'] == 'part3'){
        if(!$answers['q12'] || $answers['q12'] == ' '){
            $error['q12_error'] = 'Q12 is required';
        }
        if($answers['q13'] == ' ' || $answers['q13'] == ''){
            $error['q13_error'] = 'Q13 is required';
        }else if(is_numeric($answers['q13'])){
            $q13 = (int)$answers['q13'];
            if($q13 < 0){
                $error['q13_error'] = 'Hours need to be greater than 0';
            }
        }
        if(!$answers['q14'] || $answers['q14'] == '-'){
            $error['q14_error'] = 'Q14 is required';
        }
        if(!$answers['q15'] || $answers['q15'] == '-'){
            $error['q15_error'] = 'Q15 is required';
        }
        if(!$answers['q16'] || $answers['q16'] == '-'){
            $error['q16_error'] = 'Q16 is required';
        }
        if(sizeof($error) > 0){
            $error = json_encode(array('error'=>$error));
            echo $error;
        }else{
            if(!SurveyPart3::check_id_answers($user_id)){
                $resp = SurveyPart3::add_answers($user_id,$answers['q12'] , $answers['q13'], $answers['q14'], $answers['q15'],$answers['q16']);
                echo json_encode(array('success'=>'Part 3: Answers added successfully'));
            }else{
                $resp = SurveyPart3::update_answers($user_id,$answers['q12'] , $answers['q13'], $answers['q14'], $answers['q15'],$answers['q16']);
                echo json_encode(array('success'=>'Part 3: Answers updated successfully'));
            }
        }
    }
    if($answers['action'] == 'getCities'){
        // Get cities via API
        $postdata = http_build_query(
            array(
                'country' => 'israel',
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context  = stream_context_create($opts);

        $result = file_get_contents('https://countriesnow.space/api/v0.1/countries/cities', false, $context);
        $result = json_decode($result);
        array_unshift($result->data, ' ');
        $cities_arr = json_encode($result->data);
        echo $cities_arr;
    }
    if($answers['action'] == 'checkUserAnswered'){
        if(User::is_answered($user_id) == 1){
            echo json_encode(array("response"=> true));
        }else{
            echo json_encode(array("response"=> false));
        }
    }
    if($answers['action'] == 'fetchUserAnswers'){
        $response = array();
        if(SurveyPart1::check_id_answers($user_id)){
            $part1 = SurveyPart1::fetch_answers_by_user($user_id)[0];
            $response['part1'] = array(
                "q1"=>$part1->question1,
                "q2" => $part1->question2,
                "q3" => $part1->question3,
                "q4" => $part1->question4,
                "q5" => $part1->question5,
                "q6" => $part1->question6
            );
        }
        if(SurveyPart2::check_id_answers($user_id)){
            $part2 = SurveyPart2::fetch_answers_by_user($user_id)[0];
            $response['part2'] = array(
                "q7"=>$part2->question7,
                "q8" => $part2->question8,
                "q9" => $part2->question9,
                "q10" => $part2->question10,
                "q11" => $part2->question11
            );
        }
        if(SurveyPart3::check_id_answers($user_id)){
            $part3 = SurveyPart3::fetch_answers_by_user($user_id)[0];
            $response['part3'] = array(
                "q12"=>$part3->question12,
                "q13" => $part3->question13,
                "q14" => $part3->question14,
                "q15" => $part3->question15,
                "q16" => $part3->question16
            );
        }
        echo json_encode($response);
    }
    if($answers['action'] == 'userSubmitAnswers'){
        User::survey_answered($user_id);
    }
}
