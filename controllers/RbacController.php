<?php

namespace app\controllers;

use app\models\User;
use stdClass;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;

class RbacController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['test'],
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    protected function renderAccess($description, $rule, $params = [])
    {
        $access = Yii::$app->user->can($rule, $params);

        return $description . ' : ' . ($access ? 'yes' : 'no');
    }

    public function actionTest()
    {        
        $post = new stdClass();
        $post->created_by = User::findByUseremail('vasin@example.com');
        
        if (\Yii::$app->user->can('updatePost', ['post' => $post])) {
            // update post
        }
        return $this->renderContent(
            Html::tag('h1', $aa).
            Html::ul([
                $this->renderAccess('Создать Тему', 'createTopic'),
                $this->renderAccess('Комментировать Тему', 'readTopic'),
                $this->renderAccess('Обновить собственную Тему', 'updateOwnTopic', ['post' => $post,]),
                $this->renderAccess('Обновить Тему', 'updateTopic'),
            ])
        );
    }
}
