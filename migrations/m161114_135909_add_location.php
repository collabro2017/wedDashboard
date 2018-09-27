<?php

use yii\db\Migration;

class m161114_135909_add_location extends Migration
{
    public function up()
    {
        $this->addColumn('wedding', 'city', 'varchar(255) null default null');
        $this->addColumn('wedding', 'state', 'varchar(255) null default null');
        $this->addColumn('wedding', 'country', 'varchar(255) null default null');
    }

    public function down()
    {
        echo "m161114_135909_add_location cannot be reverted.\n";

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
