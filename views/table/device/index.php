<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use app\models\system\Device;

/* @var $this yii\web\View */
/* @var $searchModel app\models\system\DeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Приборы';
$this->params['breadcrumbs'][] = ['label' => 'Система', 'url' => ['/system/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблицы'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-index">

   <h1><?= Html::encode($this->title) ?></h1>
   <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

   <p>
      <?= Html::a('Новый прибор', ['create'], ['class' => 'btn btn-success']) ?>
   </p>
   <?php Pjax::begin(); ?>    <?=
   GridView::widget([
       'dataProvider' => $dataProvider,
       'filterModel' => $searchModel,
       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           //'id',
           'name_device',
           'typeDeviceName', //связанная
           'serial',
           'usdName', //связанная                          
           [//Столбец В работе
               'attribute' => 'work_device',
               'value' => 'workValue',
               'filter' => array("1" => "Работает", "0" => "Отключено"),
           ],
           [
               //'label' => 'Каналы',
               'format' => 'raw',
               'value' => 'linkValue'                
                   ],
                   ['class' => 'yii\grid\ActionColumn'],
               ],
           ]);
           ?>
           <?php Pjax::end(); ?>
   

   
</div>

