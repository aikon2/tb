<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\system\Usd */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Система', 'url' => ['/system/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблицы'];
$this->params['breadcrumbs'][] = ['label' => 'Сборщики', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = mb_substr($this->title, 0, 20,'UTF-8');
?>
<div class="usd-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данную запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name_usd',
            'dns_name',
            'workValue',
            'login',
            'pass',
        ],
    ]) ?>

</div>
