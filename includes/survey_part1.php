<?php
require_once('database.php');
class SurveyPart1 {
    private $user_id;
    private $question1;
    private $question2;
    private $question3;
    private $question4;
    private $question5;
    private $question6;

     //  General Getter method
     public function __get($property){
        if(property_exists($this, $property)){
            return $this->$property;
        }
    }

    private function has_attribute($attribute){
        $object_properties = get_object_vars($this);
        return array_key_exists($attribute, $object_properties);
    }

    private function instantation($array){
        foreach ($array as $attribute=>$value){
            if($result=$this->has_attribute($attribute)){
                $this->$attribute = $value;
            }
        }
    }

    public static function fetch_answers_by_user($user_id){
        global $database;
        $error = null;
        $answers = null;
        $result = $database->query("SELECT * FROM survey_part1 WHERE user_id = '" . $user_id . "'");
        if(!$result){
            $error = 'Cannot find answer for this user. Error is:' . $database->get_connection()->error;
        }elseif($result->num_rows>0){
            $i = 0;
            while($row=$result->fetch_assoc()){
                $answer = new SurveyPart1();
                $answer->instantation($row);
                $answers[$i] = $answer;
                $i += 1;
            }
            $error = $answers;
        }else{
            $error = "Cannot find answers for this user id";
        }
        return $error;
    }

    public static function fetch_answers(){
        global $database;
        $result = $database->query("SELECT * FROM survey_part1");
        $answers = null;
        if($result){
            $i = 0;
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $answer = new SurveyPart1();
                    $answer->instantation($row);
                    $answers[$i] = $answer;
                    $i += 1;
                }
            }
        }
        return $answers;
    }

    public static function add_answers($user_id, $q1, $q2, $q3, $q4, $q5, $q6){
        global $database;
        $error = null;
        $sql = "INSERT INTO survey_part1 (user_id, question1, question2, question3, question4, question5, question6) VALUES ('" . $user_id . "', '" . $q1 . "', '" . $q2 . "', '" . $q3 . "', '" . $q4 . "', '" . $q5 . "', '" . $q6 . "')";
        $result = $database->query($sql);
        if(!$result){
            $error = 'Cannot add answers. Error: ' . $database->get_connection()->error;
        }
        return $error;
    }

    public static function update_answers($user_id, $q1, $q2, $q3, $q4, $q5, $q6){
        global $database;
        $error = null;
        $sql = "UPDATE survey_part1 SET question1 = '" . $q1 . "', question2 = '" . $q2 . "', question3 = '" . $q3 . "', question4 = '" . $q4 . "', question5 = '" . $q5 . "', question6 = '" . $q6 . "' WHERE user_id = '" . $user_id . "'";
        $result = $database->query($sql);
        if(!$result){
            $error = 'ERROR! Cannot update answers. Error: ' . $database->get_connection()->error;
        }
        return $error;
    }

    public static function check_id_answers($id){
         global $database;
         $sql = "SELECT user_id FROM survey_part1 WHERE user_id = '" . $id . "'";
         $result = $database->query($sql)->fetch_assoc();
         if($result){
             if(count($result) > 0){
                 return true;
             }
         }
         return false;
    }

    public static function count_answered_by_id($id){
        global $database;
        $sql = "SELECT question1, question2, question3, question4, question5, question6  FROM survey_part1 WHERE user_id = '" . $id . "'";
        $result = $database->query($sql)->fetch_assoc();
        if(!is_null($result)){
            $counter = 0;
            foreach ($result as $val){
                if(strlen($val) > 1){
                    $counter += 1;
                }
            }
            return $counter;
        }
        return 0;

    }

    public static function is_part_done($user_id){
         global $database;
        $sql = "SELECT question1, question2, question3, question4, question5, question6  FROM survey_part1 WHERE user_id = '" . $user_id . "'";
        $result = $database->query($sql)->fetch_assoc();
        if(!is_null($result)){
            $counter = 0;
            // Conditional question
            $q4 = $result['question4'];
            foreach ($result as $val){
                if(strlen($val) > 1){
                    $counter += 1;
                }
            }
            if($q4 == 'No'){
                if($counter == 4){
                    return true;
                }
                return false;
            }
            if($q4 == 'Yes'){
                if($counter == 6){
                    return true;
                }
                return false;
            }
        }
        return false;
    }
}
