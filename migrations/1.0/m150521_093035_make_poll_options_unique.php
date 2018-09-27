<?php

use yii\db\Migration;

class m150521_093035_make_poll_options_unique extends Migration
{
    public function up()
    {
        $this->createIndex('idx_poll_option', 'poll_option', ['poll_id', 'body'], true);
    }

    public function down()
    {
        echo "m150521_093035_make_poll_options_unique cannot be reverted.\n";

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
