<?php

use yii\db\Migration;

class m161121_182109_add_password extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'password', 'varchar(255) not null after last_name');
    }

    public function down()
    {
        echo "m161121_182109_add_password cannot be reverted.\n";

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
