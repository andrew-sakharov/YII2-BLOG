<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\models\surveys\Topics;
use app\models\Role;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string  $email
 * @property string  $password
 * @property string  $first_name
 * @property string  $last_name
 * @property integer $role_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Post[] $posts
 * @property Role $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function setFullName($name)
    {
        list($firstName, $lastName) = explode(" ", $name);
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        
        return true;
    }

    public static function tableName()
    {
        return 'user';
    }
    
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['role_id', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['password'], 'validatePassword', 'on' => 'login'],
            
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'email'         => 'Email',
            'password'      => 'Password',
            'first_name'    => 'First Name',
            'last_name'     => 'Last Name',
            'role_id'       => 'Role ID',
            'created_at'    => 'Created At',
            'updated_at'    => 'Updated At',
        ];
    }
    
    public function getTopics()
    {
        return $this->hasMany(Topics::className(), ['author_id' => 'id']);
    }
    
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }
    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    public static function findByUseremail($email)
    {
        return User::findOne(['email' => $email])['id'];
        
    }
       
    public static function findIdentityByAccessToken($token, $type=null)
    {
        return static::findOne(['access_token' => $token]);
    }
    
    public function getAuthKey() {}
    
    public function validateAuthKey($authKey)
    {
        return true;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }
}
