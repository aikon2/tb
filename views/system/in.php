<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\system;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
//use yii\data\ActiveDataProvider;

$this->title = 'Загрузка данных';
$this->params['breadcrumbs'][] = ['label' => 'Система', 'url' => ['/system/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-form">

   <?php $form = ActiveForm::begin(); ?>

   <?php
   //Получаем все приборы
   $devices = $model->find()->orderBy('name_device')->all();
   //Формируем массив с ключем равным полю 'id' и значением равным полю 'name'
   $items = ArrayHelper::map($devices, 'id', 'name_device');
   $params = [
       'prompt' => 'Выберите прибор',
   ];
   echo $form->field($model, 'id')->dropDownList($items, $params);
   ?>      

   <div class="form-group">
      <?= Html::submitButton('Получить', ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>   

   <?php
   if ($r != NULL) {
      echo GridView::widget([
      'dataProvider' => $dataProvider,
      'columns' => [
      'id',
      'dataRef',
      'number',
      'time_point'
      ],
      ]);
      //$newd = DataList::find()->where(['id_device'=>$r])->asArray;
      echo var_dump($qwery);
   }
   
   
   ?>

</div>