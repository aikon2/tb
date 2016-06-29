<?php

use yii\db\Migration;

/**
 * Handles the creation for table `block_interval`.
 */
class m160602_054107_create_block_interval extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('block_interval', [
            'id_data_list'=> $this->integer()->notNull(),
            'time_interval'=> $this->dateTime()->notNull(), 
            'value'=> $this->decimal(14,6)->notNull(), 
            'status'=> $this->integer()->notNull(), 
        ]);
        
        $this->addForeignKey('block_interval_data_list','block_interval','id_data_list','data_list','id');
        $this->createIndex('block_interval_ind','block_interval',['id_data_list','time_interval'],TRUE);
        
        $this->addCommentOnTable('block_interval','Массив интервальных данных');        
        $this->addCommentOnColumn('block_interval','id_data_list','Ссылка перечня данных');
        $this->addCommentOnColumn('block_interval','time_interval','Дата-время');
        $this->addCommentOnColumn('block_interval','value','Значение');
        $this->addCommentOnColumn('block_interval','status','Статус');        
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('block_interval');
    }
}
