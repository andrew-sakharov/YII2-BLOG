<?php
/*
 * Демо пример реализации Ajax, JQuery< JS в среде YII2
 *  - динамическое формирование значений и выбор в связанных списках 
 *  - всплывающие подсказки
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\surveys\Surveys;
use app\models\SurveysSearch;
use app\models\User;
?>

<?php
$this->registerCss( <<< EOT_CSS
<style type="text/css">
.tip{
    position:absolute;  
    background:lightgoldenrodyellow;
    padding:6px;        
}
.tooltip{
    padding:30px;
    background:rgb(145, 159, 255);
}
</style>           
EOT_CSS
);
?>

<?php
$urlSurveysByUser = Url::to(['surveys/dropdownlistbyuserid']);

$this->registerJs( <<< EOT_JS

    $(document).on('change', '#surveys-user_id', function(ev) { // динамичеси формировать список выбора                       
        $('#detail').hide();                                    
        var userId = $(this).val();            
        $.get(
            '{$urlSurveysByUser}',
            { 'user_id' : userId },
            function(data) {
                data = '<option value="">--- Выбор</option>'+data;
                $('#surveys-id').html(data);
            }
        )
        ev.preventDefault();
    });    
    $(document).on('change', '#surveys-id', function(ev) {
        $(this).parents('form').submit();    
        ev.preventDefault();
    });    

    $(document).on('mouseover', '#surveys-user_id, #surveys-id', function(e) { // формировать подсказку  
        var text = "";
        if ($(this).attr("name") == "Surveys[user_id]") {var text = "Выберите участника обсуждения";}
        if ($(this).attr("name") == "Surveys[id]") {var text = "Выберите комментарий";}
        $('<span class="tip"></span>')  // расчёт координат и собственно отображение всплавающей подсказки
          .text(text) 
          .insertAfter(this)
          .css({
            'top': (e.offsetY - 30) + 'px',
            'left': (e.offsetX + 20) + 'px', 
            'display':'none'
          })
          .fadeIn("fast");               
    });
    $(document).on('mouseleave', '#surveys-user_id, #surveys-id', function() {  // удалить подсказку 
        $('.tip').fadeOut("fast", function(){ $(this).remove()});                 
    });

EOT_JS
);
?>


<div class="customer-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => false, 'options' => ['data-pjax' => '']]); ?>
    <?php $user = User::find()->all(); ?>
    
    <?= $form->field($model, 'user_id', ['options'=>['class'=>'form-group col-sm-2'],] )->label('Пользователь')
    ->dropDownList(ArrayHelper::map( $user, 'id', 'last_name'), [ 'prompt' => '--- Выберите' ]) ?>       
    <?php   $surveys = Surveys::findAll(['user_id' => $model->user_id]); ?>
    <?= $form->field($model, 'id', ['options'=>['class'=>'form-group col-sm-8'],])->label('Комментарий')
    ->dropDownList(ArrayHelper::map( $surveys, 'id', function($temp, $defaultValue) {
        $content = sprintf('комментарий %s', $temp->message);
        return $content;
    }), [ 'prompt' => '--- Выберите' ]); ?>
    
    <?php ActiveForm::end(); ?>
</div>
