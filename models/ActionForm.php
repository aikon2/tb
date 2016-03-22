<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "action".
 *
 * @property integer $id
 * @property string $name
 * @property string $actionstring
 * @property string $description
 * @property integer $prava
 */
class ActionForm extends \yii\db\ActiveRecord {

   /**
    * @inheritdoc
    */
   public static function tableName() {
      return 'action';
   }

   /**
    * @inheritdoc
    */
   public function rules() {
      return [
          [['id','name', 'actionstring'], 'required'],
          [['description'], 'string'],
          [['prava'], 'integer'],
          [['name', 'actionstring'], 'string', 'max' => 255],
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels() {
      return [
          'id' => 'ID',
          'name' => 'Наименование',
          'actionstring' => 'Команда',
          'params'=>'Параметры',
          'description' => 'Описание',
          'prava' => 'Наличие прав',
      ];
   }

  

}
