<?php

use yii\db\Migration;
use yii\db\Schema;

class m160203_045723_create_action_table extends Migration {

   public function up() {
      $this->createTable('action', [
          'id' => Schema::TYPE_PK . ' NOT NULL',
          'name' => Schema::TYPE_STRING . ' NOT NULL',
          'actionstring' => Schema::TYPE_STRING . ' NOT NULL',
          'params' => Schema::TYPE_STRING,
          'description'=>Schema::TYPE_TEXT,
          'prava'=>Schema::TYPE_BOOLEAN
              ]
      );
   }

   public function down() {
      $this->dropTable('action');
   }

}
