<?php

namespace app\controllers;

use Yii;
use app\models\Moment;
use app\models\MomentSearch;
use app\models\Gram;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * MomentController implements the CRUD actions for Moment model.
 */
class MomentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Moment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MomentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Moment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionBrowse($id)
    {
      // browse instagram results for moment $id
      $dataProvider = new ActiveDataProvider([
          'query' => Gram::find()->where(['moment_id'=>$id])->orderBy('created_time ASC')
      ]);

      return $this->render('browse', [
          'dataProvider' => $dataProvider,
          'moment_id'=>$id,
      ]);
    }
    public function actionPurge($id)
    {
        Moment::purge($id);
        Yii::$app->session->setFlash('success', 'Results purged successfully.');
         return $this->redirect('index');
    }
    
    public function actionInstagram($id)
      {
          $model = $this->findModel($id);
          $model->searchInstagram();
          return $this->redirect(['browse', 'id' => $model->id]);  
      }
    /**
     * Creates a new Moment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Moment();
         if ($model->load(Yii::$app->request->post())) {
            // convert date time to timestamp
            $model->start_at = strtotime($model->start_at);
            // adjust for GMT
            $model->start_at+=(3600*8);
            // validate the form against model rules
            if ($model->validate()) {
                // all inputs are valid
                $model->save();              
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
              return $this->render('create', [
                  'model' => $model,
              ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Moment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $original_date = $model->start_at;
        if (is_numeric($model->start_at)) {
          $model->start_picker_at = $model->start_at;
          $model->start_at = date('D, d M Y H:i:s O',$model->start_at);
        }
        // convert date time to timestamp
        if ($model->load(Yii::$app->request->post())) {
          // convert date time to timestamp
          $model->start_at = strtotime($model->start_at);
          if ($model->start_at <> $original_date) {
            // if new date selected, adjust for GMT
            $model->start_at+=(3600*8);
          }
          // validate the form against model rules
          if ($model->validate()) {
              // all inputs are valid
              $model->save();              
            return $this->redirect(['index']);
          } else {
              return $this->render('update', [
                  'model' => $model,
              ]);
          }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Moment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Moment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Moment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Moment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
     
}
