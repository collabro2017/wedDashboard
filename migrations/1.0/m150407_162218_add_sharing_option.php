<?php

use yii\db\Migration;

class m150407_162218_add_sharing_option extends Migration
{
    public function up()
    {
        $this->addColumn('wedding', 'enable_sharing', 'tinyint(4) not null default 1');
    }

    public function down()
    {
        echo "m150407_162218_add_sharing_option cannot be reverted.\n";

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
