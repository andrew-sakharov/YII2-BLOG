
<?php

$this->registerCss( <<< EOT_CSS
    #menu {
    position: absolute;	/* Абсолютное позиционирование */
    width: 100%; /* Ширина слоя в пикселах */
    height: 5%; /* Высота слоя в пикселах */
    top: 0%; /* Положение слоя от верхнего края */
    margin-left: 0px; /* Отступ слева, включает padding и border */
    margin-top: 0px;	/* Отступ сверху */
    background: #fff; /* Цвет фона */
    border: solid 1px black; /* Параметры рамки вокруг */
    padding: 1px; /* Поля вокруг текста */
    overflow: auto; /* Добавление полосы прокрутки */ 
    }     
EOT_CSS
);
?>

<?php
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Role;
use app\models\User;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div class="wrap">
<?php    
    NavBar::begin([
        //'brandLabel' => 'Макет Форума',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-inverse navbar-fixed-top',],
        
    ]);  
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Блог', 'url' => ['/debate/index']],
                                    
          Yii::$app->user->can('createTopic')  ? (
             ['label' => 'Темы', 'url' => ['/topics/index']]
             ) : (''),
            
          Yii::$app->user->can('admin')  ? (
             ['label' => 'Администрирование',
                'items' => [
                    ['label' => 'Права', 'url' => ['/rbac/test']],
                    ['label' => 'Upload', 'url' => ['/topics/upload']],
                    ['label' => 'Опросы', 'url' => ['/surveys/index']],
                    ['label' => 'Комментарии', 'url' => ['/surveys/detail']],
                    ['label' => 'Пользователи', 'url' => ['/user/index']],
                ]]
           ) : (''),
            
            Yii::$app->user->isGuest ? (
                ['label' => 'Регистрация', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->email . ')',
                        ['class' => 'btn btn-link logout']
                        )
                    . Html::endForm()
                    . '</li>'
                    )
        ],
    ]);
    NavBar::end();     
    
?>    
<div class="container">    
<?php $home_img = Yii::$app->homeUrl . "../../image/home2.jpg";  ?>
    
<?= Breadcrumbs::widget([
    'encodeLabels' => false,
    'homeLink' => [
        'label' => "<img src=$home_img >",
        'url' => Yii::$app->homeUrl
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
               
	<?= Alert::widget() ?>
    <?= $content ?>
</div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-right">&copy; Форум <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
