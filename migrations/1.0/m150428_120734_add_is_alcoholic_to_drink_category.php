<?php

use yii\db\Migration;

class m150428_120734_add_is_alcoholic_to_drink_category extends Migration
{
    public function up()
    {
        $this->addColumn('drink_category', 'is_alcoholic', 'tinyint(1) not null default 1');
    }

    public function down()
    {
        echo "m150428_120734_add_is_alcoholic_to_drink_category cannot be reverted.\n";

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
