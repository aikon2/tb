<?php

use yii\db\Migration;

class m160629_043507_update_usd_table extends Migration {

   public function up() {      
      $this->addColumn('usd', 'work_usd', $this->boolean()->notNull()->defaultValue(true));
      $this->addColumn('usd', 'login', $this->string(20));
      $this->addColumn('usd', 'pass', $this->string(40));
      
      $this->addCommentOnColumn('usd','work_usd','В работе');
      $this->addCommentOnColumn('usd','login','Логин');
      $this->addCommentOnColumn('usd','pass','Пароль');
   }

   public function down() {
      
      $this->dropColumn('usd', 'work_usd');      
      $this->dropColumn('usd', 'login');
      $this->dropColumn('usd', 'pass');
   }

   /*
     // Use safeUp/safeDown to run migration code within a transaction
     public function safeUp()
     {
     }

     public function safeDown()
     {
     }
    */
}
