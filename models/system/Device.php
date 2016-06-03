<?php

namespace app\models\system;

use Yii;

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
class Device extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_device', 'id_type_device', 'serial'], 'required'],
            [['id_type_device', 'id_usd', 'work_device'], 'integer'],
            [['name_device', 'serial'], 'string', 'max' => 30],
            [['id_type_device'], 'exist', 'skipOnError' => true, 'targetClass' => TypeDevice::className(), 'targetAttribute' => ['id_type_device' => 'id']],
            [['id_usd'], 'exist', 'skipOnError' => true, 'targetClass' => Usd::className(), 'targetAttribute' => ['id_usd' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Интидефикатор',
            'name_device' => 'Название прибора',
            'id_type_device' => 'Тип прибора',
            'serial' => 'Серийный номер прибора',
            'id_usd' => 'Сборщик',
            'work_device' => 'В работе',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDataLists()
    {
        return $this->hasMany(DataList::className(), ['id_device' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTypeDevice()
    {
        return $this->hasOne(TypeDevice::className(), ['id' => 'id_type_device']);
    }
    
    public function getTypeDeviceName()
    {
       $typeDeviceN = $this->idTypeDevice;
        return $typeDeviceN ? $typeDeviceN->name_type : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsd()
    {
        return $this->hasOne(Usd::className(), ['id' => 'id_usd']);
    }
    
    public function getUsdName()
    {
       $usdN = $this->idUsd;
        return $usdN ? $usdN->name_usd : '';
    }
}
