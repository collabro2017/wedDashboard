<?php

use yii\db\Migration;

class m160107_130239_create_drink_table extends Migration
{
    public function up()
    {
        $this->createTable('alcohol', [
            'id' => 'pk',
            'name' => 'string not null',
            'parent_id' => 'integer default null',
            'wedding_id' => 'integer default null',
            'can_combine' => 'tinyint(1) default 1'
        ]);
    }

    public function down()
    {
        $this->dropTable('drink');
    }
}
