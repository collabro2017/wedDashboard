<?php

use yii\db\Migration;

class m150409_092147_drop_food_columns extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_menu_wedding1', 'food');
        $this->dropColumn('food', 'wedding_id');
        $this->dropColumn('food', 'category');
    }

    public function down()
    {
        echo "m150409_092147_drop_food_columns cannot be reverted.\n";

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
