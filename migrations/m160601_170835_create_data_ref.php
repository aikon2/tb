<?php

use yii\db\Migration;

/**
 * Handles the creation for table `data_ref`.
 */
class m160601_170835_create_data_ref extends Migration
{
    /**
     * @inheritdoc
     */
    public function SafeUp()
    {
        $this->createTable('data_ref', [
            'id' => $this->primaryKey(),
            'name_ref' => $this->string(100)->notNull(),
            'type_data_ref'=> $this->char(1),
        ]);
        $this->addCommentOnTable('data_ref','Справочник данных');
        $this->addCommentOnColumn('data_ref','id','Идентификатор');
        $this->addCommentOnColumn('data_ref','name_ref','Наименование данного');
        $this->addCommentOnColumn('data_ref','type_data_ref','Тип данного');
    }

    /**
     * @inheritdoc
     */
    public function SafeDown()
    {
        $this->dropTable('data_ref');
    }
}
