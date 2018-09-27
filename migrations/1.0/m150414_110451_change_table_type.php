<?php

use yii\db\Migration;

class m150414_110451_change_table_type extends Migration
{
    public function up()
    {
        $this->alterColumn('guest', 'table', 'varchar(255) not null');
    }

    public function down()
    {
        echo "m150414_110451_change_table_type cannot be reverted.\n";

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
