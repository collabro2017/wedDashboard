<?php

use yii\db\Migration;

class m150522_081351_add_order_to_questions extends Migration
{
    public function up()
    {
        $this->addColumn('question', 'order', 'int(11) not null default 0');
    }

    public function down()
    {
        echo "m150522_081351_add_order_to_questions cannot be reverted.\n";

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
