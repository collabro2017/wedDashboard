<?php

use yii\db\Migration;

class m150518_122253_change_drink extends Migration
{
    public function up()
    {
        $this->alterColumn('drink', 'brand', 'varchar(255) not null');
        $this->alterColumn('drink', 'type', 'varchar(255) not null');
        $this->addColumn('drink', 'class', 'varchar(255) not null');
        $this->dropColumn('drink', 'name');
    }

    public function down()
    {
        echo "m150518_122253_change_drink cannot be reverted.\n";

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
