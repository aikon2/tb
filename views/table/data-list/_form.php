<?php

namespace app\models\system;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\system\DataList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
   <div class="col-lg-5">
      <div class="data-list-form">

         <?php $form = ActiveForm::begin(); ?> 

         <?php
         //Получаем все приборы
         $d1 = Device::find()->orderBy('name_device')->all();
         //Формируем массив с ключем равным полю 'id' и значением равным полю 'name'
         $items1 = ArrayHelper::map($d1, 'id', 'name_device');
         $params1 = [
             'prompt' => 'Выберите прибор',
         ];
         echo $form->field($model, 'id_device')->dropDownList($items1, $params1);
         ?> 

         <?php
         //Получаем все каналы
         $d2 = DataRef::find()->orderBy('name_ref')->all();
         //Формируем массив с ключем равным полю 'id' и значением равным полю 'name'
         $items2 = ArrayHelper::map($d2, 'id', 'name_ref');
         $params2 = [
             'prompt' => 'Выберите',
         ];
         echo $form->field($model, 'id_data_ref')->dropDownList($items2, $params2);
         ?> 


         <?= $form->field($model, 'number')->textInput() ?>

         <?= $form->field($model, 'time_point')->textInput() ?>

         <?php
         $items3 = array("1" => "Работает", "0" => "Отключено");
         echo $form->field($model, 'work_data')->dropDownList($items3);
         ?>

         <div class="form-group">
         <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>

         <?php ActiveForm::end(); ?>

      </div>
   </div>
</div>
