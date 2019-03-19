
<?php

$this->registerCss( <<< EOT_CSS
    #top {
    position: absolute;	/* Абсолютное позиционирование */
    width: 100%; /* Ширина слоя в пикселах */
    height: 10%; /* Положение слоя от левого края */
    top: 12%; /* Положение слоя от верхнего края */
    margin-left: 0px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 0px black; /* Параметры рамки вокруг */
    padding: 1px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    }   
    #left {
    position: absolute;	/* Абсолютное позиционирование */
    width: 70%; /* Ширина слоя в пикселах */
    height: 88%; /* Высота слоя в пикселах */
    left: 0%; /* Положение слоя от левого края */
    top: 12%; /* Положение слоя от верхнего края */
    margin-left: 10px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 0px black; /* Параметры рамки вокруг */
    padding: 10px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    }   
    #right {
    position: absolute;	/* Абсолютное позиционирование */
    width: 30%; /* Ширина слоя в пикселах */
    height: 88%; /* Высота слоя в пикселах */
    left: 71%; /* Положение слоя от левого края */
    top: 12%; /* Положение слоя от верхнего края */
    margin-left: 5px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 0px black; /* Параметры рамки вокруг */
    padding: 10px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    }   
   
EOT_CSS
);
?>


<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
?>

<div id="top">
<?php 
$this->params['breadcrumbs'][] = 'Обсуждения'; 
?>
<h3><b><?= Html::encode($this->title) ?></b></h3>
</div>

<div id="left">
<?php $this->title = 'Текущие обсуждения'; ?>
<h3><b><?= Html::encode($this->title) ?></b></h3>

<?php foreach($debate as $item) { ?>
    <br />
    <?php echo date_create_from_format('Y-m-d H:i:s', $item['create_date'])->format('d-M-Y'); ?>
<br /><h4> <b>

<?php
    echo '<a href="' . Yii::$app->homeUrl . '?r=debate%2Fview&id=' . $item['id'] . '">' . $item['topic'] . '</a>';
?> </b></h4>

    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-plus-sign"]); echo ' ';?>
    <?php echo $item['surveys_result_yes'] . ' ' ?>
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-minus-sign"]); echo ' ';?>
    <?php echo $item['surveys_result_no'] . ' ' ?>
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-question-sign"]); echo ' ';?>
    <?php echo $item['surveys_result_abstain'] . ' ' ?>
    
    <p align="right">
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-comment"]) . ' Коментариев ' . $item['surveys_count']; ?>
    </p>
<?php } ?>
</div>

<div id="right">

<h3><b>Последний комментарий</b></h3>

<?php foreach($surveys as $surveys_last) { ?>

   	<?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-user"]) . ' ' . $surveys_last['user_name']?> <br />
   	<?php echo date_create_from_format('Y-m-d H:i:s', $surveys_last['create_date'])->format('d-M-Y'); ?>   	
    <br /><h5><i><b><?php echo $surveys_last['topic']?></b></i></h5>
    <?php echo $surveys_last['message']?>    
    <br /><br />
 <?php } ?>
</div>
