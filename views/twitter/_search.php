<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TwitterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="twitter-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'moment_id') ?>

    <?= $form->field($model, 'tweet_id') ?>

    <?= $form->field($model, 'twitter_id') ?>

    <?= $form->field($model, 'screen_name') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'tweeted_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
