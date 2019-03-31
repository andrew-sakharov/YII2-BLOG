<?php

namespace app\models\surveys;

use Yii;

/**
 * This is the model class for table "user_topic_status".
 *
 * @property int $id
 * @property int $topic_id КОД ТЕМЫ
 * @property int $user_id КОД ГРАЖДАНИНА
 * @property string $vote ГОЛОСОВАЛ
 * @property string $message КОММЕНТИРОВАЛ
 */
class UserTopicStatus extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'user_topic_status';
    }

    public function rules()
    {
        return [
            [['topic_id', 'user_id'], 'integer'],
            [['vote', 'message'], 'string', 'max' => 3],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_id' => 'КОД ТЕМЫ',
            'user_id' => 'КОД ГРАЖДАНИНА',
            'vote' => 'ГОЛОСОВАЛ',
            'message' => 'КОММЕНТИРОВАЛ',
        ];
    }

    public static function find()
    {
        return new UserTopicStatusQuery(get_called_class());
    }
}
