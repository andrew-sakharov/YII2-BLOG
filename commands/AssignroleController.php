<?php

namespace app\commands;
use app\models\User;
use Yii;
use yii\console\Controller;


class AssignroleController extends Controller
{
    public function actionInit()
{    
    $auth = \Yii::$app->authManager;
    $role = $auth->getRole('viewTopic');
    $auth->assign($role, User::findOne([ 'email' => 'kozin@example.com']));   
}
}
