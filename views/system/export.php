<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use app\components\FirstWidget;
use app\components\SecondWidget;
use yii\bootstrap\Modal;
use yii\jui\Datepicker;

?>

<?= FirstWidget::widget(
        [
            'a'=> 33,
            'b'=> 67
        ]
        ); ?>

<?php SecondWidget::begin() ?>

Этот текст сделаем красным

<?php SecondWidget::end(); ?>

<br>

<?php
Modal::begin([
    'header' => '<h2>Привет мир</h2>',
    'id'=>'newmodal',
    'toggleButton' => ['label' => 'жмакай'],
]);

echo 'Я говорю привет...';

Modal::end();
?>
<br>
<br>

<a data-toggle="modal" data-target="#newmodal" style="cursor: pointer">Еще раз</a><span class="glyphicon glyphicon-question-sign"></span>
<?php /*
 * А можно еще и через меню:
 * [
    'label' => 'Еще раз',
    'url' => [#],
    'linkOptions' => [
        'data-toggle' => 'modal',
        'data-target' => '#newmodal',
        'style' => 'cursor: pointer; outline: none;'
    ],
],
 *  */ ?>


<br>
<br>

<?php
$date = new DateTime();
echo DatePicker::widget([   
    'name'  => 'from_date',
    'attribute' => 'from_date',
    //'inline'=>TRUE, //вместо строки календарь
    //'language' => 'ru',
    'dateFormat' => 'dd-MM-yyyy',
    'value'=>$date->modify('-1 month'), // year, month, day
]);
?>

<br>
<br>
<div class="row">
    <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
  <div class="col-md-1" style="border: 1px solid">.col-md-1</div>
</div>
<div class="row">
  <div class="col-md-4" style="border: 1px solid red">.col-md-4</div>
  <div class="col-md-8" style="border: 1px solid red">.col-md-8</div>
</div>
<div class="row">
  <div class="col-md-4" style="border: 1px solid blue">.col-md-4</div>
  <div class="col-md-4" style="border: 1px solid blue">.col-md-4</div>
  <div class="col-md-4" style="border: 1px solid blue">.col-md-4</div>
</div>
<div class="row">
  <div class="col-md-6" style="border: 1px solid magenta">.col-md-6</div>
  <div class="col-md-6" style="border: 1px solid magenta">.col-md-6</div>
</div>

<p></p>
<!-- Stack the columns on mobile by making one full-width and the other half-width -->
<div class="row">
  <div class="col-xs-6 col-md-4" style="border: 1px solid">.col-xs-6 .col-md-4</div>
  <div class="col-xs-12 col-md-8" style="border: 1px solid">.col-xs-12 .col-md-8</div>
</div>

<!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
<div class="row">
  <div class="col-xs-6 col-md-4" style="border: 1px solid blue">.col-xs-6 .col-md-4</div>
  <div class="col-xs-6 col-md-4" style="border: 1px solid blue">.col-xs-6 .col-md-4</div>
  <div class="col-xs-6 col-md-4" style="border: 1px solid blue">.col-xs-6 .col-md-4</div>
</div>

<!-- Columns are always 50% wide, on mobile and desktop -->
<div class="row">
  <div class="col-xs-6" style="border: 1px solid green">.col-xs-6</div>
  <div class="col-xs-6" style="border: 1px solid green">.col-xs-6</div>
</div>

