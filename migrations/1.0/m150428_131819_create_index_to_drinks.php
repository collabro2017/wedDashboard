<?php

use yii\db\Migration;

class m150428_131819_create_index_to_drinks extends Migration
{
    public function up()
    {
        $this->createIndex('pk_wedding_drink', 'wedding_drink', ['wedding_id', 'drink_id'], true);
    }

    public function down()
    {
        echo "m150428_131819_create_index_to_drinks cannot be reverted.\n";

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
