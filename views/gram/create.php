<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Instagram */

$this->title = 'Create Instagram';
$this->params['breadcrumbs'][] = ['label' => 'Instagrams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instagram-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
