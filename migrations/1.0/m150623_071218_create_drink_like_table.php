<?php

use yii\db\Migration;

class m150623_071218_create_drink_like_table extends Migration
{
    public function up()
    {
        $this->createTable('drink_like', [
            'id' => 'pk',
            'existing_drink_id' => 'int not null',
            'guest_id' => 'int not null',
            'liked_at' => 'datetime'
        ]);

        $this->addForeignKey('fk_drink_like_existing_drink_idx', 'drink_like', 'existing_drink_id', 'existing_drink', 'id');
        $this->addForeignKey('fk_drink_like_guest_idx', 'drink_like', 'guest_id', 'guest', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('fk_drink_like_existing_drink_idx', 'drink_like');
        $this->dropForeignKey('fk_drink_like_guest_idx', 'drink_like');

        $this->dropTable('drink_like');
    }
}
