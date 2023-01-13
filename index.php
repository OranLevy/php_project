<?php
require_once('includes/init.php');
require_once('includes/survey_part1.php');
require_once('includes/survey_part2.php');
require_once('includes/survey_part3.php');
include('navbar-menu.html');
global $session;
if(!$session->signed_in){
    header('Location: login.php');
    exit;
}
$user_id = $session->user_id;
$user = new User();
$user->find_user_by_id($user_id);
$hello_message =  '<h1 id="welcome-title">Hello ' . $user->first_name . ' ' . $user->last_name . '</h1>';
$count_part1 = SurveyPart1::count_answered_by_id($user_id);
$count_part2 = SurveyPart2::count_answered_by_id($user_id);
$count_part3 = SurveyPart3::count_answered_by_id($user_id);
$progress = $count_part1 + $count_part2 + $count_part3;
if($progress > 0){
    $progress_message = '<div>Good job! &#128170 <br> You already answered '. $progress .' questions</div>';
    $survey_button = '<button onclick="startSurvey()">Continue survey</button>';
}else{
    $progress_message = "<div>Looks like you still didn't start to answer the survey... &#128534 <br> Don't worry! you can do it by clicking just below &#128513 </div>";
    $survey_button = '<button onclick="startSurvey()">Start survey</button>';
}


?>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <script>
            function startSurvey(){
                window.location = 'part1.php';
            }
        </script>
    </head>
    <body>
        <?php echo $hello_message;?>
        <div id="survey-status">
            <?php
            echo $progress_message;
            echo $survey_button;
            ?>
        </div>
    </body>
</html>