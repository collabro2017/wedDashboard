<?php

use yii\db\Migration;

class m150325_153956_add_extra_fields_to_wedding extends Migration
{
    public function up()
    {
        $this->addColumn('wedding', 'admin_email', 'varchar(255) not null');
        $this->addColumn('wedding', 'admin_password', 'varchar(255) not null');
        $this->addColumn('wedding', 'wedding_date', 'date null default null');
    }

    public function down()
    {
        echo "m150325_153956_add_extra_fields_to_wedding cannot be reverted.\n";

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
