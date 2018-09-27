<?php

use yii\db\Migration;

class m150925_081922_increase_question_length extends Migration
{
    public function up()
    {
        $this->alterColumn('question', 'topic', 'varchar(512)');
    }

    public function down()
    {
        $this->alterColumn('question', 'topic', 'varchar(255)');
    }
}
