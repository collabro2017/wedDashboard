<?php

use yii\db\Migration;

class m150521_090318_make_answers_unique extends Migration
{
    public function up()
    {
        $this->createIndex('idx_question_answer', 'answer', ['question_id', 'body'], true);
    }

    public function down()
    {
        echo "m150521_090318_make_answers_unique cannot be reverted.\n";

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
