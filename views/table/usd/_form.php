<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\system\Usd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_usd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dns_name')->textInput(['maxlength' => true]) ?>

    <?php
         $items3 = array("1" => "Работает", "0" => "Отключено");
         echo $form->field($model, 'work_usd')->dropDownList($items3);
         ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pass')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
