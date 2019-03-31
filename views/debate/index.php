
<?php
$this->registerCss( <<< EOT_CSS
    #left {
    position: absolute;	/* Абсолютное позиционирование */
    width: 70%; /* Ширина слоя в пикселах */
    height: 81%; /* Высота слоя в пикселах */
    left: 0%; /* Положение слоя от левого края */
    top: 13%; /* Положение слоя от верхнего края */
    margin-left: 10px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 0px black; /* Параметры рамки вокруг */
    padding: 10px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    }   
    #right {
    position: absolute;	/* Абсолютное позиционирование */
    width: 27%; /* Ширина слоя в пикселах */
    height: 83%; /* Высота слоя в пикселах */
    left: 72%; /* Положение слоя от левого края */
    top: 16%; /* Положение слоя от верхнего края */
    margin-left: 5px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 1px black; /* Параметры рамки вокруг */
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

<?php  
    $this->title = 'Блог';
    $this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
?>

<div id="left">
<?php foreach($debate as $item) { ?>
<h3><b><?php echo '<a href="' . Yii::$app->homeUrl . '/debate/view?id=' . $item['id'] . '">' . $item['title'] . '</a>';?></b></h3>
<p align="right"><i><?php echo 'открыта ' . $item['create_date'];?></i></p>
<?php echo substr($item['topic'], 0, 2000)  ?> 
<p align="right"><br />
    <?php echo ' Результаты голосования: '; echo Html::tag('span', '', ['class' => "glyphicon glyphicon-plus-sign"]);?>
    <?php echo $item['surveys_result_yes'] . ' ' ?>
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-minus-sign"]); echo ' ';?>
    <?php echo $item['surveys_result_no'] . ' ' ?>
    <?php echo Html::tag('span', '', ['$surveysclass' => "glyphicon glyphicon-question-sign"]); echo ' ';?>
    <?php echo $item['surveys_result_abstain'] . ' ' ?>        
    <?php echo ' Комментариев: '; echo Html::tag('span', '', ['class' => "glyphicon glyphicon-comment"]) . ' ' . $item['surveys_count']; ?>
</p>
<?php } ?>
</div>

<div id="right">
<h3><b>Последние комментарии</b></h3><br />
<?php if (empty($surveys) != TRUE) { ?>
<?php foreach($surveys as $surveys_last) { ?>
    <h4><b><?php echo $surveys_last['topic'] ?></b></h4>
    <p align="right">
   	<?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-user"]) . ' ' . $surveys_last['create_date'] . ' ' . $surveys_last['user_name'];?> 	
    </p>
    <i><?php echo $surveys_last['message']?></i>    
    <br /><br />
 <?php } ?>
 <?php } ?>
</div>
