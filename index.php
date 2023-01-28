<?php
require_once('includes/init.php');
require_once('includes/survey_part1.php');
require_once('includes/survey_part2.php');
require_once('includes/survey_part3.php');
global $session;
if(!$session->signed_in){
    header('Location: login.php');
    exit;
}
include('static/navbar-menu.html');

// Clean success and error messages
unset($_SESSION['success']);
unset($_SESSION['error']);

$user_id = $session->user_id;
$user = new User();
$user->find_user_by_id($user_id);
$hello_message =  '<h1 id="welcome-title">Hello ' . $user->first_name . ' ' . $user->last_name . '</h1>';
$count_part1 = SurveyPart1::count_answered_by_id($user_id);
$count_part2 = SurveyPart2::count_answered_by_id($user_id);
$count_part3 = SurveyPart3::count_answered_by_id($user_id);
$progress = $count_part1 + $count_part2 + $count_part3;
if(!(SurveyPart1::is_part_done($user_id) && SurveyPart2::is_part_done($user_id) && SurveyPart3::is_part_done($user_id)) && $progress > 0 && User::is_answered($user_id) == 0) {
    $progress_message = '<div>Good job! &#128170 <br> You already answered '. $progress .' questions</div>';
    $survey_button = '<button class="btn-submit" name="continue_survey">Continue survey</button> <button class="btn-save" name="review_answers">Review answered questions</button>';
}else if($progress == 0 && User::is_answered($user_id) == 0){
    $progress_message = "<div>Looks like you still didn't start to answer the survey... &#128534 <br> Don't worry! you can do it by clicking just below &#128513 </div>";
    $survey_button = '<button class="btn-save" name ="start_survey">Start survey</button>';
}else if(SurveyPart1::is_part_done($user_id) && SurveyPart2::is_part_done($user_id) && SurveyPart3::is_part_done($user_id) && User::is_answered($user_id) == 0){
    $progress_message = "<div>Looks like you answered all the questions! <br> You can submit your answers right here or review your answers before submitting.</div>";
    $survey_button = '<button class="btn-submit" name="submit_survey">Submit answers</button> <button class="btn-save" name="review_answers">Review answers</button>';
}else{
    $progress_message = "<div>Thank you for answering our survey! &#128591 <br> You can see the submitted answers by clicking <a href='results/answers.php'>here</a></div>";
    $survey_button = '';
}


// Handle buttons click
if($_POST){
    if(isset($_POST['start_survey'])){
        header('Location: /phpProject/survey/part1.php');
        exit;
    }
    if(isset($_POST['submit_survey'])){
        User::survey_answered($user_id);
        header('Location: index.php');
        exit;
    }
    if(isset($_POST['continue_survey'])){
        if(!SurveyPart1::is_part_done($user_id)){
            header('Location: /phpProject/survey/part1.php');
            exit;
        }
        if(!SurveyPart2::is_part_done($user_id)){
            header('Location: /phpProject/survey/part2.php');
            exit;
        }
        if(!SurveyPart3::is_part_done($user_id)){
            header('Location:/phpProject/survey/ part3.php');
            exit;
        }
    }
    if(isset($_POST['review_answers'])){
        header('Location: /phpProject/survey/part1.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="preload" as="style" href="css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php echo $hello_message;?>
        <div id="survey-status">
            <?php
            echo $progress_message;
            ?>
        </div>
        <form class="form-index" method="post">
            <?php
            echo $survey_button;
            ?>
        </form>
    </body>
</html>