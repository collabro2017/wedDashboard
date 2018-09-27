<?php

use yii\db\Migration;

class m150325_155317_remove_keyword extends Migration
{
    public function up()
    {
        $this->dropColumn('wedding', 'keyword');
    }

    public function down()
    {
        echo "m150325_155317_remove_keyword cannot be reverted.\n";

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
