<?php

use yii\db\Migration;

class m150409_080028_add_categories_to_food extends Migration
{
    public function up()
    {
        $this->createTable('food_category', [
            'id'         => 'int(11) not null auto_increment',
            'name'       => 'varchar(255) not null',
            'vanity_url' => 'varchar(255) not null',
            'wedding_id' => 'int(11) not null',
            'primary key(id)',
        ]);

        $this->createIndex('idx_food_vanity_url', 'food_category', 'vanity_url');
        $this->addForeignKey('fk_food_category_wedding', 'food_category', 'wedding_id', 'wedding', 'id');

        $this->addColumn('food', 'food_category_id', 'int(11) null default null');
    }

    public function down()
    {
        echo "m150409_080028_add_categories_to_food cannot be reverted.\n";

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
