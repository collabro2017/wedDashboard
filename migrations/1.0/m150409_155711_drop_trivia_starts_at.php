<?php

use yii\db\Migration;

class m150409_155711_drop_trivia_starts_at extends Migration
{
    public function up()
    {
        $this->dropColumn('trivia', 'starts_at');
    }

    public function down()
    {
        echo "m150409_155711_drop_trivia_starts_at cannot be reverted.\n";

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
