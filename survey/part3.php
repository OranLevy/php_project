<?php
require_once('../includes/survey_part3.php');
require_once('../includes/init.php');
include('../static/navbar-menu.html');
global $session;
global $database;
if($database->get_connection()){
    echo "<script>console.log('Connection OK');</script>";
}else{
    die('Connection failed');
}
$user_id = $_SESSION['user_id'];
if(!$session->signed_in){
    header('Location: /php_project/login.php');
    exit;
}
if(User::is_answered($user_id) == 1){
    header('Location: /php_project/index.php');
    exit;
}
if(isset($_SESSION['success'])){
    $success_message = '<div class="success" id="php_success">'. $_SESSION['success'] .'</div>';
}
unset($_SESSION['error']);
if ($_POST) {
    if(isset($_POST['save']) || isset($_POST['submit_answers'])){
        if (!isset($_POST['search_source'])) {
            $error = 'Q12 is required.<br>';
        }else{
            $search_source = '';
            for($i = 0; $i < sizeof($_POST['search_source']); $i++){
                if($i != sizeof($_POST['search_source']) -1){
                    $search_source .= $_POST['search_source'][$i].',';
                }else{
                    $search_source .= $_POST['search_source'][$i];
                }
            }
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
            $error_message = '<div class="error" id="php_error">'. $_SESSION['error'] .'</div>';
            unset($_SESSION['success']);
        } else {
            if (!SurveyPart3::check_id_answers($user_id)) {
                $success = SurveyPart3::add_answers($user_id, $search_source, $_POST['hour_search'], $_POST['get_accepted'], $_POST['hiring_test'], $_POST['test_prepared']);
                $success = 'Answers saved';
            } else {
                $success = SurveyPart3::update_answers($user_id, $search_source, $_POST['hour_search'], $_POST['get_accepted'], $_POST['hiring_test'], $_POST['test_prepared']);
                $success = $success . 'Answers saved';
            }
            $_SESSION['success'] = $success;
            $success_message = '<div class="success" id="php_success">'. $_SESSION['success'] .'</div>';
        }
    }
    if(isset($_POST['submit_answers'])){
        if(!isset($error)){
            User::survey_answered($user_id);
            header('Location: /php_project/index.php');
            exit;
        }
    }
}

include('part3.html');
if(SurveyPart3::check_id_answers($user_id)){
    $part3_val = SurveyPart3::fetch_answers_by_user($user_id)[0];
    $q12 = explode(",",$part3_val->question12);
    foreach ($q12 as $val){
        echo '<script>document.getElementById("'.$val.'").checked = true </script>';
    }
    echo '<script>
    document.getElementById("hour_search").value = "'. $part3_val->question13 .'";
    document.getElementById("get_accepted").value = "'. $part3_val->question14 .'";
    document.getElementById("hiring_test").value = "'. $part3_val->question15 .'";
    document.getElementById("test_prepared").value = "'. $part3_val->question16 .'";
</script>';
}