<?php

use yii\db\Migration;

/**
 * Handles the creation for table `device_table`.
 */
class m160531_065118_create_device_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('device', [
            'id' => $this->primaryKey(),            
            'name_device' => $this->string(30)->notNull(),
            'id_type_device'=> $this->integer()->notNull(),
            'serial' => $this->string(30)->notNull(),
            'id_usd'=> $this->integer(),
            'work_device'=> $this->boolean()->notNull()->defaultValue(true), 
        ]);
        $this->addCommentOnTable('device','Приборы');
        $this->addCommentOnColumn('device','id','Идентификатор');
        $this->addCommentOnColumn('device','name_device','Название прибора');
        $this->addCommentOnColumn('device','id_type_device','Ссылка на тип прибора');
        $this->addCommentOnColumn('device','serial','Серийный номер прибора');
        $this->addCommentOnColumn('device','id_usd','Ссылка на сборщик');
        $this->addCommentOnColumn('device','work_device','В работе');
        
        //Связь
        $this->addForeignKey('device_type_device','device','id_type_device','type_device','id');
        $this->addForeignKey('device_usd','device','id_usd','usd','id');
        
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('device');
    }
}
