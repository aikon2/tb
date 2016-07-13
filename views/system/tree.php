<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\system\Tree;

use execut\widget\TreeView;
use yii\web\JsExpression;
?>

<h2>Its all right!</h2>

<?php

//$roots = Tree::findOne(['id'=>'22']);
//$roots->deleteWithChildren();
//$countries = new Tree(['name' => 'Еще пустой корень']);
//$countries->makeRoot();
//$roots = Tree::findOne(['id'=>'24']);
//$child = new Tree(['name' => 'Вложение 3го уровня 3-4-1']);
//$child->appendTo($roots);
//$child = new Tree(['name' => 'Вложение 3го уровня 3-4-2']);
//$child->appendTo($roots);




?>



<div>

   <?php
  

   //$data=Tree::parseData([1,5]);
   $data=Tree::parseData();
   $onSelect = new JsExpression(<<<JS
function (undefined, item) {
    console.log(item);
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
                   //'selectedBackColor' => 'rgb(40, 153, 57)',
                   //'borderColor' => '#ff',
               ],
   ]);


   echo $groupsContent;

      
   ?>


</div>