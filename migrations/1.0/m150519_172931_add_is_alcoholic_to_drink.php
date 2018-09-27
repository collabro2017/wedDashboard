<?php

use yii\db\Migration;

class m150519_172931_add_is_alcoholic_to_drink extends Migration
{
    public function up()
    {
        $this->addColumn('drink', 'is_alcoholic', 'tinyint(1) not null default 0');
    }

    public function down()
    {
        echo "m150519_172931_add_is_alcoholic_to_drink cannot be reverted.\n";

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
