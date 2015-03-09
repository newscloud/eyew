<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Twitter */

$this->title = 'Update Twitter: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Twitters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="twitter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
