<?php

use yii\db\Migration;

class m150514_171649_change_food_and_drinks extends Migration
{
    public function up()
    {
        $this->alterColumn('food', 'name', 'varchar(255) null default null');
    }

    public function down()
    {
        echo "m150514_171649_change_food_and_drinks cannot be reverted.\n";

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
