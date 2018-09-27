<?php

use yii\db\Migration;

class m150424_110722_add_bride_groom_images extends Migration
{
    public function up()
    {
        $this->addColumn('wedding', 'groom_filename', 'varchar(255) null default null');
        $this->addColumn('wedding', 'bride_filename', 'varchar(255) null default null');
    }

    public function down()
    {
        echo "m150424_110722_add_bride_groom_images cannot be reverted.\n";

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
