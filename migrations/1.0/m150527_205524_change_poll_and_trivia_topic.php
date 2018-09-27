<?php

use yii\db\Migration;

class m150527_205524_change_poll_and_trivia_topic extends Migration
{
    public function up()
    {
        $this->alterColumn('poll', 'topic', 'varchar(255) not null');
        $this->alterColumn('question', 'topic', 'varchar(255) not null');
    }

    public function down()
    {
        echo "m150527_205524_change_poll_and_trivia_topic cannot be reverted.\n";

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
