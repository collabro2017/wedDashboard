<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_111357_change_drink_relation_tables extends Migration
{
    public function up()
    {

//        $this->dropColumn('existing_drink_base_drink', 'id');
//        $this->addPrimaryKey(
//            'pk_existing_drink_base_drink',
//            'existing_drink_base_drink',
//            ['existing_drink_id', 'base_drink_id']
//        );

        $this->dropColumn('existing_drink_mixer', 'id');
        $this->addPrimaryKey(
            'pk_existing_drink_mixer',
            'existing_drink_mixer',
            ['existing_drink_id', 'drink_mixer_id']
        );

        $this->dropColumn('existing_drink_brand', 'id');
        $this->addPrimaryKey(
            'pk_existing_drink_brand',
            'existing_drink_brand',
            ['existing_drink_id', 'drink_brand_id']
        );
    }

    public function down()
    {
//        echo "m150624_111357_change_drink_relation_tables cannot be reverted.\n";
//
//        return false;
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
