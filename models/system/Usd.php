<?php

namespace app\models\system;

use Yii;

/**
 * This is the model class for table "usd".
 *
 * @property integer $id
 * @property string $name_usd
 * @property string $dns_name
 * @property integer $work_usd
 * @property string $login
 * @property string $pass
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
            [['work_usd'], 'boolean'],
            [['name_usd'], 'string', 'max' => 30],
            [['dns_name'], 'string', 'max' => 64],
            [['login'], 'string', 'max' => 20],
            [['pass'], 'string', 'max' => 40],
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
            'work_usd' => 'В работе',
            'login' => 'Логин',
            'pass' => 'Пароль',
            'workValue' => 'В работе',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::className(), ['id_usd' => 'id']);
    }
    
    public function getWorkValue() {
      return $this->work_usd ? 'Работает' : 'Отключено';
   }
}
