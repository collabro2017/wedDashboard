<?php

use yii\db\Migration;

class m151124_072936_optimization extends Migration
{
    public function up()
    {
        $this->createIndex('hash', 'token', 'hash');
        $this->createIndex('created_at', 'media', 'created_at');
        $this->createIndex('order', 'drink_category', 'order');
        $this->createIndex('name', 'drink_category', 'name');
        $this->createIndex('title', 'song', 'title');
        $this->createIndex('artist', 'song', 'artist');
        $this->createIndex('email', 'guest', 'email');
        $this->createIndex('table', 'guest', 'table');
        $this->createIndex('name', 'drink_type', 'name');
        $this->createIndex('admin_access_token', 'wedding', 'admin_access_token');
    }

    public function down()
    {
        echo "m151124_072936_optimization cannot be reverted.\n";

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
