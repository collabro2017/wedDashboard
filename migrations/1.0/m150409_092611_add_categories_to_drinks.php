<?php

use yii\db\Migration;

class m150409_092611_add_categories_to_drinks extends Migration
{
    public function up()
    {
        $this->createTable('drink_category', [
            'id'         => 'int(11) not null auto_increment',
            'name'       => 'varchar(255) not null',
            'vanity_url' => 'varchar(255) not null',
            'wedding_id' => 'int(11) not null',
            'primary key(id)',
        ]);

        $this->createIndex('idx_drink_vanity_url', 'drink_category', 'vanity_url');
        $this->addForeignKey('fk_drink_category_wedding', 'drink_category', 'wedding_id', 'wedding', 'id');

        $this->addColumn('drink', 'drink_category_id', 'int(11) null default null');
    }

    public function down()
    {
        echo "m150409_092611_add_categories_to_drinks cannot be reverted.\n";

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
