<?php

use yii\db\Migration;

class m150514_160444_change_trivia_topic extends Migration
{
    public function up()
    {
        $this->alterColumn('question', 'topic', 'varchar(255) null default null');
    }

    public function down()
    {
        echo "m150514_160444_change_trivia_topic cannot be reverted.\n";

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
