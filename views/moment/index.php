<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MomentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Moments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
    if(Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
            <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
            <?php endif; ?>
    
    <p>
        <?= Html::a('Create Moment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'latitude',
            'longitude',
            'distance',
            'start_at',
            'duration',
            ['class' => 'yii\grid\ActionColumn',
				      'template'=>'{instagram} {update} {delete} {purge}',
					    'buttons'=>[
              'instagram' => function ($url, $model) {     
                return Html::a('<span class="glyphicon glyphicon-camera"></span>', '/eyew/moment/instagram?id='.$model->id, ['title' => 'Search Instagram',]);	
					      },
                'purge' => function ($url, $model) {     
                  return Html::a('<span class="glyphicon glyphicon-erase"></span>', '/eyew/moment/purge?id='.$model->id, ['title' => 'Purge results','data-confirm' => 'Are you sure you want to purge all your past search results?']);	
  					      },
/*                
'view' => function ($url, $model) {     
                  return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'view?id='.$model->id, ['title' => 'View',]);	
						      }
						      */
							],
			      ],
        ],
    ]); ?>

</div>
