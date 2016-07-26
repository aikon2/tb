<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

use execut\widget\TreeView;
use yii\web\JsExpression;

?>
<div>
   
   <?php

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
                                      'placeholder' => 'Поиск...'
                                  ],
                              ],
                              'clientOptions' => [
                                  'onNodeSelected' => $onSelect,
                                  'levels' => 2,
                              //'selectedBackColor' => 'rgb(40, 153, 57)',
                              //'borderColor' => '#ff',
                              ],
                  ]);


                  echo $groupsContent;
                 
?>

   </div>