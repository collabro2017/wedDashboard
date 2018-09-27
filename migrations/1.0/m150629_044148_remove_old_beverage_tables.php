<?php

use yii\db\Migration;

class m150629_044148_remove_old_beverage_tables extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_beverage_beverage_type1', 'beverage');
        $this->dropForeignKey('fk_beverage_drink1', 'beverage');
        $this->dropForeignKey('fk_beverage_drink2', 'beverage');
        $this->dropForeignKey('fk_beverage_has_guest_beverage1', 'beverage_like');
        $this->dropForeignKey('fk_beverage_has_guest_guest1', 'beverage_like');
        $this->dropForeignKey('fk_wedding_drink_drink', 'wedding_drink');
        $this->dropForeignKey('fk_wedding_drink_drink_category', 'wedding_drink');

        $this->dropTable('beverage');
        $this->dropTable('beverage_like');
        $this->dropTable('beverage_type');
        $this->dropTable('drink');
        $this->dropTable('wedding_drink');
    }

    public function down()
    {
        echo "m150629_044148_remove_old_beverage_tables cannot be reverted.\n";

        return false;
    }
}
