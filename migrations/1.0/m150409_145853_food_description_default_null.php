<?php

use yii\db\Migration;

class m150409_145853_food_description_default_null extends Migration
{
    public function up()
    {
        $this->alterColumn('food', 'description', 'varchar(255) null default null');
    }

    public function down()
    {
        echo "m150409_145853_food_description_default_null cannot be reverted.\n";

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
