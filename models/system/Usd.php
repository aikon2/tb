<?php

namespace app\models\system;

use Yii;

/**
 * This is the model class for table "usd".
 *
 * @property integer $id
 * @property string $name_usd
 * @property string $dns_name
 *
 * @property Device[] $devices
 */
class Usd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_usd', 'dns_name'], 'required'],
            [['name_usd'], 'string', 'max' => 30],
            [['dns_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'name_usd' => 'Название сборщика',
            'dns_name' => 'Адрес',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::className(), ['id_usd' => 'id']);
    }
}
