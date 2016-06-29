<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\system\DataListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Перечень данных';
$this->params['breadcrumbs'][] = ['label' => 'Система', 'url' => ['/system/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблицы'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'id_device',
            'deviceName', //Связанная
            //'id_data_ref',
            'dataRef',
            'typeDataRef',
            'number',
            'time_point',
            // 'work_data',
            [//Столбец В работе
               'attribute' => 'work_data',
               'value' => 'workValue',
               'filter' => array("1" => "Работает", "0" => "Отключено"),
           ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
