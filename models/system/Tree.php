<?php

namespace app\models\system;

//use Yii;
use yii\helpers\Html;
use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "tree".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property string $name
 * @property integer $id_device
 *
 * @property Device $device
 */
class Tree extends \yii\db\ActiveRecord {

   /**
    * @inheritdoc
    */
   public static function tableName() {
      return 'tree';
   }

   public function behaviors() {
      return [
          'tree' => [
              'class' => NestedSetsBehavior::className(),
              'treeAttribute' => 'root',
              'leftAttribute' => 'lft',
              'rightAttribute' => 'rgt',
              'depthAttribute' => 'lvl',
          ],
      ];
   }

   public function transactions() {
      return [
          self::SCENARIO_DEFAULT => self::OP_ALL,
      ];
   }

   /**
    * @inheritdoc
    */
   public function rules() {
      return [
          [['root', 'lft', 'rgt', 'lvl', 'id_device'], 'integer'],
          [['name'], 'string', 'max' => 30],
          [['id_device'], 'exist', 'skipOnError' => true, 'targetClass' => Device::className(), 'targetAttribute' => ['id_device' => 'id']],
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels() {
      return [
          'id' => 'Идентификатор',
          'root' => 'Корень',
          'lft' => 'Кто до',
          'rgt' => 'Кто после',
          'lvl' => 'Уровень',
          'name' => 'Наименование',
          'id_device' => 'Ссылка на прибор',
      ];
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getDevice() {
      return $this->hasOne(Device::className(), ['id' => 'id_device']);
   }

   /**
    * @inheritdoc
    * @return TreeQuery the active query used by this AR class.
    */
   public static function find() {
      return new TreeQuery(get_called_class());
   }

   //Возвращает вложенный массив для дерева
   public static function parseData($id=NULL) {
      $masTree = Tree::find()
              ->where(!is_null($id)?['root' => $id]:'')
              ->orderBy(['root' => SORT_ASC, 'lft' => SORT_ASC])
              ->createCommand()
              ->queryAll();
      ;

      return self::rec($masTree);
      //print_r($masTree);
   }

   //строит массив рекурсией
   private static function rec($in, $root = -1, $lvl = -1, $name = NULL) {
      $out = [];
      $vr = [];
      $count = count($in);
      foreach ($in as $cat) {
         if ($root < 0) {
            $root = $cat['root'];
            $lvl = $cat['lvl'];
            $name = Html::encode($cat['name']);            
         } else {
            if ($root != $cat['root']) {//Новый корень
               if (empty($vr)) {
                  array_push($out, ['text' => $name]);
                  $count--;
               } else {
                  array_push($out, ['text' => $name,
                      'nodes' => self::rec($vr, $root, $nlvl, $name)]);
                  $count--;
               }
               $vr = [];
               $root = $cat['root'];
               $name = Html::encode($cat['name']);
               $nlvl = '';               
            } elseif ($lvl != $cat['lvl']) {//Новый уровень, все последующие заносим в массив
               if (empty($nlvl)) {
                  $nlvl = $cat['lvl'];
               }
               array_push($vr, ['name' => Html::encode($cat['name']), 'lvl' => $cat['lvl'], 'root' => $cat['root']]);
            } elseif ($lvl == $cat['lvl']) {
               if (empty($vr))  {
                     array_push($out, ['text' => Html::encode($cat['name'])]);
                     $count--;                  
               } else {
                  array_pop($out);
                  array_push($out, ['text' => $name,
                      'nodes' => self::rec($vr, $root, $nlvl, $name)]);
                  $count--;
               }
               $vr = [];
               $root = $cat['root'];
               $name = Html::encode($cat['name']);
            }
         }
      }
      if ($count > 0) {
         if (empty($vr)) {
            array_push($out, ['text' => Html::encode($cat['name'])]);
         } else {
            array_push($out, ['text' => $name,
                'nodes' => self::rec($vr, $root, $nlvl, $name)]);
         }
      }
      return $out;
   }

}
