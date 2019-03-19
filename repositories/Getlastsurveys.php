<?php

namespace app\repositories;
use Yii;
use app\models\surveys\Surveys;
use app\models\surveys\Topics;
use app\models\surveys\Citizens;

class Getlastsurveys
{
    public function __invoke()
    {
            $topics = Topics::find()->asArray()->all();
            $topics_l = count($topics);
            $i= 0;
            while ($i < $topics_l) {
                $row_topics = $topics[$i];
                $topics_id = $row_topics['id'];
                $topic_name = substr($row_topics['topic'],0,300);
                $row = Surveys::find()->where(['topic_id' => $topics_id])->orderby(['create_date'=>SORT_DESC])->one();                
                if ($row['create_date'] > 0) {
                    $citizens_id = $row['citizen_id'];
                    $citizens = Citizens::find()->where(['id' => $citizens_id])->one();                     
                    $data[] = array("topic"=>$topic_name, "user_name"=>$citizens['user_name'],"message"=>$row['message'],"create_date"=>$row['create_date']);
                }
                $i++;
            }        
            return $data;
    }
}