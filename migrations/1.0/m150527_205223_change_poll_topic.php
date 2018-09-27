<?php

use yii\db\Migration;

class m150527_205223_change_poll_topic extends Migration
{
    public function up()
    {
        $this->alterColumn('poll', 'topic', 'varchar(255) null default null');
    }

    public function down()
    {
        echo "m150527_205223_change_poll_topic cannot be reverted.\n";

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
