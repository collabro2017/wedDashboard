<?php

use yii\db\Migration;

class m150427_062206_rename_heading extends Migration
{
    public function up()
    {
        $this->renameColumn('wedding', 'heading_filename', 'welcome_filename');
    }

    public function down()
    {
        echo "m150427_062206_rename_heading cannot be reverted.\n";

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
