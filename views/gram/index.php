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
        <?= Html::a('Create Instagram', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'moment_id',
            'username',
            'link',
            'image_url:url',
            // 'text:ntext',
            // 'created_time:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
