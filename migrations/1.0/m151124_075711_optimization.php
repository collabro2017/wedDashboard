<?php

use yii\db\Migration;

class m151124_075711_optimization extends Migration
{
    public function up()
    {
        $this->createIndex('fullname_order', 'participant', ['fullname', 'order']);
    }

    public function down()
    {
        echo "m151124_075711_optimization cannot be reverted.\n";

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
