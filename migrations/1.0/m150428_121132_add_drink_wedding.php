<?php

use yii\db\Migration;

class m150428_121132_add_drink_wedding extends Migration
{
    public function up()
    {
        $this->createTable('wedding_drink', [
            'wedding_id' => 'int(11) not null',
            'drink_id'   => 'int(11) not null',
        ]);

        $this->addForeignKey('fk_wedding_drink_wedding', 'wedding_drink', 'wedding_id', 'wedding', 'id');
        $this->addForeignKey('fk_wedding_drink_drink', 'wedding_drink', 'drink_id', 'drink', 'id');

        $this->addColumn('drink', 'is_custom', 'tinyint(1) not null default 0');
    }

    public function down()
    {
        echo "m150428_121132_add_drink_wedding cannot be reverted.\n";

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
