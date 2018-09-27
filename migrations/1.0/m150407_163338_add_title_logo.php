<?php

use yii\db\Migration;

class m150407_163338_add_title_logo extends Migration
{
    public function up()
    {
        $this->addColumn('wedding', 'heading_filename', 'varchar(255) null default null');
    }

    public function down()
    {
        echo "m150407_163338_add_title_logo cannot be reverted.\n";

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
