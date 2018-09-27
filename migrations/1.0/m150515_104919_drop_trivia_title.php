<?php

use yii\db\Migration;

class m150515_104919_drop_trivia_title extends Migration
{
    public function up()
    {
        $this->dropColumn('trivia', 'title');
    }

    public function down()
    {
        echo "m150515_104919_drop_trivia_title cannot be reverted.\n";

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
