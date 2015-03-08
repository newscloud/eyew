<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstagramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Instagrams';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instagram-index">

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
              'attribute' => 'username',
              'format' => 'raw',
              'value' => function ($model) {                      
                      return '<div><a href="https://instagram.com/'.$model->username.'">'.$model->username.'</a></div>';
              },
          ],
          [
            'label' => 'Post',
              'attribute' => 'image_url',
              'format' => 'raw',
              'value' => function ($model) {                      
                      return '<div><a href="'.$model->link.'"><img style="float:right;margin:5px;" width="75px" src="'.$model->image_url.'" /></a>'.$model->text.' '.'<a href="'.$model->link.'">link</a></div>';
              },
          ],
          [
              'label' => 'Time',
              'attribute' => 'created_time',
              'format' => 'raw',
              'value' => function ($model) {                      
                      return '<div>'.date('M j, Y G:i a',($model->created_time-(8*3600))).'</div>';
              },
          ],
          //'created_time:datetime',
            //'link:url',
            //'image_url:image',
            // 'text:ntext',
        ],
    ]); ?>

</div>
