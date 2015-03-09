<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TwitterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tweets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="twitter-index">
  <?php 
  if(Yii::$app->session->hasFlash('error')): ?>
          <div class="alert alert-danger">
          <?php echo Yii::$app->session->getFlash('error'); ?>
          </div>
          <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Purge Results', ['/moment/purge?id='.$moment_id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
          [
              'label' => 'User',
              'attribute' => 'screen_name',
              'format' => 'raw',
              'value' => function ($model) {                      
                      return '<div><a href="https://twitter.com/'.$model->screen_name.'">'.$model->screen_name.'</a></div>';
              },
          ],
          [
            'label' => 'Tweet',
              'attribute' => 'text',
              'format' => 'raw',
              'value' => function ($model) {                      
                      return '<div>'.$model->text.' <a href="https://twitter.com/'.$model->screen_name.'/status/'.$model->tweet_id.'">link</a></div>';
              },
          ],
          [
              'label' => 'Created At',
              'attribute' => 'tweeted_at',
              'format' => 'raw',
              'value' => function ($model) {                      
                      return '<div>'.date('M j, Y G:i a',($model->tweeted_at-(8*3600))).'</div>';
              },
          ],
        ],
    ]); ?>

</div>
