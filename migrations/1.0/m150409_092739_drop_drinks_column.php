<?php

use yii\db\Migration;

class m150409_092739_drop_drinks_column extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_drink_wedding1', 'drink');
        $this->dropColumn('drink', 'wedding_id');
        $this->dropColumn('drink', 'category');
    }

    public function down()
    {
        echo "m150409_092739_drop_drinks_column cannot be reverted.\n";

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
