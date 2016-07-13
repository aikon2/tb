<?php

namespace app\models\system;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[Tree]].
 *
 * @see Tree
 */
class TreeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
   
   public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     * @return Tree[]|array
     
    public function all($db = null)
    {
        return parent::all($db);
    }*/

    /**
     * @inheritdoc
     * @return Tree|array|null
     
    public function one($db = null)
    {
        return parent::one($db);
    }*/
}
