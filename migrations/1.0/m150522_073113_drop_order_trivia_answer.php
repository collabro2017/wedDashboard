<?php

use yii\db\Migration;

class m150522_073113_drop_order_trivia_answer extends Migration
{
    public function up()
    {
        $this->dropColumn('trivia_answer', 'order');
    }

    public function down()
    {
        echo "m150522_073113_drop_order_trivia_answer cannot be reverted.\n";

        return false;
    }
}
