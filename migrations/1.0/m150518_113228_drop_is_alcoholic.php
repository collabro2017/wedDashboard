<?php

use yii\db\Migration;

class m150518_113228_drop_is_alcoholic extends Migration
{
    public function up()
    {
        $this->dropColumn('drink_category', 'is_alcoholic');
    }

    public function down()
    {
        echo "m150518_113228_drop_is_alcoholic cannot be reverted.\n";

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
