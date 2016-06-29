<?php

use yii\db\Migration;

/**
 * Handles the creation for table `data_list`.
 */
class m160602_030614_create_data_list extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('data_list', [
            'id' => $this->primaryKey(),
            'id_device'=> $this->integer()->notNull(),
            'id_data_ref'=> $this->integer()->notNull(),
            'number'=> $this->smallInteger()->notNull(),
            'time_point'=> $this->dateTime(),
            'work_data'=> $this->boolean()->notNull()->defaultValue(true), 
        ]);
        
        //Связь
        $this->addForeignKey('data_list_device','data_list','id_device','device','id');
        $this->addForeignKey('data_list_data_ref','data_list','id_data_ref','data_ref','id');
        
        $this->addCommentOnTable('data_list','Приборы');
        $this->addCommentOnColumn('data_list','id','Идентификатор');
        $this->addCommentOnColumn('data_list','id_device','Ссылка на прибор');
        $this->addCommentOnColumn('data_list','id_data_ref','Ссылка на справочник данных');
        $this->addCommentOnColumn('data_list','number','Номер канала');
        $this->addCommentOnColumn('data_list','time_point','Метка последних данных');
        $this->addCommentOnColumn('data_list','work_data','В работе');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('data_list');
    }
}
