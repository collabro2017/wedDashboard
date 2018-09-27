<?php

use yii\db\Migration;

class m160201_111345_add_is_valid_to_token extends Migration
{
    public function up()
    {
        $this->addColumn('token', 'is_valid', 'tinyint(1) default 1');
    }

    public function down()
    {
        $this->dropColumn('token', 'is_valid');
    }
}
