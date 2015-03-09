<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TwitterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Twitters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="twitter-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Twitter', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'moment_id',
            'tweet_id',
            'twitter_id',
            'screen_name',
            // 'text:ntext',
            // 'link',
            // 'tweeted_at',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
