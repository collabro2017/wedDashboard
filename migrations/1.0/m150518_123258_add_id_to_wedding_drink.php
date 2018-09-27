<?php

use yii\db\Migration;

class m150518_123258_add_id_to_wedding_drink extends Migration
{
    public function up()
    {
        $this->addColumn('wedding_drink', 'id', 'pk first');
    }

    public function down()
    {
        echo "m150518_123258_add_id_to_wedding_drink cannot be reverted.\n";

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
