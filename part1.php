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
unset($_SESSION['success']);
if ($_POST) {
    if(isset($_POST['save']) || isset($_POST['save_continue'])){
        var_dump($_POST);
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
        if ((!isset($_POST['work_scope']) || $_POST['work_scope'] == '-') && $_POST['new_job'] == 'Yes') {
            if(isset($error)){
                $error = $error . 'Q5 is required.<br>';
            }else{
                $error = 'Q5 is required.<br>';
            }
        }
        if ((!$_POST['work_experience'] || $_POST['work_experience'] == '-') && $_POST['new_job'] == 'Yes') {
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
$cities_arr = json_encode($result->data);
echo '<script>let cities ='.$cities_arr.'</script>';
include('survey_html/part1.html');
if(SurveyPart1::check_id_answers($user_id)){
    $part1_val = SurveyPart1::fetch_answers_by_user($user_id)[0];
    echo '<script>
setTimeout(function(){
    $("#city_q").select2().val("'. $part1_val->question1 .'").trigger("change");
    document.getElementById("age_q").value = "'. $part1_val->question2 .'";
    document.getElementById("work_in").value = "'. $part1_val->question3 .'";
    document.getElementById("new_job").value = "'. $part1_val->question4 .'";
    document.getElementById("work_scope").value = "'. $part1_val->question5 .'";
    document.getElementById("work_experience").value = "'. $part1_val->question6 .'";
    showQuestions();
},200)
</script>';
}





