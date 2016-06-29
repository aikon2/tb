<?php

use yii\db\Migration;

/**
 * Handles the creation for table `usd_table`.
 */
class m160530_100551_create_usd_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('usd', [
            'id' => $this->primaryKey(),
            'name_usd' => $this->string(30)->notNull(),
            'dns_name' => $this->string(64)->notNull(),
        ]);
        $this->addCommentOnTable('usd','Сборщик');
        $this->addCommentOnColumn('usd','id','Идентификатор');
        $this->addCommentOnColumn('usd','name_usd','Название сборщика');
        $this->addCommentOnColumn('usd','dns_name','Адрес');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('usd');
    }
}
