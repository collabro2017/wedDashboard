<?php

use yii\db\Migration;

class m150923_084448_remove_table_view extends Migration
{
    public function up()
    {
        $this->execute('drop view if exists `table`');
    }

    public function down()
    {
        echo "m150923_084448_remove_table_view cannot be reverted.\n";

        return false;
    }
}
