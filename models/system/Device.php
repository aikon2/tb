<?php

namespace app\models\system;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "device".
 *
 * @property integer $id
 * @property string $name_device
 * @property integer $id_type_device
 * @property string $serial
 * @property integer $id_usd
 * @property integer $work_device
 *
 * @property DataList[] $dataLists
 * @property TypeDevice $idTypeDevice
 * @property Usd $idUsd
 */
class Device extends \yii\db\ActiveRecord {

   /**
    * @inheritdoc
    */
   public static function tableName() {
      return 'device';
   }

   /**
    * @inheritdoc
    */
   public function rules() {
      return [
          [['name_device', 'id_type_device', 'serial','work_device'], 'required'],
          [['id_type_device', 'id_usd', 'id'], 'integer'],
          [['name_device', 'serial'], 'string', 'max' => 30],
          [['id_type_device'], 'exist', 'skipOnError' => true, 'targetClass' => TypeDevice::className(), 'targetAttribute' => ['id_type_device' => 'id']],
          [['id_usd'], 'exist', 'skipOnError' => true, 'targetClass' => Usd::className(), 'targetAttribute' => ['id_usd' => 'id']],
          [['work_device'], 'boolean'],
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels() {
      return [
          'id' => 'Идентификатор',
          'name_device' => 'Название прибора',
          'id_type_device' => 'Ссылка на тип прибора',
          'serial' => 'Серийный номер прибора',
          'id_usd' => 'Ссылка на сборщик',
          'work_device' => 'В работе',
          'typeDeviceName' => 'Тип прибора',
          'usdName' => 'Сборщик',
          'workValue' => 'В работе'
      ];
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getDataLists() {
      return $this->hasMany(DataList::className(), ['id_device' => 'id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getIdTypeDevice() {
      return $this->hasOne(TypeDevice::className(), ['id' => 'id_type_device']);
   }

   public function getTypeDeviceName() {
      $typeDeviceN = $this->idTypeDevice;
      return $typeDeviceN ? $typeDeviceN['name_type'] : '';
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getIdUsd() {
      return $this->hasOne(Usd::className(), ['id' => 'id_usd']);
   }

   public function getUsdName() {
      $usdN = $this->idUsd;
      return $usdN ? $usdN['name_usd'] : '';
   }

   public function getWorkValue() {
      return $this->work_device ? 'Работает' : 'Отключено';
   }

   public function getLinkValue() {
      return Html::a(
                      'Каналы', Url::to(['/table/data-list', 'DataListSearch' =>
                     ['id_device'=>$this->id]
                              ]), 
              ['data-pjax'=>0]
              );
   }

}
