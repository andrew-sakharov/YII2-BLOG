

<?php

$this->registerCss( <<< EOT_CSS
    #comment {
    position: absolute;	/* Абсолютное позиционирование */
    width: 50%; /* Ширина слоя в пикселах */
    height: 35%; /* Положение слоя от левого края */
    left: 25%; /* Положение слоя от левого края */
    top: 40%; /* Положение слоя от верхнего края */
    margin-left: 0px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 1px black; /* Параметры рамки вокруг */
    padding: 1px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    }   
    #left_top {
    position: absolute;	/* Абсолютное позиционирование */
    width: 40%; /* Ширина слоя в пикселах */
    height: 11%; /* Высота слоя в пикселах */
    left: 0%; /* Положение слоя от левого края */
    top: 13%; /* Положение слоя от верхнего края */
    margin-left: 10px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 1px black; /* Параметры рамки вокруг */
    padding: 10px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    } 
    #left {
    position: absolute;	/* Абсолютное позиционирование */
    width: 40%; /* Ширина слоя в пикселах */
    height: 74%; /* Высота слоя в пикселах */
    left: 0%; /* Положение слоя от левого края */
    top: 25%; /* Положение слоя от верхнего края */
    margin-left: 10px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 1px black; /* Параметры рамки вокруг */
    padding: 10px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    }   
    #right_top {
    position: absolute;	/* Абсолютное позиционирование */
    width: 58%; /* Ширина слоя в пикселах */
    height: 11%; /* Высота слоя в пикселах */
    left: 41%; /* Положение слоя от левого края */
    top: 13%; /* Положение слоя от верхнего края */
    margin-left: 5px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 0px black; /* Параметры рамки вокруг */
    padding: 10px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    } 
    #right {
    position: absolute;	/* Абсолютное позиционирование */
    width: 58%; /* Ширина слоя в пикселах */
    height: 74%; /* Высота слоя в пикселах */
    left: 41%; /* Положение слоя от левого края */
    top: 25%; /* Положение слоя от верхнего края */
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
use yii\widgets\ActiveForm;
use app\models\surveys\SurveyAnswer;
use app\models\surveys\Surveys;
?>

<div id="top">
    <?php $this->params['breadcrumbs'][] = 'Тема'; ?>
    <h3><b><?= Html::encode($this->title) ?></b></h3>
</div>

<div id="left_top">
    <?php $variant = 'btn btn-primary ' . $votefl; ?> 
    <?php $variant_no = 'btn btn-primary ' . $votefl_no; ?> 
    <h3><b>Голосовать</b><?php echo ' '?>
        <?= Html::a('ПОДДЕРЖИВАЮ',   ['view', 'id' => $debate['id'], 'vote' => 'yes'],     ['class' => $variant, 'title' =>"Поддерживаю"]) ?><?php echo ' '?> 
        <?= Html::a('ВОЗДЕРЖИВАЮСЬ', ['view', 'id' => $debate['id'], 'vote' => 'abstain'], ['class' => $variant, 'title' =>"Воздерживаюсь"]) ?><?php echo ' '?> 
		<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Для активизации Кнопки создайте свой Комментарий">
        <?= Html::a('ПРОТИВ',        ['view', 'id' => $debate['id'], 'vote' => 'no'],      ['class' => $variant_no, 'title' =>"Против"]) ?> 
		</span>         
    </h3>    
</div>

<div id="left">
	<h3><b>Материалы по теме</b></h3>
	<?php echo date_create_from_format('Y-m-d H:i:s', $debate['create_date'])->format('d-M-Y'); ?><br />
	<h4><b><?php echo $debate['topic']; ?></b></h4>
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-plus-sign"]); echo ' ';?>
    <?php echo $debate['surveys_result_yes'] . ' ' ?>
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-minus-sign"]); echo ' ';?>
    <?php echo $debate['surveys_result_no'] . ' ' ?>
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-question-sign"]); echo ' ';?>
    <?php echo $debate['surveys_result_abstain'] . ' ' ?>    
    <p align="right">
    	<?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-comment"]) . ' Коментариев ' . $debate['surveys_count']; ?>
    </p>
</div>

<div id="right_top">
    <?php $variant = 'btn btn-primary ' . $votefl; ?> 
    <h3><b>Комментировать</b><?php echo ' '?>
    <?php $variant_comment = 'btn btn-primary ' . $votefl_comment; ?>
    <?= Html::a('СОЗДАТЬ КОММЕНТАРИЙ',   ['view', 'id' => $debate['id'], 'comment' => 'yes'],     ['class' => $variant_comment]) ?><?php echo ' '?>    
	</h3>    
</div>

<div id="right">
	<?php foreach($surveys as $survey) { ?>
       	<?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-user"]) . ' ' . $survey['user_name']?> <br />
       	<?php echo date_create_from_format('Y-m-d H:i:s', $survey['create_date'])->format('d-M-Y'); ?>   	
        <?php echo $survey['message']?>    
    	<br /><br />
 	<?php } ?>
</div>

<?php if ($comment == 'yes' and $comment_allow == 'yes') { ?>
	<div id="comment"> 
		<?php
        $modelsurvey = new Surveys();
        $form = ActiveForm::begin();?>
        	<?= $form->field($modelsurvey, 'message')->textarea(['rows' => '10']) ?>
        	<div class="form-group">
            	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?><?php echo ' '?>
            	<?= Html::a('Закрыть',        ['view', 'id' => $debate['id'], 'close_message' => 'yes'],      ['class' => 'btn btn-primary']) ?>    
        	</div>
    	<?php ActiveForm::end(); ?>  
	</div>
<?php } ?>
 
 
