<?php

use yii\db\Migration;

class m150422_043947_add_starts_at_to_trivia extends Migration
{
    public function up()
    {
        $this->addColumn('trivia', 'starts_at', 'datetime null default null after wedding_id');
    }

    public function down()
    {
        echo "m150422_043947_add_starts_at_to_trivia cannot be reverted.\n";

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
