<?php

use yii\db\Migration;

class m150521_105448_rename_class extends Migration
{
    public function up()
    {
        $this->renameColumn('drink', 'class', 'name');
    }

    public function down()
    {
        echo "m150521_105448_rename_class cannot be reverted.\n";

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
