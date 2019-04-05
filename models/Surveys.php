<?php

namespace app\models\surveys;

use Yii;
use app\models\User;

/**
 * This is the model class for table "surveys".
 *
 * @property int $id
 * @property int $create_date ДАТА СОЗДАНИЯ
 * @property int $topic_id КОД ТЕМЫ
 * @property int $user_id КОД ПОЛЬЗОВАТЕЛЯ
 * @property int $surveys_result КОД ОТВЕТА
 * @property string $message КОММЕНТАРИЙ
 *
 * @property Citizens $citizen
 * @property SurveyAnswer $surveysResult
 * @property Topics $topic
 */
class Surveys extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'surveys';
    }

    public function rules()
    {
        return [
            [['create_date'], 'safe'],
            [['topic_id', 'user_id', 'surveys_result'], 'integer'],
            [['message'], 'string'],
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->create_date = time();
            $this->user_id = Yii::$app->user->id;
            return true;
        }
        else {
            $this->create_date = strtotime($this->create_date);
            $this->user_id = Yii::$app->user->id;
            return true;
        }
    }
    
    public function afterFind()
    {
        $this->create_date = date('d-M-Y', $this->create_date);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_date' => 'ДАТА',
            'topic_id' => 'КОД ТЕМЫ',
            'user_id' => 'КОД ПОЛЬЗОВАТЕЛЯ',
            'surveys_result' => 'КОД ОТВЕТА',
            'message' => 'Комментировать',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getSurveysResult()
    {
        return $this->hasOne(SurveyAnswer::className(), ['id' => 'surveys_result']);
    }

    public function getTopic()
    {
        return $this->hasOne(Topics::className(), ['id' => 'topic_id']);
    }

    public static function find()
    {
        return new SurveysQuery(get_called_class());
    }
    
    public  static function getDayCreate()
    {
        return   date('d-M-Y',  $this->create_date);
    }
}
