<?php

use yii\db\Migration;

class m150409_162446_add_relaton_to_participant extends Migration
{
    public function up()
    {
        $this->addColumn('participant', 'relation_to', 'varchar(255) null default null');
    }

    public function down()
    {
        echo "m150409_162446_add_relaton_to_participant cannot be reverted.\n";

        return false;
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
