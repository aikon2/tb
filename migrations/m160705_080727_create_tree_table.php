<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tree`.
 */
class m160705_080727_create_tree_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tree', [
            'id' => $this->primaryKey(),
            'root'=> $this->integer(),
            'lft'=> $this->integer()->notNull(),
            'rgt'=> $this->integer()->notNull(),
            'lvl'=> $this->integer()->notNull(),
            'name'=>$this->string(30)->notNull(),
            'id_device'=> $this->integer()
        ]);
        
        $this->addCommentOnTable('tree','Дерево объектов');
        $this->addCommentOnColumn('tree','id','Идентификатор');
        $this->addCommentOnColumn('tree','root','Корень');
        $this->addCommentOnColumn('tree','lft','Кто до');
        $this->addCommentOnColumn('tree','rgt','Кто после');
        $this->addCommentOnColumn('tree','lvl','Уровень');
        $this->addCommentOnColumn('tree','name','Наименование');
        $this->addCommentOnColumn('tree','id_device','Ссылка на прибор');
        
        $this->addForeignKey('tree_device','tree','id_device','device','id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tree');
    }
}
