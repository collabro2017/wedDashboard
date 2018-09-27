<?php

use yii\db\Migration;

class m150415_045613_add_non_removable_trivia extends Migration
{
    public function up()
    {
        $this->addColumn('trivia', 'is_removable', 'tinyint(4) not null default 1');
    }

    public function down()
    {
        echo "m150415_045613_add_non_removable_trivia cannot be reverted.\n";

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
