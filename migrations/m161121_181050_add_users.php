<?php

use yii\db\Migration;

class m161121_181050_add_users extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id'           => 'pk',
            'email'        => 'varchar(255) not null',
            'first_name'   => 'varchar(255) not null',
            'last_name'    => 'varchar(255) not null',
            'created_at'   => 'datetime null default null',
            'is_active'    => 'tinyint(1) not null default 1',
            'role'         => 'enum("admin") not null default "admin"',
            'access_token' => 'varchar(128) null default null',
        ]);

        $this->createIndex('email', 'user', 'email', true);
    }

    public function down()
    {
        echo "m161121_181050_add_users cannot be reverted.\n";

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
