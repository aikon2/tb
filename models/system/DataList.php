<?php

namespace app\models\system;

//use Yii;

/**
 * This is the model class for table "data_list".
 *
 * @property integer $id
 * @property integer $id_device
 * @property integer $id_data_ref
 * @property integer $number
 * @property string $time_point
 * @property integer $work_data
 *
 * @property BlockInterval[] $blockIntervals
 * @property DataRef $idDataRef
 * @property Device $idDevice
 */
class DataList extends \yii\db\ActiveRecord {

   /**
    * @inheritdoc
    */
   public static function tableName() {
      return 'data_list';
   }

   /**
    * @inheritdoc
    */
   public function rules() {
      return [
          [['id_device', 'id_data_ref', 'number', 'work_data'], 'required'],
          [['id_device', 'id_data_ref', 'number'], 'integer'],        
          [['id_data_ref'], 'exist', 'skipOnError' => true, 'targetClass' => DataRef::className(), 'targetAttribute' => ['id_data_ref' => 'id']],
          [['id_device'], 'exist', 'skipOnError' => true, 'targetClass' => Device::className(), 'targetAttribute' => ['id_device' => 'id']],
          [['work_data'], 'boolean'],
          [['work_data'], 'default', 'value' => 1],
          [['time_point'], 'date', 'format' => 'Y-m-d H:m:s'],
          [['time_point'], 'default', 'value' => function ($model, $attribute) {
         return date('Y-m-d');
      }],
      ];
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels() {
      return [
          'id' => 'Идентификатор',
          'id_device' => 'Ссылка на прибор',
          'id_data_ref' => 'Ссылка на справочник данных',
          'number' => 'Номер канала',
          'time_point' => 'Метка последних данных',
          'work_data' => 'В работе',
          'deviceName' => 'Прибор',
          'dataRef' => 'Наименование',
          'workValue' => 'В работе',
          'typeDataRef'=>'Тип'
      ];
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getBlockIntervals() {
      return $this->hasMany(BlockInterval::className(), ['id_data_list' => 'id']);
   }

   public function getIdDataRef() {
      return $this->hasOne(DataRef::className(), ['id' => 'id_data_ref']);
   }

   public function getIdDevice() {
      return $this->hasOne(Device::className(), ['id' => 'id_device']);
   }

   public function getDeviceName() {
      $DeviceN = $this->idDevice;
      return $DeviceN ? $DeviceN['name_device'] : '';
   }

   public function getDataRef() {
      $DataR = $this->idDataRef;
      return $DataR ? $DataR['name_ref'] : '';
   }
   
   public function getTypeDataRef() {
      $TypyDataR = $this->idDataRef;
      return $TypyDataR ? $TypyDataR['type_data_ref'] : '';
   }   

   public function getWorkValue() {
      return $this->work_data ? 'Работает' : 'Отключено';
   }

}
