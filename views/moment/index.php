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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
