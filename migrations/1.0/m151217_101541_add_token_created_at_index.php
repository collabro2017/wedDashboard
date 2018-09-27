<?php

use yii\db\Migration;

class m151217_101541_add_token_created_at_index extends Migration
{
    public function up()
    {
        $this->createIndex('idx_created_at', 'token', 'created_at');
    }

    public function down()
    {
        echo "m151217_101541_add_token_created_at_index cannot be reverted.\n";

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
