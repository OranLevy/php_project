<?php
require_once('includes/database.php');
class SurveyPart3 {
    private $user_id;
    private $question12;
    private $question13;
    private $question14;
    private $question15;
    private $question16;

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

    public function find_answers_by_user($user_id){
        global $database;
        $error = null;
        $result = $database->query("SELECT * FROM survey_part3 WHERE user_id = '" . $user_id . "'");
        if(!$result){
            $error = 'Cannot find answer for this user. Error is:' . $database->get_connection()->error;
        }elseif($result->num_rows>0){
            $found_answer = $result->fetch_assoc();
            $this->instantation($found_answer);
        }else{
            $error = "Cannot find answers for this user id";
        }
        return $error;
    }

    public static function fetch_answers(){
        global $database;
        $result = $database->query("SELECT * FROM survey_part3");
        $answers = null;
        if($result){
            $i = 0;
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    $answer = new SurveyPart3();
                    $answer->instantation($row);
                    $answers[$i] = $answer;
                    $i += 1;
                }
            }
        }
        return $answers;
    }

    public static function add_answers($user_id, $q12, $q13, $q14, $q15, $q16){
        global $database;
        $error = null;
        $sql = "INSERT INTO survey_part3 (user_id, question12, question13, question14, question15, question16) VALUES ('" . $user_id . "', '" . $q12 . "', '" . $q13 . "', '" . $q14 . "', '" . $q15 . "', '" . $q16 . "')";
        $result = $database->query($sql);
        if(!$result){
            $error = 'Cannot add answers. Error: ' . $database->get_connection()->error;
        }
        return $error;
    }

    public static function update_answers($user_id, $q12, $q13, $q14, $q15, $q16){
        global $database;
        $error = null;
        $sql = "UPDATE survey_part3 SET question7 = '" . $q12 . "', question8 = '" . $q13 . "', question9 = '" . $q14 . "', question10 = '" . $q15 . "', question11 = '" . $q16 . "' WHERE user_id = '" . $user_id . "'";
        $result = $database->query($sql);
        if(!$result){
            $error = 'ERROR! Cannot update answers. Error: ' . $database->get_connection()->error;
        }
        return $error;
    }

    public static function check_id_answers($id){
        global $database;
        $sql = "SELECT user_id FROM survey_part3 WHERE user_id = '" . $id . "'";
        $result = $database->query($sql)->fetch_all();
        if(count($result) > 0){
            return true;
        }
        return false;
    }
}
