<?php

use yii\db\Migration;

class m150515_083103_add_order_to_food_category extends Migration
{
    public function up()
    {
        $this->addColumn('food_category', 'order', 'int not null default 0');
    }

    public function down()
    {
        echo "m150515_083103_add_order_to_food_category cannot be reverted.\n";

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
