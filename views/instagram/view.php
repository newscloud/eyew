<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Instagram */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instagrams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instagram-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'moment_id',
            'username',
            'link',
            'image_url:url',
            'text:ntext',
            'created_time:datetime',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
