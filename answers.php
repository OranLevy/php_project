<?php
require_once('includes/init.php');
require_once('includes/survey_part1.php');
require_once('includes/survey_part2.php');
require_once('includes/survey_part3.php');
include('navbar-menu.html');
global $session;
if (!$session->signed_in) {
    header('Location: login.php');
    exit;
}
$user_id = $session->user_id;
if(User::is_answered($user_id) == 1){
    $part1 = SurveyPart1::fetch_answers_by_user($user_id);
    $part2 = SurveyPart2::fetch_answers_by_user($user_id);
    $part3 = SurveyPart3::fetch_answers_by_user($user_id);
    $question_answers_html = '<section class="questions_answers">
                <h2>Part 1 - General information</h2>
                <div id="q1" class="q_a">
                    <p class="question">1. In which city do you live?</p>
                    <p class="answers">'. $part1[0]->question1 .'</p>
                </div>
                <div id="q2" class="q_a">
                    <p class="question">2. What age range do you belong to?</p>
                    <p class="answers">'. $part1[0]->question2 .'</p>
                </div>
                <div id="q3" class="q_a">
                    <p class="question">3. Do you work in the high-tech industry?</p>
                    <p class="answers">'. $part1[0]->question3 .'</p>
                </div>
                <div id="q4" class="q_a">
                    <p class="question">4. Are you looking for a new job?</p>
                    <p class="answers">'. $part1[0]->question4 .'</p>
                </div>
                <div id="q5" class="q_a">
                    <p class="question">5. What scope of employment are you looking for?</p>
                    <p class="answers">'. $part1[0]->question5 .'</p>
                </div>
                <div id="q6" class="q_a">
                    <p class="question">6. Do you have work experience?</p>
                    <p class="answers">'. $part1[0]->question6 .'</p>
                </div>
                <h2>Part 2 - Work experience</h2>
                <div id="q7" class="q_a">
                    <p class="question">7. In which city is your work located?</p>
                    <p class="answers">'. $part2[0]->question7 .'</p>
                </div>
                <div id="q8" class="q_a">
                    <p class="question">8. What was your position?</p>
                    <p class="answers">'. $part2[0]->question8 .'</p>
                </div>
                <div id="q9" class="q_a">
                    <p class="question">9. How long did you work there?</p>
                    <p class="answers">'. $part2[0]->question9 .'</p>
                </div>
                <div id="q10" class="q_a">
                    <p class="question">10. What was your salary per hour?</p>
                    <p class="answers">'. $part2[0]->question10 .'</p>
                </div>
                <div id="q11" class="q_a">
                    <p class="question">11. How did you get to this job?</p>
                    <p class="answers">'. $part2[0]->question11 .'</p>
                </div>
                <h2>Part 3 - Job search</h2>

                <div id="q12" class="q_a">
                    <p class="question">12. In which sources did you look for job?</p>
                    <p class="answers">'. $part3[0]->question12 .'</p>
                </div>
                <div id="q13" class="q_a">
                    <p class="question">13. How long did you invest for searching work?</p>
                    <p class="answers">'. $part3[0]->question13 .'</p>
                </div>
                <div id="q14" class="q_a">
                    <p class="question">14. Did you ever get accepted to work?</p>
                    <p class="answers">'. $part3[0]->question14 .'</p>
                </div>
                <div id="q15" class="q_a">
                    <p class="question">15. Have you done a test/interview during the hiring process?</p>
                    <p class="answers">'. $part3[0]->question15 .'</p>
                </div>
                <div id="q16" class="q_a">
                    <p class="question">16. Did you get prepared to the test?</p>
                    <p class="answers">'. $part3[0]->question16 .'</p>
                </div>
            </section>';
}else{
    $question_answers_html = '<section>This page is available only after submitting answers.</section>';
}
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <main>
            <?php echo $question_answers_html?>
        </main>

    </body>
</html>
