<?php

namespace app\repositories;
use Yii;
use app\models\surveys\Surveys;
use app\models\surveys\Topics;
use app\models\User;

class Getlastsurveys    // получить последние комментарии по каждой теме
{
    public function __invoke()
    {
            $topics = Topics::find()->asArray()->all();
            $topics_l = count($topics);
            $i= 0;
            $j= 0;
            $data = array();
            while ($i < $topics_l) {
                $row_topics = $topics[$i];
                $topics_id = $row_topics['id'];
                $topic_name = substr($row_topics['title'],0,300);
                $row = Surveys::find()->where(['topic_id' => $topics_id])->orderby(['create_date'=>SORT_DESC])->one();                
                if ($row['create_date'] > 0) {
                    $user_id = $row['user_id'];
                    $user = User::find()->where(['id' => $user_id])->one();                     
                    $data[$j] = array("topic"=>$topic_name, "user_name"=>$user['first_name'],"message"=>$row['message'],"create_date"=>$row['create_date']);
                    $j++;
                }
                $i++;
            }      
            return $data;
    }
}