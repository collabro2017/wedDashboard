<?php

use yii\db\Migration;

class m150408_102626_add_sort extends Migration
{
    public function up()
    {
        $this->addColumn('vendor', 'order', 'int(11) not null default 0');
        $this->addColumn('drink', 'order', 'int(11) not null default 0');
        $this->addColumn('food', 'order', 'int(11) not null default 0');
        $this->addColumn('participant', 'order', 'int(11) not null default 0');
        $this->addColumn('poll', 'order', 'int(11) not null default 0');
        $this->addColumn('trivia', 'order', 'int(11) not null default 0');
        $this->addColumn('trivia_answer', 'order', 'int(11) not null default 0');
    }

    public function down()
    {
        echo "m150408_102626_add_sort cannot be reverted.\n";

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
