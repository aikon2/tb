<?php

namespace app\models\system;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

//use app\models\system\TypeDevice;

/* @var $this yii\web\View */
/* @var $model app\models\system\Device */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-form">

   <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'name_device')->textInput(['maxlength' => true]) ?>

   <?php
   //Получаем все типы   
   $typed = TypeDevice::find()->orderBy('name_type')->all();
   //Формируем массив с ключем равным полю 'id' и значением равным полю 'name'
   $items1 = ArrayHelper::map($typed, 'id', 'name_type');
   $params1 = [
       'prompt' => 'Выберите тип',
   ];
   echo $form->field($model, 'id_type_device')->dropDownList($items1, $params1);
   ?>    

   <?= $form->field($model, 'serial')->textInput(['maxlength' => true]) ?>

   <?php
   //Получаем все усд   
   $usd = Usd::find()->orderBy('name_usd')->all();
   //Формируем массив с ключем равным полю 'id' и значением равным полю 'name'
   $items2 = ArrayHelper::map($usd, 'id', 'name_usd');
   $params2 = [
       'prompt' => 'Выберите сборщик',
   ];
   echo $form->field($model, 'id_usd')->dropDownList($items2, $params2);
   ?>

   <?php
   $items3 = array("1"=>"Работает","0"=>"Отключено");
   echo $form->field($model, 'work_device')->dropDownList($items3);
   ?>

   <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   </div>

   <?php ActiveForm::end(); ?>

</div>
