<?php

use yii\db\Migration;

class m150128_190629_add_udid_to_guest extends Migration
{
    public function up()
    {
        $this->addColumn('guest', 'device_token', 'varchar(40) null default null');
    }

    public function down()
    {
        echo "m150128_190629_add_udid_to_guest cannot be reverted.\n";

        return false;
    }
}
