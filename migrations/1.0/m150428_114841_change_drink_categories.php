<?php

use yii\db\Migration;

class m150428_114841_change_drink_categories extends Migration
{
    public function up()
    {
//        $this->dropForeignKey('drink_category_ibfk_1', 'drink_category');
//        $this->dropColumn('drink_category', 'wedding_id');
    }

    public function down()
    {
        echo "m150428_114841_change_drink_categories cannot be reverted.\n";

        return true;
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
