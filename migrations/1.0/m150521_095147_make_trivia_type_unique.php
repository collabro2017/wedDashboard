<?php

use yii\db\Schema;
use yii\db\Migration;

class m150521_095147_make_trivia_type_unique extends Migration
{
    public function up()
    {
        $this->createIndex('idx_trivia_type', 'trivia', ['wedding_id', 'type'], true);
    }

    public function down()
    {
        echo "m150521_095147_make_trivia_type_unique cannot be reverted.\n";

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
