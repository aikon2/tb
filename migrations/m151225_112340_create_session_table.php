n<?php

use yii\db\Migration;

class m151225_112340_create_session_table extends Migration
{
    public function up()
    {
       $this->dropTable('session');
        $this->createTable('session', [
            'id' => $this->primaryKey()->notNull(),
            'expire' => $this->integer(),
            'data'=> $this->binary()
        ]);
    }

    public function down()
    {
        $this->dropTable('session');
    }
}
