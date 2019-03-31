<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\surveys\Topics */

$this->title = 'Редактировать Тему: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Тема', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="topics-update">
<?php 
    $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
    if (array_key_exists('author', $role)) {$role_name = 'author'; }
    if (Yii::$app->user->can('updateTopic') or ($role_name =='author' and Yii::$app->user->id == $model->author_id)) { 
?>        
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', ['model' => $model, ]) ?>   
<?php  } ?>
</div>
