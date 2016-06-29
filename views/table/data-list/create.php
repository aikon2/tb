<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\system\DataList */

$this->title = 'Новый';
$this->params['breadcrumbs'][] = ['label' => 'Система', 'url' => ['/system/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблицы'];
$this->params['breadcrumbs'][] = ['label' => 'Перечень данных', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
