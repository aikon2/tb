<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ActionForm;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use nirvana\showloading\ShowLoadingAsset;
ShowLoadingAsset::register($this);

 $this->registerJs(
   '$("document").ready(function(){
        $("#animname").on("pjax:start", function() { $("#animname").showLoading();});
        $("#animname").on("pjax:end", function() { $("#animname").hideLoading();});
    });
  '
);

/* @var $this yii\web\View */
/* @var $model app\models\action */
/* @var $form ActiveForm */
?>
<div class="system-action">
   <?php $form = ActiveForm::begin(); ?>
   <div class="form-group">
      <?=
      $form->field($model, 'id')->label('Комманды')->dropdownList(
              ActionForm::find()->select(['name', 'id'])->indexBy('id')->column(), [
          'prompt' => 'Выберите комманду',
          'onchange' => 'this.form.submit()'
      ])
      ?>         
   </div>
   <?php ActiveForm::end(); ?>
</div><!-- system-action -->
<div class="system-action">
   <?php Pjax::begin(['id' => 'animname']); ?>
   <?php if ($ghide > 0) { //начало if ?>
      <?= Html::beginForm(['action'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
      <div class="form-group">
         <?= Html::label('Адрес:', 'aadr'); ?>
         <?= Html::input('text', 'adr', $gadr, ['class' => 'form-control', 'id' => 'aadr']); ?>   
      </div>
      <div class="form-group">
         <?= Html::label('Комманда:', 'astring'); ?>
         <?= Html::input('text', 'string', $gcommand, ['class' => 'form-control', 'id' => 'astring']); ?>                        
      </div>
      <div class="form-group">
         <?= Html::label('Параметры:', 'aparams'); ?>
         <?= Html::input('text', 'params', $gparams, ['class' => 'form-control', 'id' => 'aparams']); ?>                        
      </div>
      
         <!-- Modal -->
         <div class="modal fade" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Заполните параметры для доступа</h4>
                  </div>
                  <div class="modal-body">
                     <p><?= Html::label('Пользователь:', 'auser'); ?>
                        <?= Html::input('text', 'user', $guser, ['class' => 'form-control', 'id' => 'auser']); ?>   
                     </p>
                     <p>
                        <?= Html::label('Пароль:', 'apass'); ?>
                        <?= Html::input('text', 'pass', $gpass, ['class' => 'form-control', 'id' => 'apass']); ?>   
                     </p>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn" data-dismiss="modal">Закрыть</button>                     
                  </div>
               </div>
            </div>
         </div>

         <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']); ?>
         <!-- Button trigger modal -->
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#UserModal">
            Настройка доступа
         </button>

  

      <?=
      Html::endForm();
   }//конец if  
   ?>   
</div><p></p>
<div>            
   <?php if ($ghide == 2) { //начало if  ?>
      <p> На запрос: <a href="<?= $pagein ?>"><?= $pagein ?></a> получен ответ: </p>
      <pre> <?= $pageout ?></pre>
   <?php }//конец if   ?>
   <?php Pjax::end(); ?>
</div>   
<p></p>
<div>
   <?=
   DetailView::widget([
       'model' => $model,
       'attributes' => [
           'actionstring',
           'params',
           'description:html',
           /* [
             'label' => 'Описание',
             'value' => "<pre>{$model->description}</pre>",
             'format' => 'raw'
             ],
            * 
            */
           'prava:boolean'
       ],
   ])
   ?>
</div>