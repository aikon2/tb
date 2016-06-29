<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\system\DataListSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_device') ?>

    <?= $form->field($model, 'id_data_ref') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'time_point') ?>

    <?php // echo $form->field($model, 'work_data') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
