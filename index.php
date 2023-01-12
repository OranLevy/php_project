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
echo '<h1>Hello ' . $user->first_name . ' ' . $user->last_name . '</h1>';

?>
<html>
    <head>
        <script>
            function startSurvey(){
                window.location = 'part1.php';
            }
        </script>
    </head>
    <body>
        <button onclick="startSurvey()">Start survey</button>
    </body>
</html>