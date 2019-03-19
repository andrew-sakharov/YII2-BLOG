<?php

namespace app\repositories;
use Yii;
use app\models\surveys\Surveys;
use app\models\surveys\Topics;
use app\models\surveys\Citizens;

class Getsurveys
{
    public function __invoke($id, $surveys_count)
    {
        $surveys = Surveys::find()->where(['topic_id' => $id])->asArray()->orderby(['create_date'=>SORT_DESC])->all();
            $i= 0;
            while ($i < $surveys_count) {           
                $citizens_id = $surveys[$i]['citizen_id'];
                $citizens = Citizens::find()->where(['id' => $citizens_id])->one();                     
                $data[$i] = array("user_name"=>$citizens['user_name'],"message"=>$surveys[$i]['message'],
                    "create_date"=>$surveys[$i]['create_date'], "citizen_id"=> $citizens_id, "topic_id"=> $id);
                $i++;
            }        
            return $data;
    }
}