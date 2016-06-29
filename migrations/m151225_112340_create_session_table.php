n<?php

use yii\db\Migration;

class m151225_112340_create_session_table extends Migration {

   public function up() {

      $this->createTable('session', [
          'id' => $this->char(40)->primaryKey()->notNull(),
          'expire' => $this->integer(),
          'data' => 'LONGBLOB NOT NULL'
      ]);
   }

   public function down() {
      $this->dropTable('session');
   }

}
