<?php

namespace app\models\system;

//use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
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

   /* Возвращает вложенный массив для дерева
    * $ids - Номер id для выделения
    * $id - Номер root
    * $select - True: все выбираемые, False: только вложения    
    */

   public static function nparseData($ids = null, $id = NULL, $select = FALSE) {
      $masTree = Tree::find()
              ->select(['id', 'root', 'lvl', 'name as text', 'id_device'])
              ->where(!is_null($id) ? ['root' => $id] : '')
              ->orderBy(['root' => SORT_ASC, 'lft' => SORT_ASC])
              ->createCommand()
              ->queryAll();     

      return self::nrec($ids, $masTree, null, $select);
      //print_r($masTree);
   }

   //строит массив рекурсией +вспомогательный массив
   private static function nrec($ids, $in, $dop = NULL, $select = FALSE) {
      $out = [];
      $vr = [];
      $count = count($in);
      foreach ($in as $cat) {
         if (is_null($dop)) {
            $dop = $cat;
         } else {
            if ($dop['root'] != $cat['root']) {//Новый корень
               if (empty($vr)) {
                  $dop['selectable'] = TRUE;
                  $dop['href'] = Url::to(['', 'id' => $dop['id']]);
                  array_push($out, $dop);
                  $count--;
               } else {
                  $dop['lvl'] = $nlvl;
                  $dop['selectable'] = $select;
                  $dop['href'] = Url::to(['', 'id' => $dop['id']]);
                  $dop['nodes'] = self::nrec($ids, $vr, $dop, $select);
                  array_push($out, $dop);
                  $count--;
               }
               $vr = [];
               $dop = $cat;
               $nlvl = '';
            } elseif ($dop['lvl'] != $cat['lvl']) {//Новый уровень, все последующие заносим в массив
               if (empty($nlvl)) {
                  $nlvl = $cat['lvl'];
               }
               array_push($vr, $cat);
            } elseif ($dop['lvl'] == $cat['lvl']) {
               if (empty($vr)) {
                  $dop['text'] = $cat['text'];
                  $dop['selectable'] = TRUE;
                  $dop['href'] = Url::to(['', 'id' => $cat['id']]);
                  if ($dop['id'] == $ids) {
                     $dop['state'] = ['selected' => true];
                  }
                  array_push($out, $dop);
                  $count--;
               } else {
                  array_pop($out);
                  $dop['lvl'] = $nlvl;
                  $dop['selectable'] = $select;
                  $dop['href'] = Url::to(['', 'id' => $dop['id']]);
                  $dop['nodes'] = self::nrec($ids, $vr, $dop, $select);
                  array_push($out, $dop);
                  $count--;
               }
               $vr = [];
               $dop = $cat;
            }
         }
      }
      if ($count > 0) {
         if (empty($vr)) {
            $dop['text'] = $cat['text'];
            $dop['selectable'] = TRUE;
            $dop['href'] = Url::to(['', 'id' => $cat['id']]);
            if ($dop['id'] == $ids) {
               $dop['state'] = ['selected' => true];
            }
            array_push($out, $dop);
         } else {
            $dop['lvl'] = $nlvl;
            $dop['selectable'] = $select;
            $dop['href'] = Url::to(['', 'id' => $dop['id']]);
            $dop['nodes'] = self::nrec($ids, $vr, $dop, $select);
            array_push($out, $dop);
         }
      }
      return $out;
   }

}
