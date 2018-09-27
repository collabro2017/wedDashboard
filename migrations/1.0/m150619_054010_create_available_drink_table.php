<?php

use yii\db\Migration;

class m150619_054010_create_available_drink_table extends Migration
{
    public function up()
    {
        $this->createTable('available_drink', [
            'id' => 'pk',
            'base_drink_id' => 'int not null',
            'drink_brand_id' => 'int',
            'exclusive_brand_name' => 'string',
            'drink_category_id' => 'int not null',
            'order' => 'int'
        ]);

        $this->addForeignKey('fk_available_drink_base_drink_idx', 'available_drink', 'base_drink_id', 'base_drink', 'id');
        $this->addForeignKey('fk_available_drink_drink_brand_idx', 'available_drink', 'drink_brand_id', 'drink_brand', 'id');
        $this->addForeignKey('fk_available_drink_category_idx', 'available_drink', 'drink_category_id', 'drink_category','id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_available_drink_base_drink_idx', 'available_drink');
        $this->dropForeignKey('fk_available_drink_drink_brand_idx', 'available_drink');
        $this->dropForeignKey('fk_available_drink_category_idx', 'available_drink');

        $this->dropTable('available_drink');
    }
}
