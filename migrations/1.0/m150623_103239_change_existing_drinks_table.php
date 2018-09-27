<?php

use yii\db\Migration;

class m150623_103239_change_existing_drinks_table extends Migration
{
    public function up()
    {
        $this->dropColumn('existing_drink', 'category');
        $this->addColumn('existing_drink', 'type_id', 'int');

        $this->addForeignKey(
            'fk_existing_drink_drink_type_idx',
            'existing_drink',
            'type_id',
            'drink_type',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_existing_drink_drink_type_idx', 'existing_drink');

        $this->dropColumn('existing_drink', 'type_id');
        $this->addColumn('existing_drink', 'category', 'string');
    }
}
