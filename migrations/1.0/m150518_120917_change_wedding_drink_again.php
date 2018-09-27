<?php

use yii\db\Migration;

class m150518_120917_change_wedding_drink_again extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_wedding_drink_wedding', 'wedding_drink');
        $this->dropColumn('wedding_drink', 'wedding_id');

        $this->addColumn('wedding_drink', 'drink_id', 'int(11) not null');
        $this->addForeignKey('fk_wedding_drink_drink', 'wedding_drink', 'drink_id', 'drink', 'id');
    }

    public function down()
    {
        echo "m150518_120917_change_wedding_drink_again cannot be reverted.\n";

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
