<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\system\Tree;
use execut\widget\TreeView;
use yii\helpers\Html;
//use yii\helpers\Url;
//use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

//use yii\widgets\ActiveForm;
?>

<?php
//$roots = Tree::findOne(['id'=>'22']);
//$roots->deleteWithChildren();
//$countries = new Tree(['name' => '<b>Uxaa-xa<b>']);
//$countries->makeRoot();
//$roots = Tree::findOne(['id'=>'24']);
//$child = new Tree(['name' => 'Вложение 3го уровня 3-4-1']);
//$child->appendTo($roots);
//$child = new Tree(['name' => 'Вложение 3го уровня 3-4-2']);
//$child->appendTo($roots);
?>



<?php
$data = Tree::nparseData(NULL, NULL, TRUE);
//print_r($data);
?>
<div>
   <?php
   Pjax::begin([
       'id' => 'pjax-container',
   ]);
   ?>
   <div>
      <p>        
         <?=
         Html::a('<span class="glyphicon glyphicon-tree-conifer"></span> &nbsp;Новый корень', ['#'], [
             'data-toggle' => 'modal',
             'data-target' => '#m_root',
             'class' => 'btn btn-info',
             'title' => 'Добавляет новый корень в дерево',]);
         ?>      
         <?=
         Html::a('<span class="glyphicon glyphicon-asterisk"></span> &nbsp;Редактировать', ['#'], [
             'data-toggle' => 'modal',
             'data-target' => '#m_edit',
             'class' => ($id > 0) ? 'btn btn-info' : 'btn btn-info disabled',
             'title' => 'Добавляет новый корень в дерево',
         ]);
         ?>
         <?=
         Html::a('<span class="glyphicon glyphicon-plus-sign"></span> &nbsp;Добавить', ['#'], [
             'class' => ($id > 0) ? 'btn btn-info' : 'btn btn-info disabled',
             'title' => 'Добавляет новый элемент в текущуу ветку',
         ]);
         ?>
         <?=
         Html::a('<span class="glyphicon glyphicon-circle-arrow-up"></span> &nbsp;Вставить до', ['#'], [
             'class' => ($id > 0) ? 'btn btn-info' : 'btn btn-info disabled',
             'title' => 'Вставляет новый элемент до выбранного элемента',
         ]);
         ?>
         <?=
         Html::a('<span class="glyphicon glyphicon-circle-arrow-down"></span> &nbsp;Вставить после', ['#'], [
             'class' => ($id > 0) ? 'btn btn-info' : 'btn btn-info disabled',
             'title' => 'Вставляет новый элемент после выбранного элемента',
         ]);
         ?>
         <?php
         echo Html::a('<span class="glyphicon glyphicon glyphicon-remove"></span> &nbsp;Удалить', ['delete', 'id' => $id], [
             'class' => ($id > 0) ? 'btn btn-info' : ' btn btn-info disabled',
             'title' => 'Удалить',
             'data' => [
                 'confirm' => 'Вы уверены, что хотите удалить данную запись?',
                 'method' => 'post',
             ],
         ]);
         ?>

      </p>
   </div>

   <?php
   //Редактирование   
   Modal::begin([
       //'size' => 'modal-lg', //Маленькое окно, большое modal-lg
       'header' => '<h3>Редактирование</h3>',
       'id' => 'm_edit',]);
   ?>
   <?= Html::beginForm(['edit'], 'post'); ?>
   <?= Html::label('Наименование:', 'nametext'); ?>
   <?= Html::input('text', 'name', $mname, ['class' => 'form-control', 'id' => 'nametext']); ?>
   <?= Html::hiddenInput('id', $id); ?>
   <br/>
   <?= Html::a('Отмена', ['#'], ['title' => 'Close', 'class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
   <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
   <?= Html::endForm(); ?>
<?php Modal::end(); ?>


   <?php
   Pjax::end();



   $onSelect = new JsExpression(<<<JS
function (undefined, item) {
    if (item.href !== location.pathname) {
        $.pjax({
            container: '#pjax-container',
            url: item.href,
            timeout: null
        });
    }
           //console.log(item);
          
}
JS
   );
   //Костыль - обновляет страницу при снятии выделения 
   $nodeUnselected = new JsExpression(<<<JS
function (undefined, item) {
    if (item.href !== location.pathname) {
        $.pjax({
            container: '#pjax-container',
            url: '',
            timeout: null
        });
    }
           //console.log(item);          

    
}
JS
   );


   $groupsContent = TreeView::widget([
               'data' => $data,
               //'size' => TreeView::SIZE_SMALL,
               'header' => 'Объекты',
               'searchOptions' => [
                   'inputOptions' => [
                       'placeholder' => 'Поиск объекта...'
                   ],
               ],
               'clientOptions' => [
                   'onNodeSelected' => $onSelect,
                   'onNodeUnselected' => $nodeUnselected,
                   'levels' => 1
               //'selectedBackColor' => 'rgb(40, 153, 57)',
               //'borderColor' => '#ff',
               ],
   ]);
   echo $groupsContent;
   ?>


</div>

<?php
//Создание корня
Modal::begin([
    //'size' => 'modal-lg', //Маленькое окно, большое modal-lg
    'header' => '<h3>Создание нового корня</h3>',
    'id' => 'm_root',]);
?>
<?= Html::beginForm(['root'], 'post'); ?>
<?= Html::label('Введите название корня:', 'nametext'); ?>
<?= Html::input('text', 'name', '', ['class' => 'form-control', 'id' => 'nametext']); ?>
<br/>
<?= Html::a('Отмена', ['#'], ['title' => 'Close', 'class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
<?= Html::submitButton('Создать', ['class' => 'btn btn-primary']); ?>
<?= Html::endForm(); ?>
<?php Modal::end(); ?>