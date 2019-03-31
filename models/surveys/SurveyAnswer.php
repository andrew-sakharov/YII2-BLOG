<?php

namespace app\models\surveys;

use Yii;

/**
 * This is the model class for table "survey_answer".
 *
 * @property int $id
 * @property int $surveys_result КОД ОТВЕТА
 * @property string $surveys_ANSWER ОТВЕТ
 *
 * @property Surveys[] $surveys
 */
class SurveyAnswer extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'survey_answer';
    }

    public function rules()
    {
        return [
            [['surveys_result'], 'integer'],
            [['surveys_ANSWER'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surveys_result' => 'КОД ОТВЕТА',
            'surveys_ANSWER' => 'ОТВЕТ',
        ];
    }

    public function getSurveys()
    {
        return $this->hasMany(Surveys::className(), ['surveys_result' => 'id']);
    }

    public static function find()
    {
        return new SurveyAnswerQuery(get_called_class());
    }
}
