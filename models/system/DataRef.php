<?php

namespace app\models\system;

use Yii;

/**
 * This is the model class for table "data_ref".
 *
 * @property integer $id
 * @property string $name_ref
 * @property string $type_data_ref
 *
 * @property DataList[] $dataLists
 */
class DataRef extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_ref';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ref'], 'required'],
            [['name_ref'], 'string', 'max' => 30],
            [['type_data_ref'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'name_ref' => 'Наименование данного',
            'type_data_ref' => 'Тип данного',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDataLists()
    {
        return $this->hasMany(DataList::className(), ['id_data_ref' => 'id']);
    }
}
