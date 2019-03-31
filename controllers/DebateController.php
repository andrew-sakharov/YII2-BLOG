<?php

namespace app\controllers;
use Yii;
use app\models\surveys\Topics;
use app\models\TopicsSearch;
use app\models\surveys\Surveys;
use app\models\surveys\UserTopicStatus;
use app\models\SurveysSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\repositories\Getsurveys;
use app\repositories\Getlastsurveys;

class DebateController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {       
        $queryGetlastsurveys = new Getlastsurveys();
        $surveys = $queryGetlastsurveys ();        
        $query = Topics::find();
        $debate = $query->all();        
        return $this->render('index', [ 'debate' => $debate, 'surveys' => $surveys]);              
    }

    public function actionView($id)
    {   
        
        /* *******************************************************
        Бизес логика:
        - голосовать можно только один раз
        - комментировать можно только один раз
        - кнопка против доступна только после того, как пользователь оставил свой комментарий
        - можно оставить комментарий, но не голосовать
        - голосовать и комментировать могут только зарегистрированные пользователи
        ******************************************************* */
        
        $debate = Topics::find()->where(['id' => $id])->one();           
        $surveys_count = Surveys::find()->where(['topic_id' => $id])->count();        
        $queryGetsurveys = new Getsurveys();
        $surveys = $queryGetsurveys ($id, $surveys_count);                   
        $votefl = '';       
        $vote = Yii::$app->request->get('vote');       
        if(isset($vote)) {        
            $votefl = 'disabled';
            // отметить, что пользователь проголосовал по данной теме
            $modelUserTopicStatus = new UserTopicStatus();
            $modelUserTopicStatus->topic_id = $surveys[0]['topic_id'];
            $modelUserTopicStatus->user_id = Yii::$app->user->id;
            $modelUserTopicStatus->vote = 'yes';
            $modelUserTopicStatus->save();   
            //  Учесть результат голосования
            $model = $this->findModel($id);
            if ($vote == 'yes')
                $model->surveys_result_yes = $model->surveys_result_yes + 1;
            if ($vote == 'no')
                $model->surveys_result_no = $model->surveys_result_no + 1;
            if ($vote == 'abstain')
                $model->surveys_result_abstain = $model->surveys_result_abstain + 1;    
            $model->save();
        }       
        $count = 0;
        if (empty($surveys) != TRUE) {
            $count = UserTopicStatus::find()
            ->where(['topic_id' => $surveys[0]['topic_id'], 'user_id' => Yii::$app->user->id, 'vote' => 'yes'])
            ->count();
            if ($count > 0) {   // есть отметка, что пользователь проголосовал по данной теме
                $votefl = 'disabled';
            }
        }        
        $comment = '';
        $votefl_comment = '';                        
        $comment_allow = 'yes';
        $comment = Yii::$app->request->get('comment');
        if (Yii::$app->request->get('close_message') == 'yes') { // закрыть окно ввода комментприя
            $comment = '';
        }       
        if($comment == 'yes') {
            $modelsurvey = new Surveys();           
            $modelsurvey->load(Yii::$app->request->post());
            if (strlen($modelsurvey->message) > 5) { // осмысленный комментарий введён (6+ символов)
                $modelsurvey->topic_id = $id;                
                $modelsurvey->user_id = Yii::$app->user->id;                
                $modelsurvey->save();                
                $model = $this->findModel($id);
                $model->surveys_count = $model->surveys_count + 1;
                $surveys = $queryGetsurveys ($id, $surveys_count);
                $model->save();
                $comment_allow = 'no';                
                // отметить, что пользователь прокомментировал данную тему
                $modelUserTopicStatus = new UserTopicStatus();
                $modelUserTopicStatus->topic_id = $id;
                $modelUserTopicStatus->user_id = Yii::$app->user->id;
                $modelUserTopicStatus->message = 'yes';                
                $modelUserTopicStatus->save();               
                $votefl_comment = 'disabled';
            }
        }       
        $votefl_no = 'disabled';
        $count = 0;
        if (empty($surveys) != TRUE) {
        $count = UserTopicStatus::find()
        ->where(['topic_id' => $surveys[0]['topic_id'], 'user_id' => Yii::$app->user->id, 'message' => 'yes'])
        ->count();
        if ($count > 0) {
            $comment = 'no'; // комментарий данного пользователя уже существует
            $votefl_comment = 'disabled';
            if ($votefl != 'disabled') {    // уточнить статус для кнопки NO
                $votefl_no = '';
            }            
        }
        }        
        return $this->render('view', [ 'debate' => $debate, 'surveys' => $surveys, 'votefl_no' => $votefl_no,
        'votefl' => $votefl, 'votefl_comment' => $votefl_comment, 'comment' => $comment, 'comment_allow' => $comment_allow]);  
    }

    protected function findModel($id)
    {
        if (($model = Topics::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
