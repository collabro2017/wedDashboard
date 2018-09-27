<?php

use yii\db\Migration;

class m150518_113540_change_wedding_drink extends Migration
{
    public function up()
    {
        $this->addColumn('wedding_drink', 'drink_category_id', 'int(11) not null');
        $this->addForeignKey('fk_wedding_drink_drink_category', 'wedding_drink', 'drink_category_id', 'drink_category', 'id');
        $this->dropForeignKey('fk_wedding_drink_drink', 'wedding_drink');
        $this->dropColumn('wedding_drink', 'drink_id');
    }

    public function down()
    {
        echo "m150518_113540_change_wedding_drink cannot be reverted.\n";

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
