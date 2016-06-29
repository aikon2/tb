<?php

namespace app\models\system;

use Yii;

/**
 * This is the model class for table "type_device".
 *
 * @property integer $id
 * @property string $name_type
 * @property integer $rank
 *
 * @property Device[] $devices
 */
class TypeDevice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_type', 'rank'], 'required'],
            [['rank'], 'integer'],
            [['name_type'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'name_type' => 'Тип прибора',
            'rank' => 'Класс прибора',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::className(), ['id_type_device' => 'id']);
    }
}
