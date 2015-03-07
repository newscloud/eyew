<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Moment */

$this->title = 'Create Moment';
$this->params['breadcrumbs'][] = ['label' => 'Moments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
