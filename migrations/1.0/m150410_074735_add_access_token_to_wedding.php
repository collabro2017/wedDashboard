<?php

use yii\db\Migration;

class m150410_074735_add_access_token_to_wedding extends Migration
{
    public function up()
    {
        $this->addColumn('wedding', 'admin_access_token', 'varchar(255) null default null');
    }

    public function down()
    {
        echo "m150410_074735_add_access_token_to_wedding cannot be reverted.\n";

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
