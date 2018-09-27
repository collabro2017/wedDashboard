<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_131204_fix_previus_migration extends Migration
{
    public function up()
    {
        $this->dropColumn('existing_drink_base_drink', 'id');
        $this->addPrimaryKey(
            'pk_existing_drink_base_drink',
            'existing_drink_base_drink',
            ['existing_drink_id', 'base_drink_id']
        );
    }

    public function down()
    {
        echo "m150624_131204_fix_previus_migration cannot be reverted.\n";

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
