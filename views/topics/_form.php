<?php
$this->registerCss( <<< EOT_CSS
    #topic_body {
    position: absolute;	/* Абсолютное позиционирование */
    width: 95%; /* Ширина слоя в пикселах */
    height: 50%; /* Положение слоя от левого края */
    left: 5%; /* Положение слоя от левого края */
    top: 20%; /* Положение слоя от верхнего края */
    margin-left: 0px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 0px black; /* Параметры рамки вокруг */
    padding: 1px; /* Поля вокруг текста */

    }     
EOT_CSS
);
?>

<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\surveys\Topics */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="topic_body">

<?php 
$form = ActiveForm::begin([
    'id' => 'test-form',

    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
    'template' => '<div class="col-md-2">{label}</div><div class="col-md-7">{input}</div><div class="col-md-6">{error}</div>',
    ],
    ]); 
    $surveys_allowed[0] = 'Разрешить';
    $surveys_allowed[1] = 'Запретить';
    ?>
    
    <?= $form->field($model, 'surveys_allowed')->inline(false)->label('Разрешить голосование?')->radioList($surveys_allowed)  ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Название') ?>
    <?= $form->field($model, 'doc_name')->textInput(['maxlength' => true])->label('Прикреплённыё документ') ?>
    <?= $form->field($model, 'topic')->textarea(['maxlength' => true, 'rows' => '10'])->label('Анотация Темы') ?>
    
    <?= $form->field($model, 'file')->fileInput()->label('Прикрепить документ') ?>
    <?= Html::beginForm('', 'post', ['enctype'=>'multipart/form-data'])?>
       
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    
</div>
