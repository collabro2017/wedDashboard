<?php

use yii\db\Migration;

class m150518_122624_add_order_to_drinks extends Migration
{
    public function up()
    {
        $this->dropColumn('drink', 'order');
        $this->addColumn('wedding_drink', 'order', 'int(11) not null default 0');
    }

    public function down()
    {
        echo "m150518_122624_add_order_to_drinks cannot be reverted.\n";

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
