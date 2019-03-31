<?php

namespace app\repositories;
use app\models\surveys\Surveys;
use app\models\User;

class Getsurveys
{
    public function __invoke($id, $surveys_count)   // получить комментарии по выбранной теме
    {
        $surveys = Surveys::find()->where(['topic_id' => $id])->orderby(['create_date'=>SORT_DESC])->all();
            $i= 0;
            $data = array();            
            foreach($surveys as $survey) {           
                $users_id = $survey['user_id'];
                $users = User::find()->where(['id' => $users_id])->one();
                $data[$i] = array("user_name"=>$users['first_name'],"message"=>$survey['message'],
                    "create_date"=>$survey['create_date'], "user_id"=> $users_id, "topic_id"=> $id);
                $i++;
            }        
            return $data;
    }
}