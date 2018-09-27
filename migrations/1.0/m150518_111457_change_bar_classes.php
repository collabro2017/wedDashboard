<?php

use yii\db\Migration;

class m150518_111457_change_bar_classes extends Migration
{
    public function up()
    {
        $this->execute('delete from beverage_like');
        $this->execute('delete from beverage');
        $this->execute('delete from wedding_drink');
        $this->execute('delete from drink');
        $this->execute('delete from drink_category');

//        $this->dropColumn('drink_category', 'vanity_url');
//        $this->addColumn('drink_category', 'wedding_id', 'int(11) not null');

//        $this->addForeignKey('fk_drink_category_wedding', 'drink_category', 'wedding_id', 'wedding', 'id');

        $this->dropForeignKey('fk_drink_drink_category', 'drink');
        $this->dropColumn('drink', 'drink_category_id');

        $this->addColumn('drink', 'type', 'int(11) not null');
        $this->addColumn('drink', 'brand', 'int(11) not null');
    }

    public function down()
    {
        echo "m150518_111457_change_bar_classes cannot be reverted.\n";

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
