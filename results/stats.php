<?php
require_once('../includes/init.php');
require_once('../includes/survey_part1.php');
require_once('../includes/survey_part2.php');
require_once('../includes/survey_part3.php');
global $database;
$stats = Array();
$answered_users = User::get_answered_survey_users();
$part1 = null;
$part2 = null;
$part3 = null;
$i = 0;
foreach ($answered_users as $user){
    $part1[$i] = SurveyPart1::fetch_answers_by_user($user["user_id"]);
    if($part1[$i][0]->question6 == 'Yes'){
        $part2[$i] = SurveyPart2::fetch_answers_by_user($user["user_id"]);
    }
    $part3[$i] = SurveyPart3::fetch_answers_by_user($user["user_id"]);
    $i++;
}

// Stat 1
$counter_work_in = 0;
$cities_work_in = Array();
foreach ($part1 as $p){
    if($p[0]->question3 == 'Yes'){
        $counter_work_in += 1;
        if(array_key_exists($p[0]->question1, $cities_work_in)){
            $cities_work_in[$p[0]->question1] += 1;
        }else{
            $cities_work_in[$p[0]->question1] = 1;
        }

    }
}
$stats['stat1'] = Array('total_work_in' => $counter_work_in, 'cities_work_in' => $cities_work_in);
// Stat 2
$look_for_work = Array('18-21'=> Array('part_time' => 0, 'full_time' => 0), '22-25' => Array('part_time' => 0, 'full_time' => 0), '26-30' => Array('part_time' => 0, 'full_time' => 0), '31-35' => Array('part_time' => 0, 'full_time' => 0), '36-40' => Array('part_time' => 0, 'full_time' => 0));
foreach ($part1 as $p){
    if($p[0]->question4 == 'Yes'){
        if($p[0]->question2 == '18-21' && $p[0]->question5 == 'Part time'){
            $look_for_work['18-21']['part_time'] += 1;
        }
        if($p[0]->question2 == '18-21' && $p[0]->question5 == 'Full time'){
            $look_for_work['18-21']['full_time'] += 1;
        }
        if($p[0]->question2 == '22-25' && $p[0]->question5 == 'Part time'){
            $look_for_work['22-25']['part_time'] += 1;
        }
        if($p[0]->question2 == '22-25' && $p[0]->question5 == 'Full time'){
            $look_for_work['22-25']['full_time'] += 1;
        }
        if($p[0]->question2 == '26-30' && $p[0]->question5 == 'Part time'){
            $look_for_work['26-30']['part_time'] += 1;
        }
        if($p[0]->question2 == '26-30' && $p[0]->question5 == 'Full time'){
            $look_for_work['26-30']['full_time'] += 1;
        }
        if($p[0]->question2 == '31-35' && $p[0]->question5 == 'Part time'){
            $look_for_work['31-35']['part_time'] += 1;
        }
        if($p[0]->question2 == '31-35' && $p[0]->question5 == 'Full time'){
            $look_for_work['31-35']['full_time'] += 1;
        }
        if($p[0]->question2 == '36-40' && $p[0]->question5 == 'Part time'){
            $look_for_work['36-40']['part_time'] += 1;
        }
        if($p[0]->question2 == '36-40' && $p[0]->question5 == 'Full time'){
            $look_for_work['36-40']['full_time'] += 1;
        }
    }
}
$stats['stat2'] = $look_for_work;
// Stat 3
$avg_salary_city = Array();
foreach ($part2 as $p){
    if(array_key_exists($p[0]->question7, $avg_salary_city)){
        $avg_salary_city[$p[0]->question7][] = $p[0]->question10;
    }else{
        $avg_salary_city[$p[0]->question7] = Array($p[0]->question10);
    }
}
$stats['stat3'] = $avg_salary_city;
// Stat 4
$work_source_experience = Array();
foreach ($part1 as $p1){
    if($p1[0]->question6 == 'Yes'){
        if(SurveyPart2::check_id_answers($p1[0]->user_id)){
            $p2 = SurveyPart2::fetch_answers_by_user($p1[0]->user_id);
            if(array_key_exists($p2[0]->question11, $work_source_experience)){
                $work_source_experience[$p2[0]->question11] += 1;
            }else{
                $work_source_experience[$p2[0]->question11] = 1;
            }

        }
    }
}
$stats['stat4'] = $work_source_experience;
// Stat 5
$work_source_search = Array();
foreach ($part1 as $p1){
    if($p1[0]->question4 == 'Yes'){
        if(SurveyPart3::check_id_answers($p1[0]->user_id)){
            $p3 = SurveyPart3::fetch_answers_by_user($p1[0]->user_id);
            $q12 = explode(',', $p3[0]->question12);
            foreach ($q12 as $q){
                if(array_key_exists($q, $work_source_search)){
                    $work_source_search[$q] += 1;
                }else{
                    $work_source_search[$q] = 1;
                }
            }
        }
    }
}
$stats['stat5'] = $work_source_search;
// Stat 6
$search_time_experience = Array('experience_avg'=>0, 'no_experience_avg'=>0);
$experience_count= 0;
$no_experience_count = 0;
foreach ($part1 as $p1){
    if($p1[0]->question6 == 'Yes'){
        if(SurveyPart3::check_id_answers($p1[0]->user_id)){
            $p3 = SurveyPart3::fetch_answers_by_user($p1[0]->user_id);
            $search_time_experience['experience_avg'] += intval($p3[0]->question13);
            $experience_count += 1;
        }
    }else if($p1[0]->question6 == 'No'){
        if(SurveyPart3::check_id_answers($p1[0]->user_id)){
            $p3 = SurveyPart3::fetch_answers_by_user($p1[0]->user_id);
            $search_time_experience['no_experience_avg'] += intval($p3[0]->question13);
            $no_experience_count += 1;
        }
    }
}
if($experience_count > 0){
    $search_time_experience['experience_avg'] /= $experience_count;
}
if($no_experience_count > 0){
    $search_time_experience['no_experience_avg'] /= $no_experience_count;
}
$stats['stat6'] = $search_time_experience;
// Stat 7
$prepare_to_test = Array('prepared'=>Array('accepted'=>0, 'not_accepted'=>0), 'not_prepared'=>Array('accepted'=>0, 'not_accepted'=>0));
foreach ($part3 as $p){
    if($p[0]->question16 == 'Yes'){
        if($p[0]->question14 == 'Yes'){
            $prepare_to_test['prepared']['accepted'] += 1;
        }else if($p[0]->question14 == 'No'){
            $prepare_to_test['prepared']['not_accepted'] += 1;
        }
    }else if($p[0]->question16 == 'No'){
        if($p[0]->question14 == 'Yes'){
            $prepare_to_test['not_prepared']['accepted'] += 1;
        }else if($p[0]->question14 == 'No'){
            $prepare_to_test['not_prepared']['not_accepted'] += 1;
        }
    }
}
$stats['stat7'] = $prepare_to_test;
$response = json_encode($stats);
echo $response;