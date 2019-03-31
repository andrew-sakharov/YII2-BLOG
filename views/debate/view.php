<?php
$this->registerCss( <<< EOT_CSS
    #comment {
    position: absolute;	/* Абсолютное позиционирование */
    width: 60%; /* Ширина слоя в пикселах */
    height: 47%; /* Положение слоя от левого края */
    left: 25%; /* Положение слоя от левого края */
    top: 30%; /* Положение слоя от верхнего края */
    margin-left: 0px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 1px black; /* Параметры рамки вокруг */
    padding: 1px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    }   
    #left_top {
    position: absolute;	/* Абсолютное позиционирование */
    width: 60%; /* Ширина слоя в пикселах */
    height: 11%; /* Высота слоя в пикселах */
    left: 0%; /* Положение слоя от левого края */
    top: 12%; /* Положение слоя от верхнего края */
    margin-left: 10px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 0px black; /* Параметры рамки вокруг */
    padding: 10px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    } 
    #left {
    position: absolute;	/* Абсолютное позиционирование */
    width: 60%; /* Ширина слоя в пикселах */
    height: 78%; /* Высота слоя в пикселах */
    left: 0%; /* Положение слоя от левого края */
    top: 20%; /* Положение слоя от верхнего края */
    margin-left: 10px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 1px black; /* Параметры рамки вокруг */
    padding: 10px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    }   
    #right_top {
    position: absolute;	/* Абсолютное позиционирование */
    width: 38%; /* Ширина слоя в пикселах */
    height: 11%; /* Высота слоя в пикселах */
    left: 63%; /* Положение слоя от левого края */
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
    width: 36%; /* Ширина слоя в пикселах */
    height: 74%; /* Высота слоя в пикселах */
    left: 62%; /* Положение слоя от левого края */
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
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use app\models\surveys\SurveyAnswer;
use app\models\surveys\Surveys;
?>

<?php     
$this->title = 'Update Topics: ' . $debate['id'];
$this->params['breadcrumbs'][] = ['label' => 'Темы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Обсуждение', 'url' => ['view', 'id' => $debate['id']]];
$this->params['breadcrumbs'][] = $debate['title'];
?>

<div id="left_top">
    <?php $variant = 'btn btn-primary ' . $votefl; 
    $variant_no = 'btn btn-primary ' . $votefl_no; 
    if (!Yii::$app->user->can('commentTopic')) { // Голосовать и комментировать могут только зарегистрированные пользователи
        $variant = $variant_no = 'btn btn-primary disabled'; 
        $votefl_comment = ' disabled';
    } ?> 
    <h3><b>Голосовать</b><?php echo ' '?>
        <?= Html::a('ПОДДЕРЖИВАЮ',   ['view', 'id' => $debate['id'], 'vote' => 'yes'],     ['class' => $variant, 'title' =>"Поддерживаю"]) ?><?php echo ' '?> 
        <?= Html::a('ВОЗДЕРЖИВАЮСЬ', ['view', 'id' => $debate['id'], 'vote' => 'abstain'], ['class' => $variant, 'title' =>"Воздерживаюсь"]) ?><?php echo ' '?> 
		<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Для активизации Кнопки создайте свой Комментарий">
        <?= Html::a('ПРОТИВ',        ['view', 'id' => $debate['id'], 'vote' => 'no'],      ['class' => $variant_no, 'title' =>"Против"]) ?> 
		</span>         
    </h3>    
</div>

<div id="left">

	<h4><b><?php echo 'Тема: ' . $debate['title'] . ' '; ?>
	<?php echo '<i><a href="' . Url::to('@web/', true) . 'uploads/' . $debate['doc_name'] . '" target="_blank">' . ' (открыть в PDF)' . '</a></i>';?>
	</b></h4>
	<p align="right">
	<?php echo $debate['create_date']; ?><br />	
    <?php echo ' Результаты голосования: '; echo Html::tag('span', '', ['class' => "glyphicon glyphicon-plus-sign"]); echo ' ';?>
    <?php echo $debate['surveys_result_yes'] . ' ' ?>
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-minus-sign"]); echo ' ';?>
    <?php echo $debate['surveys_result_no'] . ' ' ?>
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-question-sign"]); echo ' ';?>
    <?php echo $debate['surveys_result_abstain'] . ' ' ?>    
    <?php  echo ' Комментариев: '; echo Html::tag('span', '', ['class' => "glyphicon glyphicon-comment"]) . ' ' . $debate['surveys_count']; ?>
    </p>
    <h4><b><?php echo $debate['topic']; ?></b></h4>
</div>

<div id="right_top">
    <?php $variant = 'btn btn-primary ' . $votefl; ?> 
    <h3><b>Комментировать</b><?php echo ' '?>
    <?php $variant_comment = 'btn btn-primary ' . $votefl_comment; ?>
    <?= Html::a('СОЗДАТЬ КОММЕНТАРИЙ',   ['view', 'id' => $debate['id'], 'comment' => 'yes'],     ['class' => $variant_comment]) ?><?php echo ' '?>    
	</h3>    
</div>

<div id="right">

	<?php if (empty($surveys) != TRUE) { ?>
	<?php foreach($surveys as $survey) { ?>
	<p align="right">
    <?php echo Html::tag('span', '', ['class' => "glyphicon glyphicon-user"]) . ' ' . $survey['user_name']?> 
    <?php echo $survey['create_date']; ?></p>
    <?php echo $survey['message']?>    
    <br /><br />
 	<?php } ?>
 	<?php } ?>
</div>

<?php if ($comment == 'yes' and $comment_allow == 'yes') { ?>
	<div id="comment"> 
		<?php
        $modelsurvey = new Surveys();
        $form = ActiveForm::begin();
        ?>
        	<?= $form->field($modelsurvey, 'message')->textarea(['rows' => '14']) ?>
        	<div class="form-group">
            	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?><?php echo ' '?>
            	<?= 
            	   Html::a('Закрыть',        ['view', 'id' => $debate['id'], 'close_message' => 'yes'],      
            	   ['class' => 'btn btn-primary']); 
            	?>    
        	</div>
    	<?php ActiveForm::end(); ?>  
	</div>
<?php } ?>
 
 
