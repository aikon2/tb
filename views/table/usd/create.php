<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\system\Usd */

$this->title = 'Новый сборщик';
$this->params['breadcrumbs'][] = ['label' => 'Система', 'url' => ['/system/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблицы'];
$this->params['breadcrumbs'][] = ['label' => 'Сборщики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
