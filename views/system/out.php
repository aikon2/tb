<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//use Yii;
use yii\helpers\Url;
use yii\widgets\Pjax;
use nirvana\showloading\ShowLoadingAsset;

$this->title = 'Получение данных';
$this->params['breadcrumbs'][] = ['label' => 'Система', 'url' => ['/system/index']];
$this->params['breadcrumbs'][] = $this->title;

ShowLoadingAsset::register($this);

$this->registerJs(
        '$("document").ready(function(){
        $("#animname").on("pjax:start", function() { $("#animname").showLoading();});
        $("#animname").on("pjax:end", function() { $("#animname").hideLoading();});
    });
  '
);
?>



<div>
   <br>
   <?php Pjax::begin(['id' => 'animname']); ?>
   <div>

      <?php
      if (!is_null($message)) {
         echo '<p>Получено значение: ';
         var_export($message);
         //Только на тестовой версии
         if (YII_DEBUG) {var_dump($message);}
         echo '</p>';
         
         
         /*
          $date = new DateTime('1789-12-1 2:30:10');
          echo date('Y-m-d H:i:s'); //Сдесь минуты символ i!
         
          
          http://php.net/manual/ru/function.date.php
          $launchDate = new DateTime("2015-01-01", new DateTimeZone("UTC"));
          $today = new DateTime();
          $daysToLaunch = $today->diff($launchDate, false)->days;
          */
         
      }
      ?>

   </div>
   <br>
   <div>
      <p><a href="<?= Url::to(['out', 'c' => 'version']); ?>">Запрос версии</a></p>
      <p><a href="<?= Url::to(['out', 'c' => 'time']); ?>">Запрос времени</a></p>
      <p><a href="<?= Url::to(['out', 'c' => 'archive',
          'n1'=>2,'n2'=>3,
          't1'=>'20151201000000',
          't2'=>'20151201010000']); ?>">Запрос данных</a></p>
      <p><a href="<?= Url::to(['out', 'c' => 'total',
          'n1'=>133,'n2'=>140,
          't1'=>'20160518000000',
          't2'=>'20160518000000'
          ]); ?>">Запрос показаний</a></p>
      <p><a href="<?= Url::to(['out', 'c' => 'events',
          'n1'=>1,'n2'=>4,
          't1'=>'20151201000000',
          't2'=>'20151203000000'
          ]); ?>">Запрос событий</a></p>
      <p><a href="<?= Url::to(['out', 'c' => 'ver']); ?>">Запрос</a></p>      

   </div>
   <?php Pjax::end(); ?>

   <div>
      
   </div>

</div>

