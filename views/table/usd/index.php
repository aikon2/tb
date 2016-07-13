<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\system\UsdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сборщики';
$this->params['breadcrumbs'][] = ['label' => 'Система', 'url' => ['/system/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблицы'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usd-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Usd', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name_usd',
            'dns_name',
            [//Столбец В работе
               'attribute' => 'work_usd',
               'value' => 'workValue',
               'filter' => array("1" => "Работает", "0" => "Отключено"),
           ],
            //'login',
            // 'pass',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
