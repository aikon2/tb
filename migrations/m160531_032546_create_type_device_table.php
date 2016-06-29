<?php

use yii\db\Migration;

/**
 * Handles the creation for table `typedevice_table`.
 */
class m160531_032546_create_type_device_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('type_device', [
            'id' => $this->primaryKey(),
            'name_type' => $this->string(30)->notNull(),
            'rank' => $this->smallInteger()->notNull()
        ]);
        $this->addCommentOnTable('type_device','Типы приборов');
        $this->addCommentOnColumn('type_device','id','Идентификатор');
        $this->addCommentOnColumn('type_device','name_type','Тип прибора');
        $this->addCommentOnColumn('type_device','rank','Класс прибора');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('type_device');
    }
}
