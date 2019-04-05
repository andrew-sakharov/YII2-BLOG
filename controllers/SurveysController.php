<?php

namespace app\controllers;

use Yii;
use app\models\surveys\Surveys;
use app\models\SurveysSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SurveysController implements the CRUD actions for Surveys model.
 */
class SurveysController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
       
    public function actionDetail()
    {
        $showDetail = false;
        $model = new Surveys();
        if(isset($_POST['Surveys']))
        {
            $model->load( Yii::$app->request->post() );
            
            if(isset($_POST['Surveys']['user_id'])&&($_POST['Surveys']['user_id']!=null))
            {
                $model = Surveys::findOne($_POST['Surveys']['id']);
                $showDetail = true;
            }
        }
        return $this->render('ajaxdetail', [ 'model' => $model, 'showDetail' => $showDetail ]);
    }
    
    
    public function actionDropdownlistbyuserid($user_id)
    {
        $output = '';
        $items = Surveys::findAll(['user_id' => $user_id]);
        foreach($items as $item)
        {
            $content = sprintf('комментарий %s', $item->message);
            $output .= \yii\helpers\Html::tag('option', $content, ['value' => $item->id]);
        }
        return $output;
    }
    
    public function actionIndex()
    {
        $searchModel = new SurveysSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Surveys();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Surveys::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
