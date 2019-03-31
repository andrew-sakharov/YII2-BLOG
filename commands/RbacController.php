<?php
namespace app\commands;
use Yii;
use yii\console\Controller;
use app\models\User;
use app\rbac\AuthorRule;

class RbacController extends Controller
{
public function actionInit()
{
    $auth = Yii::$app->authManager;
    $auth->removeAll();
    
    $createTopic = $auth->createPermission('createTopic');
    $createTopic->description = 'Создать Тему';
    $auth->add($createTopic);
    
    $updateTopic = $auth->createPermission('updateTopic');
    $updateTopic->description = 'Обновить Тему';
    $auth->add($updateTopic);
    
    $adminApp = $auth->createPermission('adminApp');
    $adminApp->description = 'Администрировать приложение';
    $auth->add($adminApp);
    
    $commentTopic = $auth->createPermission('commentTopic');
    $commentTopic->description = 'Комментировать Тему';
    $auth->add($commentTopic);
        
    $reader = $auth->createRole('reader');
    $auth->add($reader);
    $auth->addChild($reader, $commentTopic);
    
    $authorRule = new AuthorRule(); 
    $auth->add($authorRule);
    
    $author = $auth->createRole('author');
    $auth->add($author);
    $auth->addChild($author, $createTopic);
    $auth->addChild($author, $reader);
    
    $admin = $auth->createRole('admin');
    $auth->add($admin);
    $auth->addChild($admin, $adminApp);
    $auth->addChild($admin, $updateTopic);
    $auth->addChild($admin, $author);
    
    $updateOwnTopic = $auth->createPermission('updateOwnTopic');
    $updateOwnTopic->description = 'Обновить собственную Тему';
    $updateOwnTopic->ruleName = $authorRule->name;
    $auth->add($updateOwnTopic);
    
    $auth->addChild($updateOwnTopic, $updateTopic);
    $auth->addChild($author, $updateOwnTopic);
 
    $auth->assign($admin, User::findByUseremail('admin@example.com'));
    $auth->assign($author, User::findByUseremail('vasin@example.com'));
    $auth->assign($author, User::findByUseremail('petrov@example.com'));
    $auth->assign($reader, User::findByUseremail('kozin@example.com'));
    
    echo "Выполнено!\n";
}
}
