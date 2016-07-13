<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015
 * @package   yii2-tree-manager
 * @version   1.0.4
 */
use app\models\system\Tree;
use execut\widget\TreeView;
use yii\web\JsExpression;
?>

<pre>
   <?php
   //var_export(Tree::getFullTreeInline()); 

   $array = [
       0 => [1 => 1, 2 => [3 => 3, 4 => 4], 5 => 5], [6 => 6, 7 => [8 => 8]], [9 => [10 => 10, 11 => 11, 12 => [13 => 13, 14 => 14]]],
       1 => [0 => [10, 11, 12]], [1 => [13, 14, 15]], [2 => [16, 17, 18]],
       3 => [0 => 0, 1 => 1, 2 => [3 => 3, 4 => 4]],
   ];
   //$r2 = array($array);
   //var_export($r2);

   
   $a = array(); //a - массив
   $ref = &$a;//ссылка ref на массив а
   $ref3= &$a;//ссылка ref3 на массив а
   //foreach ($array as $v) {
   //$a[0] =[];
      $ref[] = ['text'=>'Parant 1'];   //Новый [0] элемент дерева - поле text
      $ref['nodes'] = array(); //В этом же элементе [0] встроенный новый массив nodes
      $ref = &$ref[0];//ссылка на элемент [0]
      $ref = &$ref['nodes'];//ссылка на элемент [0]['nodes']      
         $ref[] = ['text'=>'Child 1'];
         $ref2 = &$ref[1];//Создана ссылка на элемент [0]['nodes'][1]
         $ref = &$ref[0];         
         //$ref['nodes'] = array(); 
         $ref = &$ref['nodes'];
            $ref[0] = ['text'=>'Grandchild 1'];
            $ref[1] = ['text'=>'Grandchild 2'];
         //$ref2 = &$ref2;         
         //$ref['nodes'] = array();
            /*
         $ref2 = ['text'=>'Child 2'];
         $ref3[1] = ['text'=>'Parent 2'];
         $ref3[2] = ['text'=>'Parent 3'];
         $ref = &$ref3[2];            
      $ref['nodes'] = array(); 
      $ref = &$ref['nodes'];
      $ref2 = &$ref[1];
         $ref[0] = ['text'=>'Child 1'];
         $ref = &$ref[0];         
         $ref['nodes'] = array(); 
         $ref = &$ref['nodes'];
            $ref[0] = ['text'=>'Grandchild 1'];
            $ref[1] = ['text'=>'Grandchild 2'];
             * 
             */
   //}
   print_r($a);
   
   
   
/*
   $arrays = Tree::find()->addOrderBy('root, lft')->all();
   $flag = TRUE;
   $b = array();
   $refi = &$b;
   foreach ($arrays as $r => $array) {
      if ($flag) {
         $prelvl = $array->lvl - 1;
         $flag = FALSE;
         echo "-- pre lvl: " . $prelvl;
      }
      if ($prelvl < $array->lvl) {//Новый уровень
      }
      $refi[] = array(['text'=>$array->name]);
      $refi = &$refi[];
      //echo $array->lvl;
      //echo $array->name . "\n";
   }
   print_r($b);*/
   $data = [
    [
        'text' => 'Parent 1',
        'nodes' => [
            [
                'text' => 'Child 1',
                'nodes' => [
                    [
                        'text' => 'Grandchild 1'
                    ],
                    [
                        'text' => 'Grandchild 2'
                    ]
                ]
            ],
            [
                'text' => 'Child 2',
            ]
        ],
    ],
    [
        'text' => 'Parent 2',
    ]
];
print_r($data);




   ?>
</pre>

<pre>
<?php /*
  $roots = Tree::findOne(['id' => 5]);
  $leaves= $roots->leaves()->all();
  foreach ($leaves as $r=>$root){
  var_export($root->name);

  }
 */
?>
</pre>

<p>
   <?php
   
   $onSelect = new JsExpression(<<<JS
function (undefined, item) {
    console.log(item);
}
JS
);
$groupsContent = TreeView::widget([
    'data' => $a,
    'size' => TreeView::SIZE_SMALL,
    'header' => 'Categories',
    'searchOptions' => [
        'inputOptions' => [
            'placeholder' => 'Search category...'
        ],
    ],
    'clientOptions' => [
        'onNodeSelected' => $onSelect,
        'selectedBackColor' => 'rgb(40, 153, 57)',
        'borderColor' => '#fff',
    ],
]);


echo $groupsContent;
   
   ?>
   
</p>
   