<?php

use yii\db\Migration;

class m150428_113915_drop_beverage_summary extends Migration
{
    public function up()
    {
        $this->execute('drop view if exists beverage_summary');
    }

    public function down()
    {
        echo "m150428_113915_drop_beverage_summary cannot be reverted.\n";

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
