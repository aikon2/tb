<?php

namespace app\models\system;

use Yii;

/**
 * This is the model class for table "block_interval".
 *
 * @property integer $id_data_list
 * @property string $time_interval
 * @property string $value
 * @property integer $status
 *
 * @property DataList $idDataList
 */
class BlockInterval extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'block_interval';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //Проверяет чтобы все значения не были пустыми
            [['id_data_list', 'time_interval', 'value', 'status'], 'required'],
            //Целые числа, минимум 0 и выше            
            [['id_data_list', 'status'], 'integer'],
            // Дата формата ... Сдесь минуты символ m!
            [['time_interval'], 'date','format'=>'Y-m-d H:m:s'],
            //Числовое значение            
            [['value'], 'number'],
            //Наличие ссылочного значения в таблице PD            
            [['id_data_list'], 'exist', 'skipOnError' => true, 'targetClass' => DataList::className(), 'targetAttribute' => ['id_data_list' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_data_list' => 'Ссылка перечня данных',
            'time_interval' => 'Дата-время',
            'value' => 'Значение',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDataList()
    {
        return $this->hasOne(DataList::className(), ['id' => 'id_data_list']);
    }
}
