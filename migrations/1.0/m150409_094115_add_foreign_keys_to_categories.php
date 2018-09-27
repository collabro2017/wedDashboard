<?php

use yii\db\Migration;

class m150409_094115_add_foreign_keys_to_categories extends Migration
{
    public function up()
    {
        $this->addForeignKey('fk_drink_drink_category', 'drink', 'drink_category_id', 'drink_category', 'id');
        $this->addForeignKey('fk_food_food_category', 'food', 'food_category_id', 'food_category', 'id');
    }

    public function down()
    {
        echo "m150409_094115_add_foreign_keys_to_categories cannot be reverted.\n";

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
