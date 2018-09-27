<?php

use yii\db\Migration;

class m150522_074230_add_order_to_drink_categories extends Migration
{
    public function up()
    {
        $this->addColumn('drink_category', 'order', 'int(11) not null default 0');
    }

    public function down()
    {
        echo "m150522_074230_add_order_to_drink_categories cannot be reverted.\n";

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
