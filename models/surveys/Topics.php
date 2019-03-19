<?php

namespace app\models\surveys;

use Yii;

/**
 * This is the model class for table "topics".
 *
 * @property int $id
 * @property string $create_date ДАТА СОЗДАНИЯ
 * @property string $topic ТЕМА
 * @property int $surveys_count КОММЕНТАРИЕВ
 * @property int $surveys_allowed СТАТУС ОПРОСА
 * @property int $surveys_result_yes ПОДДЕРЖИВАЮ
 * @property int $surveys_result_no ПРОТИВ
 * @property int $surveys_result_abstain ВОЗДЕРЖИВАЮСЬ
 *
 * @property Surveys[] $surveys
 */
class Topics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'topics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_date'], 'safe'],
            [['topic'], 'string'],
            [['surveys_allowed', 'surveys_count', 'surveys_result_yes', 'surveys_result_no', 'surveys_result_abstain'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_date' => 'ДАТА СОЗДАНИЯ',
            'topic' => 'ТЕМА',
            'surveys_count' => 'КОММЕНТАРИЕВ',
            'surveys_allowed' => 'СТАТУС ОПРОСА',
            'surveys_result_yes' => 'ПОДДЕРЖИВАЮ',
            'surveys_result_no' => 'ПРОТИВ',
            'surveys_result_abstain' => 'ВОЗДЕРЖИВАЮСЬ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSurveys()
    {
        return $this->hasMany(Surveys::className(), ['topic_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TopicsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TopicsQuery(get_called_class());
    }
}
