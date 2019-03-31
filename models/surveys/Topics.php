<?php

namespace app\models\surveys;

use Yii;
use yii\db\BaseActiveRecord;
use app\models\User;
use yii\base\Model;
use yii\web\UploadedFile;

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
 * @property int $author_id АВТОР
 * @property string $title
 * @property string $doc_name
 * @property string $doc_file
 * @property Surveys[] $surveys
 */

class Topics extends \yii\db\ActiveRecord
{
    public $file;
    
    public static function tableName()
    {
        return 'topics';
    }

    public function rules()
    {
        return [
            [['create_date'], 'safe'],
            [['topic', 'title', 'doc_name', 'doc_file'], 'string'],
            [['author_id', 'surveys_allowed', 'surveys_count', 'surveys_result_yes', 'surveys_result_no', 'surveys_result_abstain'], 'integer'],
            ['file', 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'АВТОР',
            'create_date' => 'ДАТА СОЗДАНИЯ',
            'topic' => 'ТЕМА',
            'surveys_count' => 'КОММЕНТАРИЕВ',
            'surveys_allowed' => 'СТАТУС ОПРОСА',
            'surveys_result_yes' => 'ПОДДЕРЖИВАЮ',
            'surveys_result_no' => 'ПРОТИВ',
            'surveys_result_abstain' => 'ВОЗДЕРЖИВАЮСЬ',
            'title' => 'НАЗВАНИЕ',
            'doc_name' => 'СТАТЬЯ',
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {            
            $this->create_date = time();     
            $this->author_id = Yii::$app->user->id;
            return true;
        }
        else {
            $this->create_date = strtotime($this->create_date);
            return true;
        }        
    }
    
    public function afterFind()
    {
        $this->create_date = date('d-M-Y',$this->create_date);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getSurveys()
    {
        return $this->hasMany(Surveys::className(), ['topic_id' => 'id']);
    }
    
    public static function find()
    {
        return new TopicsQuery(get_called_class());
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Save file
     * @param UploadedFile|string $file
     * @param array $options
     * @return boolean|static
     */
    public static function saveAs($file, $options = [])
    {
        if (!($file instanceof UploadedFile)) {
            $file = UploadedFile::getInstanceByName($file);
        }
        $options['file'] = $file;
        $model = new static($options);
        return $model->save() ? $model : false;
    }
    
}
