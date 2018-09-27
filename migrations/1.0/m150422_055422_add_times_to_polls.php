<?php

use yii\db\Migration;

class m150422_055422_add_times_to_polls extends Migration
{
    public function up()
    {
        $this->addColumn('poll', 'starts_at', 'datetime null default null');
        $this->addColumn('poll', 'ends_at', 'datetime null default null');

        $this->dropColumn('trivia', 'starts_at');
        $this->dropColumn('trivia', 'ends_at');
    }

    public function down()
    {
        echo "m150422_055422_add_times_to_polls cannot be reverted.\n";

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
