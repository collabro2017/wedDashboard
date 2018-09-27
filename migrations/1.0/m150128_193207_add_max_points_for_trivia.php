<?php

use yii\db\Migration;

class m150128_193207_add_max_points_for_trivia extends Migration
{
    public function up()
    {
        $this->addColumn('trivia', 'max_score', 'int(11) not null default 100');
    }

    public function down()
    {
        return true;
    }
}
